# -*- coding: utf-8 -*-
"""Erzeugt sitemap.xml aus tools/sitemap.py.

    python tools/sitemap_xml.py

Nach jeder neuen Seite einmal laufen lassen. Die Seitenliste steht in
tools/sitemap.py - hier wird nichts doppelt gepflegt.
"""
import datetime
import io
import os
import sys

HIER = os.path.dirname(os.path.abspath(__file__))
ROOT = os.path.dirname(HIER)
sys.path.insert(0, HIER)
import sitemap  # noqa: E402

DOMAIN = "https://artist-of-aesthetic.de"

# Prioritaet und erwartete Aenderungsfrequenz je Seitenart.
# Die Prioritaet ist ein Hinweis fuer die Reihenfolge des Crawlings,
# kein Rankingfaktor - Google nimmt sie als groben Wink.
PRIO = {
    "home":     ("1.0", "weekly"),
    "category": ("0.8", "monthly"),
    "core":     ("0.8", "monthly"),
    "main":     ("0.5", "monthly"),
    "child":    ("0.6", "monthly"),
    "general":  ("0.6", "monthly"),
    "legal":    ("0.3", "yearly"),
}


def url(slug):
    return DOMAIN + "/" if slug == "" else "%s/%s/" % (DOMAIN, slug)


def main():
    heute = datetime.date.today().isoformat()
    zeilen = []
    for page in sitemap.all_pages():
        prio, freq = PRIO[page["kind"]]
        if page["slug"] == "services":
            prio = "0.7"          # Verteilerseite, kein eigenes Ziel
        zeilen.append(
            u"  <url>\n"
            u"    <loc>%s</loc>\n"
            u"    <lastmod>%s</lastmod>\n"
            u"    <changefreq>%s</changefreq>\n"
            u"    <priority>%s</priority>\n"
            u"  </url>" % (url(page["slug"]), heute, freq, prio))

    xml = (u'<?xml version="1.0" encoding="UTF-8"?>\n'
           u'<!--\n'
           u'  Erzeugt von tools/sitemap_xml.py aus tools/sitemap.py.\n'
           u'  Nach jeder neuen Seite neu erzeugen:  python tools/sitemap_xml.py\n'
           u'  Die Adressen zeigen bewusst auf %s OHNE www - so ist\n'
           u'  die Seite seit Jahren indexiert (Search Console, 29.09.2026).\n'
           u'  Dieselbe Schreibweise steht in den Canonical-Angaben und in\n'
           u'  der .htaccess. Wird eine davon geaendert, muessen alle drei mit.\n'
           u'-->\n'
           u'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n'
           u'%s\n'
           u'</urlset>\n') % (DOMAIN, u"\n".join(zeilen))

    ziel = os.path.join(ROOT, "sitemap.xml")
    with io.open(ziel, "w", encoding="utf-8", newline="\n") as fh:
        fh.write(xml)
    print("sitemap.xml: %d Adressen" % len(zeilen))


if __name__ == "__main__":
    main()
