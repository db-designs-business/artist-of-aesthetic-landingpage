# Offene Punkte — Stand 8. September 2026

## Noch offen

| Was | Wo | Anmerkung |
|-----|-----|-----------|
| **Eigene Fotos** | 3 Kernleistungs- und 5 Unterseiten, zweites Studiobild auf „Über uns" | Wird nachgereicht. Bis dahin teilen sich mehrere Seiten dasselbe Bild — welche, steht in `INHALTE-KERNLEISTUNGEN.md` und `INHALTE-UNTERLEISTUNGEN.md`. |
| **Domain in Cookiebot freischalten** | Cookiebot-Konto | Ohne Freigabe erscheint kein Banner. Details unten. |
| **Google Fonts selbst hosten** | alle Seiten | Cookiebot blockiert keine Stylesheets — die Schriften laden weiterhin ohne Einwilligung. Details unten. |
| **Elfsight: Firmierung und Anschrift** | Datenschutz, Abschnitt Elfsight | Steht weder im alten Impressum noch auf elfsight.com. Bitte im Elfsight-Konto oder im AV-Vertrag nachsehen. |

## Technisches SEO — erledigt am 8. September 2026

**Neu angelegt:** `sitemap.xml` (43 Adressen), `robots.txt`, `404.html`,
`.htaccess`, `tools/sitemap_xml.py`.

**Auf allen 43 Seiten ergänzt:** Canonical, Open Graph samt Bildmaßen,
Twitter Card, BreadcrumbList im Schema.

**Zwei Punkte, die eine Erklärung brauchen:**

*Die `robots.txt` sperrt nichts mehr.* Vorher stand dort `Disallow: /`.
Zusammen mit dem `noindex` im Kopf jeder Seite war das eine Sperre, die sich
selbst im Weg stand: Was Google nicht lesen darf, dort kann Google auch das
`noindex` nicht sehen – und eine gesperrte Adresse kann trotzdem im Index
landen, wenn woanders ein Link darauf zeigt. Das `noindex` ist die stärkere
Sperre. Es steht weiterhin auf allen 43 Seiten und muss vor dem Livegang raus.

*Die `.htaccess` wirkt auf GitHub Pages nicht.* Sie ist für All-Inkl gedacht
und regelt dort Fehlerseite, Komprimierung und Zwischenspeicher. Darin steht
auch der vorbereitete Block für die **Weiterleitungen von den alten
WordPress-Adressen** – auskommentiert, weil ich die alte Adressliste nicht
habe. Die bekommst du aus der Search Console unter *Seiten > indexiert*.
Ohne diese Weiterleitungen laufen alle bestehenden Google-Treffer ins Leere;
das ist der häufigste Grund für einen Einbruch nach einem Relaunch.

**Bilder:** alle 17 JPEG zusätzlich als WebP, insgesamt 1.880 kB → 1.176 kB
(−37 %). Eingebunden über `<picture>` beziehungsweise `image-set()`, die JPEG
bleiben als Rückfallebene liegen. Wer neue Bilder ergänzt, muss die
WebP-Fassung mit anlegen – sonst greift stillschweigend das JPEG.

**Bewusst nicht gemacht:** CSS und JS minifizieren. Gepackt sind es 13,3 kB
und 4,1 kB – eine Minifizierung brächte vielleicht 3 kB und würde dafür die
Kommentare zerstören, an denen sich die Dateien später pflegen lassen. Wenn du
es trotzdem willst, gehört das in einen Bau-Schritt, der die Quelldateien in
Ruhe lässt.

## Startseite V4 — die abgestimmte Endfassung

Zusammengesetzt am 8. September aus den Bausteinen, die du ausgewählt hast:

| Baustein | Herkunft | Anpassung |
|---|---|---|
| Hero | V1 (Aufbau) | H1 trägt jetzt Leistung + Stadt. Rabatt-Pille durch eine Telefonzeile ersetzt. |
| Zahlenleiste | V1 | Vierter Wert: „73× / 5 Sterne bei Google“ statt der Durchschnittsnote. |
| Warum hier | V3 | — |
| Bewertungen | V3 | **ohne** Elfsight-Einbettung, nur die drei festen Rezensionen. |
| Anfrageformular | V3 | — |
| Vier Bereiche / Acht Leistungen | V3 | — |
| Einzugsgebiet + Ortsliste | V3 | — |
| Über Aylin, FAQ, Abschluss-CTA | V3 | — |

Sitewide dazu erledigt:

- **„Umland“ → „Umkreis“** auf 15 Seiten. Die Überschrift „Acht Leistungen, für
  die Kundinnen ins Umland fahren“ war dabei auch inhaltlich verdreht — das
  Studio liegt ja in Bruchsal. Jetzt: „… aus dem Umkreis anreisen“.
- **Rabatthinweise (20 %) entfernt** — aus Hero, Preisabschnitt, FAQ,
  Formular-Checkbox und der Meta-Beschreibung von V1 sowie aus V2. Die
  FAQ-Frage dazu wurde durch eine zur kostenlosen Beratung ersetzt, damit an
  der Stelle keine Lücke bleibt.

**V4 ist seit dem 8. September die Startseite.** V1, V2 und V3 sind gelöscht,
der Umschalter in der Kopfleiste ist raus — samt Markup, Markierungslogik in
`tools/build.py`, Einträgen in `tools/sitemap.py` und CSS. Von 46 Seiten sind
damit 43 übrig.

### Zwei weitere Änderungen am selben Tag

**Navigation auf vier Punkte gekürzt:** Home · Leistungen · Über uns · Kontakt.
Die vier Kategorieseiten standen vorher einzeln in der Kopfzeile. Sie bleiben
bestehen und werden weiter aus dem Fließtext und der Fußzeile verlinkt — nur der
Weg dorthin führt jetzt über `/services/`.

**„Kosmetikstudio“ → „Kosmetiker“**, passend zur Hauptkategorie im
Google-Unternehmensprofil: in allen Seitentiteln, Meta-Beschreibungen, im
Schema, in der Kopf- und Fußzeile, in den H1 und in den Bildbeschreibungen
(dort als „beim Kosmetiker“). Der Satz „Alle Bereiche findest du in unserem
Kosmetikstudio in Bruchsal“ wurde zu „… bei deinem Kosmetiker in Bruchsal“ —
„in unserem Kosmetiker“ wäre falsches Deutsch.

Drei Stellen blieben bewusst stehen:

| Stelle | Grund |
|---|---|
| Impressum und Datenschutz, Zeile „Kosmetikstudio“ unter dem Namen | Geschäftsbezeichnung aus dem alten Impressum. Rechtstext wird nicht umformuliert. |
| „Kosmetikstudios in Deutschland“ (Kommentar auf „Über uns“) | Allgemeine Aussage über die Branche, kein Bezug auf dieses Studio. |
| Titel und Meta der Startseite | Sagen jetzt ebenfalls „Kosmetiker Bruchsal“. Falls du zusätzlich auf „Kosmetikstudio“ ranken willst, ist der Title die Stelle dafür — Thema fürs technische SEO. |

## Am 8. September geklärt — kein Handlungsbedarf

- **Gesundheitsamt (§ 36 IfSG) und Betriebshaftpflicht** — gibt es nicht, steht
  deshalb nirgends auf der Seite. Ein Kommentar auf „Über uns“ hält fest, dass
  das Absicht ist. Anmerkung ohne Rechtsberatungsanspruch: Für Studios, die
  Permanent Make-up anbieten, ist die Anzeige beim Gesundheitsamt nach § 36
  IfSG in der Regel Pflicht — das Gesundheitsamt Karlsruhe gibt dazu Auskunft.
  Für die Website ändert das nichts.
- **AV-Verträge** mit Cookiebot und Elfsight — liegen vor. Die entsprechenden
  Sätze in der Datenschutzerklärung können so stehen bleiben.
- **Rechtsprüfung** von Impressum und Datenschutz — erledigt bzw. übernommen.
- **Fotos** — werden am Ende gemeinsam mit der Gesamtdurchsicht geklärt.

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

## Cookiebot — eingebaut am 8. September 2026

Das Skript steht mit `data-blockingmode="auto"` als **erstes Skript im `<head>`**
aller 45 Seiten. Nur an dieser Stelle kann der Automatikmodus Skripte und
iframes abfangen, bevor sie laden — bitte nicht nach unten verschieben.

Zusätzlich ist das Elfsight-Skript ausdrücklich als
`type="text/plain" data-cookieconsent="marketing"` ausgezeichnet. Das greift
auch dann, wenn `elfsightcdn.com` nicht in der Cookiebot-Datenbank steht.

Weiter eingerichtet:

- **Karte** lädt automatisch, sobald Marketing erlaubt ist; der Knopf „Karte
  laden" bleibt als zweiter Weg für alle, die nicht zustimmen.
- **Fußleiste** hat eine Schaltfläche „Cookie-Einstellungen", die den Dialog
  über `Cookiebot.renew()` erneut öffnet — der Widerruf muss jederzeit möglich
  sein.
- **Datenschutzerklärung** hat einen Cookiebot-Abschnitt (Anbieter
  Usercentrics A/S, Havnegade 39, 1058 Kopenhagen; Nachweispflicht nach
  Art. 7 Abs. 1 DSGVO) und am Ende von Abschnitt 4 die automatisch erzeugte
  **Cookie-Erklärung**, die alle gesetzten Cookies auflistet.

### Geprüft auf der Testfassung

| Punkt | Ergebnis |
|---|---|
| Cookiebot lädt | ✓ |
| Elfsight bleibt blockiert | ✓ `type="text/plain"`, kein Request |
| Cookies vor Einwilligung | ✓ keine |
| Banner erscheint | ✗ — Domain nicht freigegeben |
| Google Fonts | ✗ — lädt trotzdem |

### Zwei Punkte zum Nachziehen

**1. Domain freigeben.** Cookiebot meldet in der Konsole wörtlich:

> The domain DB-DESIGNS-BUSINESS.GITHUB.IO is not authorized to show the cookie
> banner for domain group ID f01d9f3d-… Please add it to the domain group in the
> Cookiebot Manager.

Also: `db-designs-business.github.io` im Cookiebot-Manager zur Domain-Gruppe
hinzufügen, dann erscheint das Banner auch in der Testfassung. Spätestens beim
Umzug muss dort ohnehin die echte Domain eingetragen und der Scan gestartet
werden — erst danach ist die Cookie-Erklärung vollständig.

**2. Google Fonts selbst hosten.** Der Automatikmodus fängt Skripte und iframes
ab, **aber keine Stylesheets**. Die Schriften Montserrat und Open Sans laden
deshalb weiterhin bei jedem Seitenaufruf von Google, mit IP-Übertragung, bevor
irgendjemand zugestimmt hat. Nachgemessen: zwei Requests an Google.

Ein Banner ändert daran nichts. Sauber wird es nur durch Selbsthosten:
Schriftdateien nach `assets/fonts/`, per `@font-face` in `style.css` einbinden,
den `<link>` auf `fonts.googleapis.com` aus allen Seiten entfernen. Nebeneffekt:
zwei externe Verbindungen weniger, die Seite lädt schneller. Etwa 30 Minuten
Arbeit — sag Bescheid.

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
vorbereiteten Container auf der Startseite (`#google-reviews`) und in den
Google-Abschnitt auf „Über uns" setzen, sobald das Consent-Tool steht.
