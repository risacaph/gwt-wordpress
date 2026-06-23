# Barangay San Agustin, Iba, Zambales — Official Website

A static website for **Barangay San Agustin, Iba, Zambales**, built using the styling
and branding conventions of the Philippine **Government Web Template (GWT)** that this
repository ships as a WordPress theme.

This static version renders directly in any browser — no WordPress installation
required — so it can be previewed, hosted on any static host (GitHub Pages, Netlify,
etc.), or used as a content reference when populating the WordPress theme.

## Pages

| File | Description |
|------|-------------|
| `index.html` | Home — hero, quick services, stats, about preview, news, hotlines |
| `about.html` | Profile, history, vision, mission, and core values |
| `officials.html` | Sangguniang Barangay (Punong Barangay, Kagawad, SK, appointed officials) |
| `services.html` | Frontline documents, requirements, fees, and community programs |
| `news.html` | News and announcements |
| `contact.html` | Contact details, emergency hotlines, feedback form, and map |

## How to view

Open `index.html` in a web browser, or serve the folder locally:

```bash
cd barangay-san-agustin
python3 -m http.server 8000
# then visit http://localhost:8000
```

## Customizing

The site is intentionally easy to edit. Replace the placeholder content marked with
bracketed text (e.g. `[Punong Barangay]`) and the sample figures/hotlines with the
official information from the Barangay Hall:

- **Branding & colors:** `assets/css/site.css` (CSS variables at the top — flag blue,
  red, and gold).
- **Barangay seal:** `assets/img/barangay-seal.svg` (a placeholder seal; swap in the
  official seal when available).
- **Officials:** edit `officials.html`.
- **Services & fees:** edit `services.html`.
- **News:** edit `news.html`.
- **Contact info, hotlines, map coordinates:** edit `contact.html`.

> **Note:** Names, fees, phone numbers, news items, and the map marker are placeholders
> for demonstration. Verify and replace them with official barangay data before
> publishing.
