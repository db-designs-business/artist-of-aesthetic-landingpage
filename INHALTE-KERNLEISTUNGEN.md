# Kernleistungsseiten — Inhalt und Verlinkung

Acht Seiten, je rund 1.000 Wörter, gleicher Aufbau: Bildhero mit Overlay,
Einstiegsabsatz, sechs H2-Abschnitte, Raster mit verwandten Behandlungen,
Abschluss-CTA. Service-Schema als JSON-LD inklusive Preis.

## Zuordnung der Unterleistungen

Die Architektur listet die Unterleistungen unter der **Kategorie**, nicht unter
der einzelnen Kernleistung. Die Verlinkungskarte verlangt von jeder
Kernleistungsseite „1–2 verwandte Child Services (Cross-Sell)". Zugeordnet ist
deshalb nach fachlicher Nähe — so ist jede der 24 Unterleistungen von mindestens
einer Kernleistungsseite aus erreichbar:

| Kernleistung | Verlinkte Unterleistungen |
|--------------|---------------------------|
| Mikroneedling | BB Glow · PRX-T33 Peeling · Fruchtsäure Peeling · Akne Behandlung |
| Aquafacial | Porentiefe · Basic · BioRePeelCl3 · Teeny · De Luxe Goldmaske |
| Braut-Make-up | Tages-Make-up · Abend-Make-up · GLAM Smokey Eye |
| Augenbrauen zupfen & formen | Augenbrauen färben · Gesichtsenthaarung · Ohren- & Nasenhaare |
| Light Volume Wimpern | Classic · Mega Volume · Refill · Entfernen |
| Wimpernlifting | Browlifting · Henna Brows |
| Lippen Permanent Make-up | Wimpernkranz-Verdichtung · Eyeliner Pigmentierung |
| Microblading | Ombré Powder Brows · Eyeliner Pigmentierung |

Jede Seite verlinkt zusätzlich ihre Kategorieseite (zweimal: im Fließtext und als
Schaltfläche unter dem Raster) und die Startseite im Schlussabsatz.

## Abweichungen von der Vorlage

Die Vorlage stammt aus dem Notdienst-Handwerk. Fünf Vorgaben passen dort, hier
nicht — ersetzt durch die tatsächlichen Gegebenheiten:

| Vorlage | Hier stattdessen |
|---------|------------------|
| Title „Same-Day Service Available" | Preis bzw. Kernnutzen der Behandlung |
| „crisis/urgent situation", „emphasize speed" | Vorlaufzeiten und Termindruck (Wimpern- und PMU-Termine sind knapp) |
| „repair vs replacement" | Refill gegen Neuset, Auffrischung gegen Neupigmentierung |
| „[Service] for [City] Homes/Businesses" | Behandlung für Bruchsal und das Einzugsgebiet |
| „Same-day service emphasis" | Antwort binnen 24 Stunden — das ist die tatsächliche Zusage |

Die Preise (110 €, 99 €, 250 €, ab 10 €, 120 €, 59 €, 499 €, 399 €) stammen von
der Live-Website und stehen zusätzlich im Schema. **Vor dem Livegang prüfen, ob
sie noch aktuell sind.**

## Bildzuordnung

| Seite | Bild | Anmerkung |
|-------|------|-----------|
| Mikroneedling | microneedling.jpg | passend |
| Aquafacial | aquafacial.jpg | passend |
| Braut-Make-up | makeup.jpg | passend |
| Augenbrauen formen | permanent-makeup.jpg | Brauen-Nahaufnahme, stammt aus dem PMU-Bestand |
| Light Volume Wimpern | wimpern-brauen.jpg | passend |
| Wimpernlifting | hero-behandlung.jpg | allgemeine Behandlungsszene, kein Lifting-Foto vorhanden |
| Lippen PMU | lippenpigmentierung.jpg | passend |
| Microblading | microblading2.jpg | Vorher-Nachher mit Vorzeichnung |

Für die drei mit Anmerkung wären eigene Fotos besser. Sobald welche vorliegen:
im Hero den Dateinamen an zwei Stellen tauschen — im `<link rel="preload">` als
`../assets/img/…` und in `--pagehero-img` als `../img/…`. Die beiden Pfade sind
unterschiedlich, weil der Wert einer CSS-Custom-Property relativ zum Stylesheet
aufgelöst wird, nicht relativ zur Seite.

## Geprüft

- Alle Herobilder liefern HTTP 200, keine Farbflächen
- Jede zugeordnete Unterleistung ist im Fließtext verlinkt, zusätzlich im Raster
- 0 Ankerlinks — alle Ziele laden oben
- 4 Vertrauensmerkmale je Hero
- 958 bis 1.077 Wörter je Seite, im Schnitt 999
- Verbotswortliste geprüft, auch die deutschen Entsprechungen
- Kein horizontales Scrollen bei 375 px und 1280 px, H1 mobil über der Falz
- Einzige Zeigerziele unter 24 px: Inline-Links mitten im Satz (WCAG-2.2-Ausnahme)
