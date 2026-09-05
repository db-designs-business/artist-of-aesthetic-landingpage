# Seitenarchitektur — Artist of Aesthetic

Referenz für den Ausbau der Landing Page zur vollständigen Website.
Stand: 05.09.2026 · Quelle: Prompt 0 (Planning), geprüft und korrigiert.

---

## Eckdaten

| Feld | Wert |
|---|---|
| Name | Artist of Aesthetic |
| Branche | Kosmetikstudio |
| Ort | Bruchsal, Baden-Württemberg, 76646 |
| Telefon | 0176 76333562 |
| E-Mail | info@artist-of-aesthetic.de |
| Primäre Kategorie | Kosmetiker |
| Ziel-Keyword | Kosmetikstudio Bruchsal |

**Einzugsgebiet:** Bruchsal · Karlsdorf-Neuthard · Forst · Hambrücken ·
Ubstadt-Weiher · Spöck · Büchenau · Untergrombach · Obergrombach · Heidelsheim

**Trust-Signale:** PhiBrows-/PhiContour-Zertifizierung · medizinische Hygiene-
und Sterilisationsstandards · Google-Bewertungen und dokumentierte
Vorher-Nachher-Ergebnisse · über 10 Jahre Erfahrung, 8.000+ Behandlungen ·
dermatologisch getestete Produktlinien

**Lokale Themen für die Texte:** begrenzte Parkmöglichkeiten in der Innenstadt ·
Anfahrt aus dem Umland · Wartezeiten bei Wimpern-/PMU-Terminen ·
saisonale Sonnenexposition (Fruchtsäure, Aftercare) · Fachkräftemangel macht
geprüfte Qualifikation zum Vertrauensfaktor

---

## Seitenzahl

Die Zusammenfassung im Planning nennt 37 Seiten. Nachgezählt sind es **41**:
die Child Services summieren sich auf 24 statt 21, und die General-Service-Seite
fehlt in der Rechnung.

| Ebene | Anzahl |
|---|---:|
| Homepage | 1 |
| Main Pages (Services, About, Contact) | 3 |
| Kategorie-Seiten | 4 |
| Core Service Pages | 8 |
| Child Service Pages | 24 |
| General Service (Hautanalyse) | 1 |
| **Gesamt** | **41** |

Aufschlüsselung der Child Services: Gesichtsbehandlungen 9 · Schönheitssalon 6 ·
Wimpernstudio 6 · Permanent Make-up 3.

Keine doppelten Slugs.

---

## Hierarchie

### 1 — Kosmetische Gesichtsbehandlungen · `/gesichtsbehandlungen-bruchsal`

**Core:** Mikroneedling `/mikroneedling-bruchsal` · Aquafacial Intensiv `/aquafacial-bruchsal`

**Child:** BB Glow `/bb-glow-bruchsal` · PRX-T33 `/prx-t33-peeling-bruchsal` ·
BioRePeelCl3 `/biorepeel-cl3-bruchsal` · Fruchtsäure `/fruchtsaeure-peeling-bruchsal` ·
Porentiefe `/porentiefe-gesichtsbehandlung-bruchsal` · Basic `/basic-gesichtsbehandlung-bruchsal` ·
Akne `/akne-behandlung-bruchsal` · Teeny `/teeny-gesichtsbehandlung-bruchsal` ·
De Luxe 24K Goldmaske `/de-luxe-goldmaske-behandlung-bruchsal`

### 2 — Schönheitssalon · `/schoenheitssalon-bruchsal`

**Core:** Braut-Make-up `/braut-make-up-bruchsal` · Augenbrauen formen `/augenbrauen-formen-bruchsal`

**Child:** Tages-Make-up `/tages-make-up-bruchsal` · Abend-Make-up `/abend-make-up-bruchsal` ·
GLAM Smokey Eye `/glam-smokey-eye-bruchsal` · Gesichtsenthaarung `/gesichtsenthaarung-bruchsal` ·
Ohren-/Nasenhaare `/ohren-nasenhaare-entfernen-bruchsal` · Augenbrauen färben `/augenbrauen-faerben-bruchsal`

### 3 — Wimpernstudio · `/wimpernstudio-bruchsal`

**Core:** Light Volume 2D–5D `/wimpernverlaengerung-volumen-bruchsal` · Wimpernlifting `/wimpernlifting-bruchsal`

**Child:** Classic 1:1 `/classic-wimpernverlaengerung-bruchsal` ·
Mega Volume ab 6D `/mega-volume-wimpernverlaengerung-bruchsal` ·
Refill `/wimpernverlaengerung-refill-bruchsal` · Entfernen `/wimpernverlaengerung-entfernen-bruchsal` ·
Browlifting `/browlifting-bruchsal` · Henna Brows `/henna-brows-bruchsal`

### 4 — Studio für Permanent Make-up · `/permanent-make-up-bruchsal`

**Core:** Lippen PMU `/lippen-permanent-make-up-bruchsal` · Microblading `/microblading-augenbrauen-bruchsal`

**Child:** Ombré Powder Brows `/ombre-powder-brows-bruchsal` ·
Wimpernkranz-Verdichtung `/wimpernkranz-verdichtung-bruchsal` ·
Eyeliner Pigmentierung `/eyeliner-pigmentierung-bruchsal`

### General · verlinkt zurück auf die Homepage

Hautanalyse & Hauttyp-Beratung `/hautanalyse-beratung-bruchsal`

---

## Navigation

**Hauptnavigation:** Home · Gesichtsbehandlungen · Schönheitssalon ·
Wimpernstudio · Permanent Make-up · Über uns · Kontakt

Die bestehende Homepage arbeitet mit Ankern (`#leistungen`, `#preise` …).
Diese Navigation muss auf Seiten-Links umgestellt werden; die Anker bleiben
innerhalb der Homepage nutzbar.

**Footer:** Alle Leistungen · Über uns · Kontakt · Impressum · Datenschutz ·
alle 4 Kategorie-Seiten · Service-Gebiete als Textzeile

---

## Interne Verlinkung

| Von | Nach |
|---|---|
| Homepage | Services, About, Contact · 4 Kategorien · 8 Core Services · Hautanalyse |
| Kategorie-Seite | ihre Core Services · ihre Child Services · zurück zur Homepage |
| Core Service Page | eigene Kategorie · 1–2 verwandte Child Services (Cross-Sell) |
| Child Service Page | eigene Kategorie |
| Hautanalyse | Homepage |

---

## Inhaltliche Deckung

Preise liegen aus artist-of-aesthetic.de für **alle Leistungen bis auf zwei** vor:

- **Wimpernverlängerung Refill** — kein Preis auf der Live-Seite
- **Hautanalyse & Hauttyp-Beratung** — kein Preis, vermutlich Teil der Behandlung

Bildmaterial: 17 Aufnahmen im Repo, davon ca. 14 als Behandlungsbild verwendbar.
Bei 33 Leistungsseiten fehlt für rund 20 Seiten ein eigenes Motiv. Optionen:
Bilder mehrfach einsetzen, Seiten ohne Hero-Bild gestalten, oder Nachschub vom
Kunden anfordern.

---

## Offene technische Punkte

1. **Homepage-URL.** Das Planning setzt die Homepage auf
   `/kosmetikstudio-bruchsal`. Damit läge die Startseite nicht auf der Wurzel
   der Domain — externe Links, Google-Business-Eintrag und Direkteingaben
   zeigen aber auf `artist-of-aesthetic.de/`. Empfehlung: Homepage auf `/`,
   das Keyword steckt ohnehin in Title und H1.

2. **Saubere URLs ohne `.html`.** Umsetzung als Verzeichnis je Seite
   (`gesichtsbehandlungen-bruchsal/index.html`). Funktioniert auf GitHub Pages
   und auf jedem normalen Webserver.

3. **Relative Links.** Die Testseite läuft unter dem Unterpfad
   `/artist-of-aesthetic-landingpage/`. Absolute Pfade wie
   `/gesichtsbehandlungen-bruchsal` würden dort ins Leere greifen. Alle
   internen Links und Asset-Pfade daher relativ.

4. **Wiederverwendung von Kopf und Fuß.** Bei 41 Seiten dürfen Header,
   Navigation, Footer und Mobile-Bar nicht 41-mal im Quelltext stehen.
   Entscheidung steht aus.
