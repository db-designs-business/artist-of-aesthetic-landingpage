# tools

## build.py

```bash
python tools/build.py
```

Legt fehlende Seiten aus `sitemap.py` an und schreibt Topbar, Header, Footer
und Mobile-Bar aus `_shared/` in **alle** Seiten. Bearbeitet ausschließlich
den Bereich zwischen den Markern:

```html
<!-- @shared:header --> … <!-- /@shared:header -->
```

Alles außerhalb bleibt unangetastet — jede Seite ist und bleibt eine
vollständige, direkt bearbeitbare HTML-Datei. Wird das Skript nie ausgeführt,
funktioniert die Seite unverändert.

**Neue Seite anlegen:** Eintrag in `sitemap.py` ergänzen, dann `build.py`.
**Navigation ändern:** `_shared/header.html` bearbeiten, dann `build.py`.

`{{base}}` im Shared-Block wird pro Seite ersetzt: leer auf der Startseite,
`../` auf allen Unterseiten. Der aktive Navigationspunkt wird automatisch
gesetzt — bei Unterseiten die zugehörige Kategorie.

## check.py

```bash
python tools/check.py
```

Prüft Vollständigkeit der Seiten, Marker-Paare und alle internen Links.
Exit-Code 1 bei Fehlern.
