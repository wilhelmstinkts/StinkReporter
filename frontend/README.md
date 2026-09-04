# Frontend

Static frontend for the Stink Reporter ("Frischluftheld:in") — the form users
fill in. Plain HTML/CSS/JS, **no build step**, no npm.

## Structure

- `index.html` — the whole page; form logic is inline `<script>`
- `css/` — `normalize.css`, `main.css`, `form.css`
- `js/services/` — `locationService` (OpenStreetMap Nominatim geocoding),
  `reportService` (calls the API), `weatherService` (Open-Meteo, current +
  historical weather shown while filling the form), `mailTemplater`
- `js/views/mapView.js`, `js/lib/` — OpenLayers map + UAParser (vendored)
- `environment.js` — `Environment.isTest()` flag

The form calls the API at the **relative** path `api/v0/report`, so the frontend
and the API (`/api/`) must be served from the same web root.

## Local preview

`docker compose up site` (see `docker-compose.override.yml`) serves this folder
at http://localhost:8081 with the local API mounted at `/api`.

## Deploy

`.github/workflows/deploy-frontend.yml` uploads this folder to the web root via
FTP on a published GitHub Release (or a manual run from the Actions tab). Uses
the same `FTP_*` repo secrets as the backend's `release.yml`.

The backend is deployed separately by `release.yml` (`source/` -> `api/`).
