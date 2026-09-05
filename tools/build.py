# -*- coding: utf-8 -*-
"""Legt fehlende Seiten an und schreibt die gemeinsamen Bloecke in alle Seiten.

    python tools/build.py

Die Seite funktioniert auch ohne dieses Skript - jede HTML-Datei ist
vollstaendig und direkt bearbeitbar. Das Skript haelt nur Header, Footer,
Topbar und Mobile-Bar ueber alle Seiten hinweg synchron.

Bearbeitet wird ausschliesslich der Bereich zwischen den Markern:

    <!-- @shared:header --> … <!-- /@shared:header -->

Alles ausserhalb bleibt unangetastet.
"""
import io
import os
import re
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))
import sitemap  # noqa: E402

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
SHARED = os.path.join(ROOT, "_shared")
BLOCKS = ["topbar", "header", "footer", "mobilebar"]


def read(path):
    with io.open(path, encoding="utf-8") as fh:
        return fh.read()


def write(path, text):
    with io.open(path, "w", encoding="utf-8", newline="\n") as fh:
        fh.write(text)


def page_path(slug):
    return os.path.join(ROOT, "index.html") if slug == "" \
        else os.path.join(ROOT, slug, "index.html")


def base_for(slug):
    """Relativer Pfad zur Wurzel - alle Unterseiten liegen eine Ebene tief."""
    return "" if slug == "" else "../"


def render_block(name, page):
    """Setzt {{base}} ein und markiert den aktiven Navigationspunkt."""
    html = read(os.path.join(SHARED, name + ".html"))
    base = base_for(page["slug"])
    html = html.replace("{{base}}", base)

    if name == "topbar":
        # Aktive Entwurfsfassung markieren (nur auf den Startseiten-Fassungen)
        if page["kind"] == "draft":
            ver = page["slug"]          # v2, v3, ...
        elif page["slug"] == "":
            ver = "v1"                  # die Startseite ist Fassung 1
        else:
            ver = None                  # Unterseiten: kein Punkt markiert
        if ver:
            html = re.sub(
                r'(<a href="[^"]*" data-ver="%s")' % ver,
                r'\1 class="is-active" aria-current="page"', html, count=1)

    if name == "header":
        target = base if page["slug"] == "" else base + page["slug"] + "/"
        # Auf Unterseiten einer Kategorie den Kategoriepunkt hervorheben
        if page.get("parent"):
            target = base + page["parent"] + "/"
        html = re.sub(
            r'(<a href="%s")' % re.escape(target),
            r'\1 class="is-active" aria-current="page"',
            html, count=1)
    return html


def sync(page):
    path = page_path(page["slug"])
    text = read(path)
    changed = False
    for name in BLOCKS:
        pattern = re.compile(
            r"(<!-- @shared:%s -->).*?(<!-- /@shared:%s -->)" % (name, name),
            re.S)
        if not pattern.search(text):
            continue
        block = render_block(name, page)
        new = pattern.sub(
            lambda m: m.group(1) + "\n" + block.rstrip() + "\n" + m.group(2),
            text, count=1)
        if new != text:
            text, changed = new, True
    if changed:
        write(path, text)
    return changed


SKELETON = u"""<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{title}</title>
<meta name="description" content="{desc}">

<!-- ===== NUR FÜR DIE TEST-DEPLOYMENT AUF GITHUB PAGES =====
     VOR DEM LIVEGANG diese Zeile und robots.txt löschen. -->
<meta name="robots" content="noindex, nofollow">

<link rel="icon" href="{base}assets/img/logo.svg" type="image/svg+xml">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&family=Open+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{base}assets/css/style.css">
</head>
<body data-page="{slug}">

<a class="skip-link" href="#main">Zum Inhalt springen</a>

<!-- @shared:topbar --><!-- /@shared:topbar -->
<!-- @shared:header --><!-- /@shared:header -->

<main id="main">
  <section class="pagehead">
    <div class="wrap pagehead__inner">
      <p class="eyebrow">{eyebrow}</p>
      <h1 class="h1 pagehead__h">{h1}</h1>
      <p class="pagehead__note">Inhalt folgt in Kürze.</p>
    </div>
  </section>
</main>

<!-- @shared:footer --><!-- /@shared:footer -->
<!-- @shared:mobilebar --><!-- /@shared:mobilebar -->

<script src="{base}assets/js/main.js" defer></script>
</body>
</html>
"""

EYEBROW = {
    "main": "Artist of Aesthetic",
    "category": "Leistungsbereich",
    "core": "Behandlung",
    "child": "Behandlung",
    "general": "Beratung",
    "legal": "Rechtliches",
}


def scaffold(page):
    """Legt eine Seite an, falls sie noch nicht existiert."""
    path = page_path(page["slug"])
    if os.path.exists(path):
        return False
    os.makedirs(os.path.dirname(path), exist_ok=True)
    name = page.get("name", page["slug"])
    h1 = page.get("h1") or name
    if page["kind"] in ("core", "child"):
        desc = (u"%s in Bruchsal bei Artist of Aesthetic – %s. "
                u"Jetzt Termin anfragen." % (name, page.get("parent_name", "")))
    else:
        desc = u"%s bei Artist of Aesthetic, Kosmetikstudio in Bruchsal." % name
    write(path, SKELETON.format(
        title=u"%s Bruchsal | Artist of Aesthetic" % name,
        desc=desc.strip(),
        base=base_for(page["slug"]),
        slug=page["slug"],
        eyebrow=EYEBROW.get(page["kind"], "Artist of Aesthetic"),
        h1=h1,
    ))
    return True


def main():
    pages = sitemap.all_pages()
    created, synced, missing = [], [], []
    for page in pages:
        if scaffold(page):
            created.append(page["slug"] or "/")
        if not os.path.exists(page_path(page["slug"])):
            missing.append(page["slug"])
            continue
        if sync(page):
            synced.append(page["slug"] or "/")

    print("Seiten gesamt : %d" % len(pages))
    for kind, n in sorted(sitemap.counts().items()):
        if kind != "gesamt":
            print("  %-10s %d" % (kind, n))
    print("Neu angelegt  : %d" % len(created))
    for s in created:
        print("    + %s" % s)
    print("Bloecke sync. : %d" % len(synced))
    if missing:
        print("FEHLEND       : %s" % ", ".join(missing))
        return 1
    return 0


if __name__ == "__main__":
    sys.exit(main())
