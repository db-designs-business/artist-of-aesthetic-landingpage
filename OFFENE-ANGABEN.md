# Offene Punkte — Stand 8. September 2026

## Noch offen

| Was | Wo | Anmerkung |
|-----|-----|-----------|
| **Eigene Fotos** | 3 Kernleistungs- und 5 Unterseiten, zweites Studiobild auf „Über uns" | Wird nachgereicht. Bis dahin teilen sich mehrere Seiten dasselbe Bild — welche, steht in `INHALTE-KERNLEISTUNGEN.md` und `INHALTE-UNTERLEISTUNGEN.md`. |
| **Consent-Tool** | alle Seiten | Wird nachgereicht. Sobald es steht: Abschnitt in der Datenschutzerklärung ergänzen (Anbieter, gespeicherte Daten, Rechtsgrundlage, Widerruf). Die Klick-Lösung bei der Karte kann dann bleiben oder durch die Consent-Abfrage ersetzt werden. |
| **Formularversand** | `assets/js/main.js` | Noch simuliert. Siehe Abschnitt unten. |
| **Anzeige beim Gesundheitsamt (§ 36 IfSG), Betriebshaftpflicht** | „Über uns", Nachweise | Nur falls vorhanden und belegbar. Ohne Angabe steht dort nichts dazu — erfunden wird nichts. |
| **Rechtsprüfung** | Impressum, Datenschutz | Ich bin kein Anwalt. Beide Seiten sollte jemand mit Fachkenntnis einmal ansehen. |

## Am 8. September erledigt

- **Gründungsgeschichte** — Aylins eigener Text von artist-of-aesthetic.de übernommen, als Zitat in ihrer Stimme mit Namensnennung. Drum herum die belegbaren Fakten zu Ausbildung, Studio und Erfahrung.
- **Video** — Abschnitt komplett entfernt, kommt keins rein.
- **Gründungsjahr** — kein genaues Jahr bekannt, bleibt bei „über zehn Jahre Erfahrung". Punkt aus der Nachweisliste gestrichen.
- **Google-Unternehmensprofil** — verlinkt in einem eigenen Abschnitt auf „Über uns", zusätzlich bei den Profilen und im Schema unter `sameAs`.
- **Kleinunternehmerregelung** — Hinweis nach § 19 Abs. 1 UStG im Impressum ergänzt.
- **Zahlen bestätigt** — 73 Bewertungen, 8.000+ Behandlungen und alle Preise sind aktuell.
- **Öffnungszeiten** — Mo–Sa 10:00–18:00 Uhr, sonntags geschlossen. Auf 45 Seiten im Footer, auf der Kontaktseite als Liste und im Schema.
- **Google Fonts** — Abschnitt in der Datenschutzerklärung ergänzt.
- **Borlabs Cookie** — Abschnitt entfernt, trifft hier nicht zu.
- **Google Maps** — Karte auf der Kontaktseite eingebaut, OpenStreetMap-Abschnitt durch einen Google-Maps-Abschnitt ersetzt.

## Zur Karte: warum sie erst auf Klick lädt

Die Karte ist eingebaut, lädt aber erst, wenn jemand auf „Karte laden" klickt.
Vorher geht **kein einziger Request** an Google — nachgemessen. Grund: Das
Consent-Tool ist noch nicht da, und eine direkt eingebettete Karte überträgt
schon beim Seitenaufruf die IP-Adresse jeder Besucherin an Google.

Die Datenschutzerklärung beschreibt genau dieses Verhalten. Sobald das
Consent-Tool steht, gibt es zwei Wege:

- **So lassen.** Der Klick ist die Einwilligung, das genügt.
- **Auf das Consent-Tool umstellen.** Dann steuert das Tool das
  `data-map`-Element an und die Schaltfläche entfällt.

Direktes Einbetten ohne Klick ist ein Einzeiler — der iframe aus dem
`data-map`-Attribut kommt direkt in den Container. Der Kommentar im Quelltext
der Kontaktseite beschreibt beide Varianten.

## Zum Formular: reicht Elfsight für SEO?

**Für SEO ist es egal** — Formulare werden nicht gerankt und Google bewertet
sie nicht. Die SEO-Frage stellt sich hier gar nicht.

Was dagegen spricht, sind drei andere Punkte:

1. **Ladezeit.** Elfsight lädt ein externes Skript nach, das das Formular per
   JavaScript erzeugt. Das kostet spürbar Ladezeit und geht auf die Core Web
   Vitals — und die sind ein Rankingfaktor.
2. **Datenschutz.** Ein weiterer externer Dienst, der Daten überträgt und
   Cookies setzt. Er braucht einen eigenen Abschnitt in der
   Datenschutzerklärung und muss hinter das Consent-Tool. Wer nicht zustimmt,
   sieht kein Formular.
3. **Design.** Das eingebettete Formular sieht anders aus als die Seite. Das
   fertige Formular ist bereits gebaut, geprüft und barrierefrei — mit
   Fehlermeldungen an den Feldern, Fehlerübersicht und Tastaturbedienung.

**Mein Vorschlag:** Das bestehende Formular behalten und nur den Versand
anbinden. Dafür reicht ein Endpunkt wie Web3Forms oder Formspree — eine Zeile
im HTML, kein zusätzliches Skript, kein Cookie, Design und Barrierefreiheit
bleiben. Aufwand etwa 15 Minuten, sobald die Empfänger-E-Mail feststeht.

Wenn du trotzdem Elfsight möchtest, geht das auch — dann tauschen wir den
Formularblock aus und ergänzen den Datenschutzabschnitt.
