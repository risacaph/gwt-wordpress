=== BSA Visitor Counter ===
Contributors: Barangay San Agustin
Tags: visitor counter, page views, statistics
Requires at least: 4.4
Requires PHP: 7.0
Stable tag: 1.0.0
License: MIT

A lightweight visitor / page-view counter for the Barangay San Agustin GWT theme.

== Description ==

Shows a visitor counter in the upper-right of the masthead (or as a floating
badge / shortcode). Counting is done server-side and stored in the WordPress
database — no third-party service required.

Features:

* Two count modes — unique visitors (once per browser per day) or total page views.
* Three placements — masthead top bar (upper-right, recommended), floating badge,
  or manual via the `[visitor_counter]` shortcode.
* Configurable label, optional eye icon, optional "starting number" offset,
  and hide-on-mobile.
* Skips admins, bots, feeds, REST/AJAX/cron requests.
* One-click "Reset counter to zero".

All options live under **Settings → Visitor Counter**.

== Installation ==

1. Copy the `bsa-visitor-counter` folder into `wp-content/plugins/`
   (or upload the zip via Plugins → Add New → Upload Plugin).
2. Activate **BSA Visitor Counter** under Plugins.
3. Go to **Settings → Visitor Counter** to configure it.

The Barangay San Agustin GWT theme automatically renders the counter in the
masthead upper-right when this plugin is active (via a `function_exists()`
guard, so the theme works fine with or without the plugin).

== Usage ==

* Position "Masthead top bar" — appears in the upper-right of the header.
* Position "Floating badge" — fixed badge pinned to the upper-right corner.
* Anywhere in content — use the shortcode: `[visitor_counter]`
* In a template — call: `<?php if ( function_exists( 'bsa_vc_render' ) ) echo bsa_vc_render(); ?>`

== Changelog ==

= 1.0.0 =
* Initial release.
