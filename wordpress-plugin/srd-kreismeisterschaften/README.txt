SRD Kreismeisterschaften (WordPress-Plugin)
===========================================

Installation
------------
1. Ordner `srd-kreismeisterschaften` nach `wp-content/plugins/` kopieren.
2. Im WordPress-Backend Plugin aktivieren.
3. Den kompletten Inhalt des bisherigen `results`-Verzeichnisses auf den Server legen, z. B. nach `wp-content/uploads/srd-results/`.
4. Unter „Einstellungen“ → „SRD Kreismeisterschaften“:
   - Seite wählen, die nur den Shortcode `[srd_km]` enthält (oder Seite anlegen und Shortcode einfügen).
   - Optional: absoluten Pfad und öffentliche URL zu diesem `results`-Ordner setzen (Standard: `wp-content/uploads/srd-results`).
   - Datenbank: wenn `srd_kreis_v3` in derselben Datenbank wie WordPress liegt, „WordPress-Datenbank verwenden“ aktiv lassen.

URL-Parameter (an die KM-Seite angehängt)
------------------------------------------
- Jahresübersicht: keine Parameter
- Jahr (Kugel-Disziplinen): `?km_year=2025`
- Bogen: `?km_year=2025&km_discipline=bogen`
- Blasrohr: `?km_year=2025&km_discipline=blasrohr`
- HTML-Einzel/Mannschaft: `?km_year=2020&km_id=…&km_art=e` bzw. `m`

Das alte `km_results.php` entfällt; HTML-Ergebnisse werden per iframe über `km_view=raw` ausgeliefert.

Abschaltung des alten PHP-Projekts
----------------------------------
Nach Migration: nur noch sicherstellen, dass PDF-/Statik-URLs erreichbar sind (gleiche Ordnerstruktur unter `results`).
