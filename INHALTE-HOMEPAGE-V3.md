# Homepage V3 — Konversionsreihenfolge

Dritte Fassung der Startseite unter `/v3/`. V1 (`/`) und V2 (`/v2/`) bleiben
unverändert bestehen; umgeschaltet wird über den Entwurfs-Umschalter in der Topbar.

## Warum eine eigene Fassung

Der Prompt gibt eine **verbindliche Abschnittsreihenfolge** vor, die sich deutlich
von V2 unterscheidet: Social Proof und Anfrageformular wandern nach ganz oben,
erklärende Inhalte nach unten. Da beide bestehenden Fassungen erhalten bleiben
sollten, ist daraus V3 geworden statt eines Umbaus von V2. Die Texte stammen
wörtlich aus dem vorgegebenen Content-Block.

## Abschnittsreihenfolge (wie vorgegeben)

| # | Abschnitt | Anker |
|---|-----------|-------|
| 1 | Hero mit Hintergrundbild und dunklem Overlay | — |
| 2 | Warum Artist of Aesthetic (4 Differenzierungsmerkmale) | `#warum` |
| 3 | Google-Bewertungen (Embed-Platzhalter + 3 echte Rezensionen) | `#bewertungen` |
| 4 | Anfrageformular auf abgesetztem Hintergrund | `#anfrage` |
| 5 | Vier Leistungsbereiche als Karten | `#bereiche` |
| 6 | Acht Kernleistungen | `#leistungen` |
| 7 | Einzugsgebiet | `#einzugsgebiet` |
| 8 | Über / Qualifikationen | `#ueber` |
| 9 | FAQ (Akkordeon, 6 Fragen) | `#faq` |
| 10 | Orte (kompaktes Band über dem Footer) | — |
| 11 | Abschluss-CTA | `#termin` |

## Abweichungen von der Vorlage — und warum

Die Vorlage ist auf einen Notdienst-Handwerksbetrieb zugeschnitten. Vier Angaben
daraus sind für ein Kosmetikstudio schlicht unwahr und wurden durch die
tatsächlichen Fakten aus dem Briefing ersetzt:

| Vorlage | Hier stattdessen | Grund |
|---------|------------------|-------|
| Title „24/7 Emergency Service“ | „Antwort in 24 Stunden“ | Laut Briefing ausdrücklich **kein** 24/7-Betrieb |
| Trust-Leiste „Licensed & Insured / 24/7 / Same-Day“ | Staatlich geprüft · Antwort in 24 h · kostenlose Hautanalyse · inhabergeführt | Die Vorlagenbegriffe existieren in der Branche so nicht |
| „Get Free Estimate“ | „Kostenlose Hautanalyse sichern“ | Kein Kostenvoranschlag, sondern Analyse |
| „Response within 1 hour“ | „Antwort innerhalb von 24 Stunden“ | Zugesagt sind 24 Stunden, nicht eine Stunde |

Zwei weitere Punkte:

- **Abschnitt 10** sollte laut Vorlage auf eine `/locations/`-Hub-Seite verlinken.
  Eine solche Seite gibt es in der Architektur nicht — verlinkt ist stattdessen
  `/contact/` für Anfahrt und Kontakt. Wenn Ortsseiten dazukommen sollen, ist das
  die Stelle dafür.
- **Abschnitt 7 und 10** überschneiden sich thematisch (beide Einzugsgebiet). Sie
  sind inhaltlich getrennt: 7 nennt Anfahrtszeiten und die Parkplatzsituation,
  10 ist nur noch die Ortsliste für die interne Verlinkung.

## Offene Punkte

- **Google-Reviews-Widget**: Der Container `#google-reviews` enthält den
  Kommentar `<!-- PASTE GOOGLE REVIEWS EMBED CODE HERE -->`. Die drei echten
  Rezensionen darunter bleiben als Fallback stehen, falls das Widget durch
  Consent-Banner oder Adblocker nicht lädt.
- **Formularversand** ist weiterhin nur simuliert (Platzhalter in `main.js`) —
  gilt für alle drei Fassungen.
- **Zahl 73 Bewertungen** und die Hygieneaussagen in FAQ 4 vor dem Livegang
  gegenprüfen.
- **Umschalter und `noindex`** vor dem Livegang entfernen, siehe README.

## Geprüft

- 45 Seiten, 1069 interne Links, keine toten Ziele (`python tools/check.py`)
- Kein horizontales Scrollen bei 375 px und 1280 px
- H1 bei 375 px oberhalb der Falz (373 px)
- FAQ-Akkordeon, Formularvalidierung und Erfolgsmeldung funktionsfähig
- Keine leeren Fehlermeldungen im Ruhezustand
- Einziges Zeigerziel unter 24 px: der Inline-Link „Datenschutzerklärung“
  im Label — von WCAG 2.2 ausdrücklich ausgenommen
