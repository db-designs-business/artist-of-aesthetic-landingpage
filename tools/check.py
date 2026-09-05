# -*- coding: utf-8 -*-
"""Prueft Vollstaendigkeit, Marker und interne Links.

    python tools/check.py
"""
import io
import os
import re
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import sitemap  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
os.chdir(ROOT)

pages = sitemap.all_pages()
files = [(p["slug"], "index.html" if p["slug"] == ""
          else os.path.join(p["slug"], "index.html")) for p in pages]

fail = 0

print("=== Dateien ===")
missing = [f for _, f in files if not os.path.exists(f)]
print("  gesamt: %d | fehlend: %s" % (len(files), missing or "keine"))
if missing:
    fail = 1

print("\n=== Gemeinsame Bloecke ===")
bad = []
for slug, f in files:
    t = io.open(f, encoding="utf-8").read()
    for b in ("topbar", "header", "footer", "mobilebar"):
        if t.count("@shared:" + b) != 2:
            bad.append((f, b))
print("  unvollstaendig: %s" % (bad or "keine"))
if bad:
    fail = 1

print("\n=== Interne Links ===")
known = set(s for s, _ in files)
dead, checked = set(), 0
for slug, f in files:
    t = io.open(f, encoding="utf-8").read()
    base = "" if slug == "" else slug
    for href in re.findall(r'href="([^"#][^"]*)"', t):
        if href.startswith(("http", "tel:", "mailto:")):
            continue
        if "assets/" in href:
            continue
        checked += 1
        target = os.path.normpath(os.path.join(base, href)).replace(os.sep, "/")
        if target == ".":
            target = ""
        if target not in known:
            dead.add((f, href, target))
print("  geprueft: %d | tot: %d" % (checked, len(dead)))
for d in sorted(dead)[:20]:
    print("    %s  ->  %s" % (d[0], d[1]))
if dead:
    fail = 1

print("\n=== Aktiver Navigationspunkt ===")
for probe in ("index.html", "mikroneedling-bruchsal/index.html",
              "about/index.html", "bb-glow-bruchsal/index.html",
              "services/index.html"):
    t = io.open(probe, encoding="utf-8").read()
    m = re.search(r'<a href="[^"]*" class="is-active"[^>]*>([^<]*)</a>', t)
    print("  %-42s -> %s" % (probe, m.group(1) if m else "KEINER"))

print("\n=== Ergebnis: %s ===" % ("FEHLER" if fail else "in Ordnung"))
sys.exit(fail)
