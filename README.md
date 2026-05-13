# Shooting Results Documentation (SRD) – KSV Fallingbostel

## Kurzüberblick
- Verzeichnis von Ergebnislisten: Kreismeisterschaften (KM), Kreisrundenwettkämpfe (RWK), Kreiskönigsschießen (KKS)
- Frontend: PHP + Bootstrap/Propeller, eigenes CSS unter `themes/css/custom.css`
- Ergebnisse liegen statisch im Ordner `results/`

## Setup
1) `.env` anlegen (Projektwurzel):
```
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=db707184206
```
2) DB-Verbindung: `conf/db_d.php` lädt Werte aus `.env` via `conf/env.php`.
3) Admin-Backend:
   - Login: `admin/login.php`
   - Standard: Benutzername/Passwort in `conf/admin.php` (bitte Passwort-Hash anpassen!)
   - Uploads: `admin/uploads.php` (Mehrfach-Upload für KKS/KM)

## Kreismeisterschaften (KM)
- Übersicht: `km.php` ohne Parameter
- Jahr: `km.php?year=YYYY`
- Logik: bis 2023 HTML-Ergebnisse (`results/km_YYYY/e<ID>.html` / `m<ID>.html`), ab 2024 PDF (`.pdf`)
- DB-Tabellen: `srd_kreis_v2`/`srd_kreis_v3` werden gelesen; Dateien werden auf Existenz geprüft

## Kreiskönigsschießen (KKS)
- Seite: `kks_results.php`
- Automatische PDF-Liste je Jahr aus `results/kks/`

## Kreisrundenwettkämpfe (RWK)
- Archivseiten: `krw_luft.php`, `krw_feuer.php`
- Aktuelle RWK: Link zur Ligaverwaltung `https://www.rwk-onlinemelder.de/online/listen/nssvksv09`

## Branding & Design
- Logo: Konfiguration `conf/branding.php` → `themes/images/ksv-logo.png`
- Dark Mode: Toggle in Navbar, Zustand in `localStorage` (`srd-color-mode`)

## Sicherheit
- Sessions gehärtet in `conf/session.php` (httponly, samesite=Lax, secure bei HTTPS)
- Admin-Login und Uploads mit CSRF-Token

## Dateikonventionen
- KM PDFs: `results/km_YYYY/e<ID>.pdf` (Einzel), `results/km_YYYY/m<ID>.pdf` (Mannschaft)
- KKS PDFs: `results/kks/YYYY_<Bezeichnung>.pdf` (z. B. `2025_Kreiskoenig.pdf`)

## Pflege
- Neue Jahre anlegen: Ordner `results/km_YYYY/` erzeugen; Dateien gemäß Konvention hochladen (Admin-Upload oder FTP)
- KKS PDFs ins `results/kks/`-Verzeichnis legen

## Lizenz
- MIT (siehe Footer)
