# -*- coding: utf-8 -*-
"""Einzige Wahrheitsquelle fuer die Seitenstruktur.

Wird von tools/build.py gelesen. Neue Seite anlegen: hier eintragen,
danach `python tools/build.py` ausfuehren.
"""

BUSINESS = "Artist of Aesthetic"
CITY = "Bruchsal"

# slug -> ("", "") bedeutet Startseite auf der Wurzel
HOME = {"slug": "", "title": "Kosmetikstudio Bruchsal", "h1": None, "kind": "home"}

MAIN = [
    {"slug": "services", "name": "Alle Leistungen",
     "h1": "Alle Leistungen im Überblick", "kind": "main"},
    {"slug": "about", "name": "Über uns",
     "h1": "Über Artist of Aesthetic", "kind": "main"},
    {"slug": "contact", "name": "Kontakt",
     "h1": "Kontakt & Terminanfrage", "kind": "main"},
]

CATEGORIES = [
    {
        "slug": "gesichtsbehandlungen-bruchsal",
        "name": "Kosmetische Gesichtsbehandlungen",
        "nav": "Gesichtsbehandlungen",
        "core": [
            ("mikroneedling-bruchsal", "Mikroneedling"),
            ("aquafacial-bruchsal", "Aquafacial Intensivbehandlung"),
        ],
        "child": [
            ("bb-glow-bruchsal", "BB Glow Behandlung"),
            ("prx-t33-peeling-bruchsal", "PRX-T33 Peeling Behandlung"),
            ("biorepeel-cl3-bruchsal", "BioRePeelCl3 Behandlung"),
            ("fruchtsaeure-peeling-bruchsal", "Fruchtsäure Peeling Behandlung"),
            ("porentiefe-gesichtsbehandlung-bruchsal", "Porentiefe Gesichtsbehandlung"),
            ("basic-gesichtsbehandlung-bruchsal", "Basic Gesichtsbehandlung"),
            ("akne-behandlung-bruchsal", "Akne Behandlung"),
            ("teeny-gesichtsbehandlung-bruchsal", "Teeny Gesichtsbehandlung"),
            ("de-luxe-goldmaske-behandlung-bruchsal", "De Luxe Gesichtsbehandlung mit 24K Goldmaske"),
        ],
    },
    {
        "slug": "schoenheitssalon-bruchsal",
        "name": "Schönheitssalon",
        "nav": "Schönheitssalon",
        "core": [
            ("braut-make-up-bruchsal", "Braut-Make-up inkl. Probe-Make-up"),
            ("augenbrauen-formen-bruchsal", "Augenbrauen zupfen & formen"),
        ],
        "child": [
            ("tages-make-up-bruchsal", "Tages-Make-up"),
            ("abend-make-up-bruchsal", "Abend-Make-up"),
            ("glam-smokey-eye-bruchsal", "GLAM Smokey Eye"),
            ("gesichtsenthaarung-bruchsal", "Gesichtsenthaarung mit Fadentechnik oder Wax"),
            ("ohren-nasenhaare-entfernen-bruchsal", "Ohren- & Nasenhaare entfernen mit Wax"),
            ("augenbrauen-faerben-bruchsal", "Augenbrauen färben"),
        ],
    },
    {
        "slug": "wimpernstudio-bruchsal",
        "name": "Wimpernstudio",
        "nav": "Wimpernstudio",
        "core": [
            ("wimpernverlaengerung-volumen-bruchsal", "Light Volume Wimpernverlängerung 2D–5D"),
            ("wimpernlifting-bruchsal", "Wimpernlifting inkl. Färben"),
        ],
        "child": [
            ("classic-wimpernverlaengerung-bruchsal", "Classic Wimpernverlängerung 1:1 Neuset"),
            ("mega-volume-wimpernverlaengerung-bruchsal", "Mega Volume Wimpernverlängerung ab 6D"),
            ("wimpernverlaengerung-refill-bruchsal", "Wimpernverlängerung Refill"),
            ("wimpernverlaengerung-entfernen-bruchsal", "Wimpernverlängerung entfernen"),
            ("browlifting-bruchsal", "Browlifting inkl. Färben"),
            ("henna-brows-bruchsal", "Henna Brows"),
        ],
    },
    {
        "slug": "permanent-make-up-bruchsal",
        "name": "Studio für Permanent Make-up",
        "nav": "Permanent Make-up",
        "core": [
            ("lippen-permanent-make-up-bruchsal", "Lippen Permanent Make-up"),
            ("microblading-augenbrauen-bruchsal", "Microblading Augenbrauen (PhiBrows)"),
        ],
        "child": [
            ("ombre-powder-brows-bruchsal", "Ombré Powder Brows"),
            ("wimpernkranz-verdichtung-bruchsal", "Wimpernkranz-Verdichtung"),
            ("eyeliner-pigmentierung-bruchsal", "Eyeliner Pigmentierung"),
        ],
    },
]

GENERAL = [
    ("hautanalyse-beratung-bruchsal", "Hautanalyse & Hauttyp-Beratung"),
]

# Entwuerfe / Varianten zum Vergleich
DRAFTS = [
    {"slug": "v2", "name": "Homepage Version 2",
     "h1": "Homepage Version 2", "kind": "draft"},
]

LEGAL = [
    {"slug": "impressum", "name": "Impressum", "h1": "Impressum", "kind": "legal"},
    {"slug": "datenschutz", "name": "Datenschutz", "h1": "Datenschutzerklärung", "kind": "legal"},
]


def all_pages():
    """Liefert alle Seiten als flache Liste mit Kontext."""
    pages = [dict(HOME)]
    for p in MAIN:
        pages.append(dict(p, name=p["name"]))
    for cat in CATEGORIES:
        pages.append({"slug": cat["slug"], "name": cat["name"], "nav": cat["nav"],
                      "h1": f'{cat["name"]} in {CITY}', "kind": "category"})
        for slug, name in cat["core"]:
            pages.append({"slug": slug, "name": name, "h1": f"{name} in {CITY}",
                          "kind": "core", "parent": cat["slug"], "parent_name": cat["name"]})
        for slug, name in cat["child"]:
            pages.append({"slug": slug, "name": name, "h1": f"{name} in {CITY}",
                          "kind": "child", "parent": cat["slug"], "parent_name": cat["name"]})
    for slug, name in GENERAL:
        pages.append({"slug": slug, "name": name, "h1": f"{name} in {CITY}",
                      "kind": "general"})
    for p in LEGAL:
        pages.append(dict(p))
    for p in DRAFTS:
        pages.append(dict(p))
    return pages


def counts():
    pages = all_pages()
    out = {}
    for p in pages:
        out[p["kind"]] = out.get(p["kind"], 0) + 1
    out["gesamt"] = len(pages)
    return out
