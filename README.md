# Artist of Aesthetic — One-Page Landing Page

Statische Seite (HTML / CSS / Vanilla JS), keine Build-Tools, kein Framework.

```
website/
├─ index.html
└─ assets/
   ├─ css/style.css
   ├─ js/main.js
   └─ img/            (aus Kosmetiker/Media kopiert + Logo)
```

Lokal ansehen: `index.html` im Browser öffnen (oder `python -m http.server 8777`).

**Live-Test:** https://db-designs-business.github.io/artist-of-aesthetic-landingpage/

---

## Deployment

GitHub Pages, Quelle: Branch `main`, Ordner `/` (root). Jeder Push auf
`main` löst automatisch ein neues Deployment aus (ca. 30–60 Sekunden).

```bash
git add -A
git commit -m "Beschreibung der Aenderung"
git push
```

Die Testseite ist mit `<meta name="robots" content="noindex, nofollow">`
und einer sperrenden `robots.txt` versehen, damit sie nicht in Google
landet und nicht mit artist-of-aesthetic.de um dieselben Keywords
konkurriert. **Beides vor dem Livegang auf der echten Domain entfernen.**

`.nojekyll` verhindert, dass GitHub die Dateien durch Jekyll schickt.

---

## Branding

Alle Werte stammen aus dem Elementor-Kit von artist-of-aesthetic.de,
nicht aus den Referenzbildern. Tokens liegen in `:root` (style.css).

| Token | Hex | Verwendung |
|---|---|---|
| `--blush` | `#EFD7E5` | Marken-Rosé, Flächen, Icon-Kreise |
| `--blush-soft` | `#F8F1F4` | Sektions-Hintergrund |
| `--rose` | `#B3848F` | Marken-Mauve — nur Dekor (Linien, Rahmen) |
| `--rose-deep` | `#8A5A66` | Text & CTA — abgedunkelt für 5,6:1 auf Weiß |
| `--rose-dark` | `#744954` | Hover |
| `--ink` | `#393939` | Headlines, dunkle Sektionen |
| `--graphite` | `#54595F` | Sekundärtext |
| `--muted` | `#6B6B6B` | Fließtext (4,5:1 auf Weiß) |

**Wichtig:** `#B3848F` erreicht auf Weiß nur 3,2:1 und ist deshalb nicht für
Text oder Buttons gesetzt, sondern nur für dekorative Elemente. Für Text und
CTAs wird die abgedunkelte Variante `--rose-deep` verwendet.

Fonts: **Montserrat** (Headlines/UI) + **Open Sans** (Fließtext) — wie im Original-Theme.

---

## Struktur (klassischer Conversion-Funnel)

1. Announcement-Bar — 20 % Neukundenrabatt
2. Sticky Header — Anker-Navigation + Telefon + CTA
3. Hero — Nutzenversprechen, Doppel-CTA (Formular / WhatsApp), 3 Trust-Signale
4. Stats-Bar — 10+ Jahre · 8.000+ Behandlungen · 30+ Behandlungsarten · 5,0
5. Leistungen — 4 Kategorien mit Bild
6. Über Aylin — Story + Zertifikate (Vertrauen vor Preis)
7. USPs — 3 Differenzierungsmerkmale
8. Preise — Tab-Navigation, vollständige Preisliste
9. Ergebnisse — Galerie
10. Ablauf — 3 Schritte (senkt die Hürde vor der Anfrage)
11. Rezensionen — 3 echte Google-Bewertungen
12. FAQ — nimmt Einwände vorweg
13. Kontakt — Formular + WhatsApp/Anruf + Adresse
14. Footer + Mobile Sticky-Bar (Anrufen / WhatsApp / Termin)

Preise und Rezensionen sind 1:1 von artist-of-aesthetic.de übernommen.

---

## Inhaltsstand (Stand 5. September 2026)

| Seitentyp | Anzahl | Inhalt |
|-----------|-------|--------|
| Startseite V1 / V2 / V3 | 3 | fertig, umschaltbar über die Topbar |
| Kategorieseiten | 4 | fertig, je rund 1.000 Wörter |
| Kernleistungen | 8 | Platzhalter |
| Unterleistungen | 24 | Platzhalter |
| Hautanalyse | 1 | Platzhalter |
| Services / Über uns / Kontakt | 3 | Platzhalter |
| Impressum / Datenschutz | 2 | Platzhalter |

Die vier Kategorieseiten verlinken jede ihrer Unterleistungen zweimal:
einmal im Fließtext und einmal im Leistungsraster darunter. Die
Zielseiten stehen bereits, tragen aber noch Platzhaltertext — die Links
laufen also nicht ins Leere, das Ziel ist nur noch leer.

---

## Was noch angebunden werden muss

- **Formularversand** — `assets/js/main.js`, Abschnitt „Platzhalter für den
  Versand". Aktuell wird der Erfolgsfall nur simuliert. Anbindung an
  Contact Form 7, Formspree o. ä. dort einsetzen.
- **Öffnungszeiten** — auf der Live-Seite nirgends veröffentlicht. Steht
  deshalb als „Termine nach Vereinbarung". Falls feste Zeiten existieren:
  im Kontaktblock und im JSON-LD (`openingHoursSpecification`) ergänzen.
- **Impressum / Datenschutz** — verlinken derzeit auf `#impressum` / `#datenschutz`.
  Auf die bestehenden Unterseiten umbiegen.
- **Bilder** — als JPEG ausgeliefert. Vor dem Livegang zu WebP/AVIF
  konvertieren und Hero-Bild in mehreren Breiten via `srcset` einbinden.
- **Google-Bewertung 5,0** — der Wert in der Stats-Bar sollte vor dem
  Livegang gegen das aktuelle Google-Profil geprüft werden.

---

## Accessibility

- Skip-Link, sichtbare Fokus-Ringe (3 px), Tastaturbedienung durchgehend
- Tabs: `role="tab"` + Pfeiltasten/Home/End, Roving-Tabindex
- FAQ: `aria-expanded` + `hidden`
- Formular: Validierung bei `blur`, Fehler unter dem Feld via
  `aria-describedby`, Fehler-Zusammenfassung nach Submit mit Sprunglinks
- Off-Canvas-Menü: Fokus-Trap, Escape schließt, im geschlossenen Zustand
  `visibility:hidden` (nicht fokussierbar)
- `prefers-reduced-motion` deaktiviert alle Animationen und Zähler
- Touch-Targets ≥ 44 px, Mobile-Bar mit `env(safe-area-inset-bottom)`

Breakpoints: 400 / 560 / 720 / 960 / 1080 px. Getestet auf 375, 768 und 1440 px —
kein horizontales Scrollen, keine Konsolenfehler.
