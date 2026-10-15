# ArcUnify WordPress Theme — v1.1.0 (core, homepage, all inner pages)

Custom, dependency-free theme for arcunify.com. It replaces the visual layer only:
page URLs, Elementor page content, GTM tracking and existing copy are preserved.

## What this release includes

| Area | Status |
| --- | --- |
| Design system (tokens, type, buttons, cards, motion) | Done |
| Header: contact bar, sticky bar, Services mega-menu, mobile menu | Done |
| Footer, mobile sticky consultation bar | Done |
| Native homepage (all sections, existing copy) | Done |
| Elementor pages rendered inside the new header/footer | Done |
| 404, default page, blog/archive fallbacks | Done |
| Service template: 5 services, each with its own diagram | Done |
| About, Services overview, Contact (with working enquiry form) | Done |
| Testimonials (all 24 from the live site, seeded on activation) | Done |
| Structured data: Organization, BreadcrumbList, FAQPage | Done |

## Install on staging (never straight to live)

1. Back up files + database. Export the Elementor Kit (Templates → Kit).
2. Appearance → Themes → Add New → Upload `arcunify.zip` → Activate.
3. If Elementor Pro Theme Builder has a Header or Footer template, set its display
   conditions to none. (The theme never prints Elementor header/footer locations,
   so nothing doubles up, but this keeps admin tidy.)
4. Appearance → Menus: create a "Header" menu with **Services** (`/services/`), **About**, **Contact**.
   Open Screen Options → tick **CSS Classes**, and give the Services item the class `au-mega`
   (this replaces its dropdown with the grouped Services panel). Assign it to *Header navigation*.
   With no menu assigned, the theme shows this exact menu automatically.
5. Customize → Site Identity: upload the logo (a light/white version — the header is dark).
6. Customize → ArcUnify: check contact details, header button, pricing.
7. Elementor → Tools → Regenerate CSS & Data. Clear any page cache.
8. Check: GTM fires once (see "Tracking" below), every page loads, menus work on mobile.

## Where the owner edits things

| What | Where |
| --- | --- |
| Logo | Customize → Site Identity |
| Menus | Appearance → Menus (header, footer company links, legal links) |
| Phone, email, address, support line, header button, social links | Customize → ArcUnify → Contact & header |
| Hero text and buttons, "Why Choose" claim lines on/off, homepage source | Customize → ArcUnify → Homepage |
| Counters, logo strip, per-service stats | Customize → ArcUnify → Proof (verified only) |
| Pricing plans | Customize → ArcUnify → Pricing plans |
| Testimonials | Testimonials menu (only items ticked **Verified** are ever shown) |
| GTM ID | Customize → ArcUnify → Advanced |

Other homepage copy (About, Why Choose, Process, section headings) is the live site's
existing wording, kept verbatim in `inc/content.php` and filterable
(`arcunify_home_content`, `arcunify_services`). Change it only with client sign-off.

## Existing proof content (confirmed "as is" by the client)

- **Testimonials:** all 24 from the live site (homepage set + 4 per service page, with
  roles and "Rated 4.9/5") are created automatically on first activation, marked
  Verified. Edit them under **Testimonials**. Service pages show their own set.
- **Team, claims, pricing, FAQ:** shown exactly as on the live site.
- **Logo strip:** uses the 9 logo images already in the site's uploads
  (`/wp-content/uploads/2026/06/Vector*.png`). Add alt text to each in Media.
- **Service result stats:** prefilled where the site states the same figure in its own
  copy: VoIP 60%, Cybersecurity 70%, Cloud 40%, Network 99.99%.
- **Needs 4 numbers:** the live counters only render in JavaScript, so their values
  could not be read: Tech Experts, Client Satisfaction, Industries Served, and
  Businesses supported (Managed IT). Copy them from the Elementor counter widgets into
  Customize → ArcUnify → Proof. Each one appears as soon as it has a number.

## How pages get the new design

With **Customize → ArcUnify → Pages & contact form → Use the new designs** ticked (default),
these slugs use native templates automatically: `services`, `about-us`, `contact-us`,
`managed-it-services`, `cybersecurity-solutions`, `cloud-and-data-solutions`,
`network-infrastructure`, `voip-unified-communications`. URLs do not change.
Untick it to show the old Elementor content inside the new header/footer instead.
Any page can also pick a template in its Template setting (ArcUnify: Service /
About / Contact / Services overview); for the Service template, choose the service in
the "ArcUnify service" box if the slug doesn't match. Elementor's editor/preview is
unaffected. Unmapped pages (e.g. the campaign landing page) keep rendering with Elementor.

## Contact form

The live site had no form, so the theme includes one: name, work email, phone, company,
service of interest, message. Spam protection without CAPTCHAs: nonce, hidden honeypot,
3-second minimum fill time, and 5 submissions/hour per IP. Every enquiry is saved under
**Enquiries** in WP admin and emailed to `info@arcunify.com` (change in Customize →
ArcUnify → Pages & contact form). Install an SMTP plugin (e.g. WP Mail SMTP) so email
reliably arrives. To use a form plugin instead, paste its shortcode in the same panel.
A privacy policy page (Settings → Privacy) adds a privacy note under the form.

## Structured data

Organization (homepage), BreadcrumbList (inner pages) and FAQPage (Contact). If Yoast or
Rank Math already outputs Organization schema, untick it in Customize → ArcUnify → Advanced.

## Rolling back the homepage

Customize → ArcUnify → Homepage → **Homepage content: Existing Home page content**
shows the old Elementor homepage inside the new header/footer. Switching themes
back restores everything else; the theme never modifies page content.

## Tracking

GTM `GTM-KRNHXWK2` is output in `<head>` and as the `<noscript>` body tag, as on
the current site. If a plugin (Site Kit, GTM4WP) also outputs it, clear the ID in
Customize → ArcUnify → Advanced so it only loads once.

## Structure

```
arcunify/
├── functions.php            loader only
├── inc/
│   ├── content.php          existing homepage copy (single source of truth)
│   ├── content-pages.php    existing inner-page copy, team, testimonials seed
│   ├── templates.php        slug → native template map, service meta box
│   ├── contact-form.php     enquiry handler + Enquiries admin list
│   ├── schema.php           JSON-LD
│   ├── helpers.php          arcunify_mod(), arcunify_icon(), arcunify_button(), URLs
│   ├── theme-setup.php      supports, menus, image sizes, icon sprite
│   ├── customizer.php       one schema → all settings, sanitisers, defaults
│   ├── enqueue.php          font preload, CSS, deferred JS
│   ├── nav-walker.php       accessible menus + Services mega panel
│   ├── testimonials.php     post type with Verified flag
│   ├── performance.php      emoji/head clean-up, block CSS off on homepage
│   ├── elementor-compat.php Elementor page detection, Kit class handling
│   └── tracking.php         GTM
├── template-parts/
│   ├── header/  site-header, mega-services
│   ├── footer/  site-footer, mobile-cta
│   ├── components/ section-header, page-hero, service-card, testimonial, breadcrumb, contact-form
│   ├── visuals/  managed, security, cloud, network, voice (SVG diagrams)
│   └── sections/ home-hero, home-proof, home-about, home-services, home-outcomes,
│                 home-why, home-process, home-pricing, home-testimonials, cta
├── page-templates/ service.php, services-hub.php, about.php, contact.php
├── front-page.php, page.php, single.php, index.php, 404.php, header.php, footer.php
├── assets/
│   ├── css/src/  01-tokens … 06-elementor (→ theme.css), home-* + pages-* (→ sections.css)
│   ├── js/theme.js           ~9KB, no dependencies
│   ├── fonts/                Plus Jakarta Sans variable, latin (27KB, OFL)
│   └── images/icons.svg      Lucide icons (ISC) as a sprite
└── build.sh                  rebuilds theme.css / home.css after editing src
```

Edit CSS in `assets/css/src/`, then run `sh build.sh`. Section CSS loads only on pages
rendered by native templates.

## Elementor compatibility notes

- Theme selectors for the header/footer are two classes deep so Elementor Kit rules
  (`.elementor-kit-N a`, headings) cannot restyle them on Elementor pages.
- On the native homepage the `elementor-kit-N` body class is removed so Kit
  typography does not leak into theme sections.
- Elementor pages keep their own banners and sections until each is migrated to a
  native template in the next phases (page content and Elementor data stay intact).

## Tested

Local WordPress 6.8 / PHP 8.3, Chromium. No PHP notices, no JS errors on any page.
No horizontal overflow on all 9 pages at 320, 375, 414, 768, 1024, 1280, 1920px.
Contact form tested end to end (validation, stored enquiry, honeypot). Keyboard: mega-menu opens with
Enter, Tab moves into it, Esc closes and returns focus; mobile menu traps focus and
closes on Esc. `prefers-reduced-motion` disables the arc animation and reveal.
