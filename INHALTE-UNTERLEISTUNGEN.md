# Übersichtsseite und Unterleistungen

## /leistungen — Navigationsdrehscheibe

Aufbau: schlichter Hero ohne Bild (laut Vorgabe hier erlaubt), Einstiegsabsatz,
vier Bereichsabschnitte, ein Abschnitt für allgemeine Leistungen, Abschluss-CTA.
Jede Bereichsüberschrift ist auf die Kategorieseite verlinkt, darunter stehen
alle Behandlungen des Bereichs als Karte mit einer Beschreibungszeile und
„Mehr erfahren". Kernleistungen sind als solche markiert.

**33 Karten, 0 Ankerlinks.** Damit ist jede Behandlungsseite von hier aus mit
einem Klick erreichbar.

### Eine Abweichung von der Vorgabe

Die Vorgabe verlangt Abschnitte für jede Kategorie **und** zusätzlich für jede
Kernleistung, jeweils mit Karten für die darunterliegenden Behandlungen. In
dieser Architektur hängen die Unterleistungen aber an der Kategorie, nicht an
der Kernleistung — beide Abschnittsarten hintereinander hätten also jede Karte
zweimal auf derselben Seite gezeigt. Stattdessen steht jede Behandlung genau
einmal, in ihrem Bereich, und die beiden Kernleistungen jedes Bereichs sind
dort als erste Karten markiert.

## 25 Unterleistungsseiten

24 Behandlungen aus der Architektur plus die allgemeine Leistung
Hautanalyse & Hauttyp-Beratung. Aufbau je Seite: Bildhero mit Overlay,
Einstiegsabsatz, vier H2-Abschnitte (Wann · Ablauf · Kosten · Warum wir),
Schlussabsatz mit Elternlink, Abschluss-CTA. Service-Schema als JSON-LD.

Umfang: 607 bis 661 Wörter je Seite.

### Elternlinks

| Bereich | Seiten | Rücklink |
|---------|--------|----------|
| Kosmetische Gesichtsbehandlungen | 9 | `/gesichtsbehandlungen-bruchsal/` |
| Schönheitssalon | 6 | `/schoenheitssalon-bruchsal/` |
| Wimpernstudio | 6 | `/wimpernstudio-bruchsal/` |
| Permanent Make-up | 3 | `/permanent-make-up-bruchsal/` |
| Hautanalyse (allgemein) | 1 | Startseite |

### Preise

Die Vorgabe verlangt für Unterleistungsseiten ausdrücklich **keine konkreten
Preise** — stattdessen wird erklärt, welche Faktoren den Preis bestimmen, und
zugesagt, dass er vorab genannt wird und danach gilt. Auf den Kernleistungs-
seiten stehen dagegen konkrete Preise, weil die vorherige Vorgabe das so
wollte. Das ist kein Widerspruch im Bau, sondern in den Vorgaben; wenn es
einheitlich sein soll, sag Bescheid.

### Bildzuordnung

13 verschiedene Fotos auf 25 Seiten — mehr gibt der Bestand nicht her.
Mehrfach verwendet:

| Bild | Seiten |
|------|--------|
| makeup.jpg | Tages-, Abend-Make-up, GLAM Smokey Eye |
| wimpern-brauen.jpg | Classic, Mega Volume, Refill, Augenbrauen färben |
| hero-behandlung.jpg | Basic, Gesichtsenthaarung, Ohren-/Nasenhaare, Wimpern entfernen, Wimpernkranz |
| gesichtsbehandlung.jpg | PRX-T33, BioRePeel |
| permanent-makeup.jpg | Browlifting, Henna Brows, Eyeliner |

Eigene Fotos wären für diese Seiten die größte einzelne Verbesserung. Zum
Tauschen den Dateinamen an zwei Stellen ändern: im `<link rel="preload">` als
`../assets/img/…` und in `--pagehero-img` als `../img/…` (unterschiedlich, weil
eine CSS-Custom-Property relativ zum Stylesheet aufgelöst wird).

## Geprüft

Alle 25 Seiten automatisiert gegengeprüft, keine Beanstandung:

- Herobild vorhanden und lädt (HTTP 200) — keine Farbfläche
- H1 enthält Behandlungsname und „Bruchsal"
- Rücklink auf die richtige Elternseite vorhanden
- 0 Ankerlinks, alle Ziele laden oben
- Service-Schema als JSON-LD vorhanden
- 4 Vertrauensmerkmale im Hero, 4 H2-Abschnitte im Text
- Kein horizontales Scrollen bei 375 px, H1 mobil über der Falz
- Einzige Zeigerziele unter 24 px: Inline-Links mitten im Satz (WCAG-2.2-Ausnahme)

Seitenbestand insgesamt: 45 Dateien, 0 tote interne Links.
