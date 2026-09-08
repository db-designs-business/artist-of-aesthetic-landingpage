# Was noch von der Kundin kommen muss

Beide neuen Seiten sind fertig gebaut und ansehnlich, aber an sieben Stellen
fehlen Angaben, die nur Aylin liefern kann. Alle Stellen sind im HTML als
Kommentar markiert und im Browser als gestrichelter Kasten sichtbar, damit
nichts übersehen wird.

## Über uns — `/about/`

| Was | Wo | Warum es wichtig ist |
|-----|-----|----------------------|
| **Gründungsgeschichte** | Abschnitt „Unsere Geschichte" | Steht aktuell als Platzhalter aus gesicherten Angaben (Ausbildung, Standort, Erfahrung). Die persönliche Fassung ist für Google und für Kundinnen deutlich stärker. Leitfragen stehen im HTML-Kommentar. 150–200 Wörter. |
| **Zweites Studiofoto** | Abschnitt „Unsere Geschichte" | Aktuell steht dort ersatzweise ein Behandlungsfoto. Ein Bild der Räume wäre passender. |
| **Vorstellungsvideo** | Abschnitt „Aylin stellt das Studio vor" | 60 Sekunden reichen. Bitte nicht direkt von YouTube einbinden — Hinweis zur Zwei-Klick-Lösung steht im Kommentar. |
| **Gründungsjahr, Gesundheitsamt-Anzeige, Haftpflicht** | Abschnitt „Nachweise" | Für Permanent Make-up ist die Anzeige nach § 36 IfSG erforderlich. Anders als in den USA gibt es keine allgemeine Lizenznummer für Kosmetikstudios — deshalb steht dort **nichts** Erfundenes. |
| **Google-Unternehmensprofil** | Abschnitt „Du findest uns auch bei Google" | Entweder nur die Profil-URL verlinken (einfach, datenschutzfreundlich) oder ein Bewertungs-Widget hinter eine Consent-Abfrage legen. |

## Kontakt — `/contact/`

| Was | Wo | Warum es wichtig ist |
|-----|-----|----------------------|
| **Öffnungszeiten** | Kontaktliste und Schema im `<head>` | Steht aktuell nur „Termine nach Vereinbarung". Die Zeiten müssen mit dem Google-Unternehmensprofil übereinstimmen, sonst widersprechen sich die Angaben. Falsche Zeiten im Schema sind schlimmer als gar keine. |
| **Google-Maps-Karte** | Abschnitt „So findest du uns" | Bewusst noch nicht eingebettet: Eine direkt eingebundene Karte lädt beim Seitenaufruf Daten zu Google und setzt Cookies. Bis das über Consent oder eine datenschutzfreundliche Alternative geklärt ist, steht dort ein Button „Route in Google Maps öffnen" — der funktioniert und verrät nichts, solange niemand klickt. |

## Angaben, die bereits gesichert übernommen wurden

Aus der bestehenden Website und dem Briefing — bitte trotzdem vor dem Livegang
einmal gegenprüfen, ob alles noch stimmt:

- Aylin Acikgöz, Inhaberin, staatlich anerkannte Fachkosmetikerin
  (Berufsfachschule für Kosmetik Wiesbaden)
- PhiBrows Artist, PhiContour Artist, Catwalk Make-up Artist
- über 10 Jahre Erfahrung, mehr als 8.000 Behandlungen, 73 Fünf-Sterne-Bewertungen
- Schwimmbadstraße 14, 76646 Bruchsal · 0176 76333562 · info@artist-of-aesthetic.de
- Instagram und Facebook (im Abschnitt „Folgen" verlinkt)

## Zwei Anpassungen an der Vorlage

Die Vorlage stammt aus dem US-Markt und verlangt an zwei Stellen Aussagen, die
hier nicht zutreffen:

1. **„Licensed, Insured, and Guaranteed"** als Überschrift des Nachweis-Abschnitts.
   Daraus wurde „Geprüft, zertifiziert, im Studio einsehbar" mit den tatsächlichen
   Qualifikationen. Eine Lizenznummer gibt es für deutsche Kosmetikstudios nicht,
   und ob eine Betriebshaftpflicht besteht, weiß ich nicht — also steht es auch
   nicht da.
2. **„Available 24/7 for emergencies"** bei den Telefonzeiten. Laut Briefing gibt
   es keinen 24/7-Betrieb. Stattdessen steht dort der ehrliche Hinweis, dass
   während einer Behandlung niemand ans Telefon geht, plus die zugesagte
   Rückmeldung binnen 24 Stunden.

Der Prompt bricht außerdem mitten im Abschnitt „Trust Reinforcement" ab. Gebaut
ist dort ein Vertrauensblock mit den vier belegbaren Zusagen: Antwort in 24
Stunden, kostenlose Hautanalyse, 73 Bewertungen, Preis vorab. Wenn dort etwas
anderes hin sollte, sag Bescheid.

## Eine technische Änderung

Auf der Kontaktseite ist die E-Mail-Adresse laut Vorgabe ein Pflichtfeld, auf den
Startseiten-Formularen bleibt sie freiwillig. Die Prüfung in `main.js` richtet
sich jetzt nach dem `required`-Attribut im HTML statt nach einer festen Regel —
damit gilt auf jeder Seite das, was im Formular steht. Die bestehenden Formulare
verhalten sich unverändert.
