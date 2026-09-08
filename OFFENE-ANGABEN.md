# Offene Punkte — Stand 8. September 2026

## Noch offen

| Was | Wo | Anmerkung |
|-----|-----|-----------|
| **Eigene Fotos** | 3 Kernleistungs- und 5 Unterseiten, zweites Studiobild auf „Über uns" | Wird nachgereicht. Bis dahin teilen sich mehrere Seiten dasselbe Bild — welche, steht in `INHALTE-KERNLEISTUNGEN.md` und `INHALTE-UNTERLEISTUNGEN.md`. |
| **Consent-Tool** | alle Seiten | Wird nachgereicht. Sobald es steht: Abschnitt in der Datenschutzerklärung ergänzen (Anbieter, gespeicherte Daten, Rechtsgrundlage, Widerruf). Die Klick-Lösung bei der Karte kann dann bleiben oder durch die Consent-Abfrage ersetzt werden. |
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

## Formularversand — gebaut am 8. September 2026

`kontakt.php` liegt im Wurzelverzeichnis. Das Formular schickt die Angaben per
`fetch` dorthin, PHP prüft sie noch einmal und verschickt eine E-Mail an
`info@artist-of-aesthetic.de`. **Nichts wird gespeichert, kein Drittanbieter ist
beteiligt** — deshalb braucht es dafür weder einen Consent-Banner noch einen
zusätzlichen Abschnitt in der Datenschutzerklärung. Der bestehende Abschnitt
„Kontaktformular" deckt es ab.

**Vor der Inbetriebnahme:** Empfängeradresse oben in `kontakt.php` prüfen. Die
Absenderadresse muss eine der eigenen Domain sein, sonst stufen viele
Mailserver die Nachricht als Fälschung ein — steht als Kommentar in der Datei.
Nach dem Upload einmal testweise absenden und prüfen, ob die Mail ankommt (auch
im Spam-Ordner nachsehen).

**Spamschutz** ohne Captcha: ein für Menschen unsichtbares Feld, das Bots
ausfüllen, plus eine Zeitprüfung — wer in unter drei Sekunden absendet, ist
keiner. Beides wird stillschweigend verworfen, damit der Bot nichts lernt.

**Auf der Testfassung** läuft kein PHP. Das Formular zeigt dort eine ehrliche
Fehlermeldung mit Telefonnummer und E-Mail-Adresse statt eines falschen
Erfolgs. Geprüft: Erfolgsweg und Fehlerweg funktionieren beide, alle neun
Felder werden übertragen.

Ein Randpunkt: Auf GitHub Pages ist `kontakt.php` als Text lesbar, weil Pages
PHP nicht ausführt. Darin stehen keine Zugangsdaten, nur die
Empfängeradresse — und die steht ohnehin im Impressum. Auf einem Hoster mit
PHP tritt das nicht auf.

## Google-Bewertungen: reicht Elfsight für SEO?

**Für SEO bringt es nichts** — Bewertungen auf der eigenen Website ranken nicht.
Wichtiger: Google zeigt für eigene, selbst eingebundene Bewertungen **keine
Sterne in den Suchergebnissen**. `AggregateRating`-Markup dafür ist laut
Richtlinien nicht erlaubt und kann eine manuelle Maßnahme auslösen. Sterne in
der Suche kommen über das Unternehmensprofil, nicht über die Website.

Der echte Nutzen ist **Konversion** — frische, rotierende Bewertungen wirken.
Die Kosten: ein externes Skript (Ladezeit, Core Web Vitals — die sind
Rankingfaktor), Consent-Pflicht, und ohne Zustimmung sehen Besucher nichts.

**Vorschlag:** Die drei echten Rezensionen, die fest im HTML stehen, als Basis
behalten — immer sichtbar, kein Consent. Elfsight später zusätzlich in den
vorbereiteten Container auf der Startseite V3 (`#google-reviews`) und in den
Google-Abschnitt auf „Über uns" setzen, sobald das Consent-Tool steht.
