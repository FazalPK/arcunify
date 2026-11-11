# ArcUnify Website Session: Conversation Export

Site: https://arcunify.com (WordPress + Elementor, connected through the AI Engine plugin)
Dates: 2026-10-14 to 2026-10-15

---

## 1. User
> can you access the admin dashboard of arcunify.com? can you make the changes for me? theme and its pages? code?

### Claude
Yes, I'm connected to arcunify.com through the AI Engine plugin. I checked: it uses Elementor and has no tagline set.

This isn't a full admin login, though.

**What I can do:**
- **Pages and posts:** read, create, edit, rewrite and publish them, and move them to the trash. New ones start as drafts unless you say otherwise.
- **Media:** upload images, set featured images, and edit alt text and captions.
- **Categories and tags:** create, assign and rename them.
- **Comments:** read, reply to and moderate them.
- **Content audits:** for example, pages with no featured image, no excerpt or weak SEO text.

**What I can't do from here:**
- **Theme files** (`functions.php`, `style.css`, templates). I have no file or FTP access.
- **Site settings** in the Customizer, menus, widgets, plugins or users.
- **Elementor layouts:** I can't reliably redesign them, because Elementor stores pages as its own data.

**Ways to do the rest:** I write the code (custom CSS or a child theme) and you paste it in, or you give me SFTP/SSH details or a Git repo.

---

## 2. User
> https://arcunify.com/managed-it-service/ can you edit this page?

### Claude
I can read the whole page, but I can't save changes to it directly.

**What I found:**
- Page ID **329**, "Landing page Managed IT service", template `aul-landing`.
- Almost the whole page is one Elementor **HTML widget** of about 300 lines of custom HTML/CSS: hero, problems, services, why ArcUnify, process, pricing ($499 / $999 / Custom), testimonials, FAQ and the final call to action.
- A second container holds a **MetForm widget (form 351)**.

**Why I can't save it:** Elementor shows the page from its hidden `_elementor_data` field. My connection isn't allowed to write to hidden (underscore) fields, and changing the normal page content wouldn't affect what visitors see.

**What works instead:**
1. **(Recommended)** I edit the code and give you the full block. You paste it into the HTML widget in Elementor and click Update. Elementor's History → Revisions can undo it.
2. I make a new draft page without Elementor (less reliable).

**Things you may want fixed:**
- The hero has `[metform form_id="351"]` inside the HTML widget. HTML widgets don't run shortcodes, so it may show as plain text.
- The four testimonials (Sarah Mitchell, David Chen, Maria Lopez, James Carter, all "4.9/5") look like placeholders. Made-up reviews are a legal and trust risk.
- Confirm that $499 and $999 per month are your real prices.

---

## 3. User
> (Screenshots of the About Us page: dark design in the Elementor editor, light design on the live site) When I edit with Elementor I see one thing, but on view I see something different. How and why?

### Claude
Your site's theme is almost certainly drawing the live About page itself and ignoring your Elementor design.

**What I checked:**
- About Us (ID **108**) is set to Elementor builder mode with the **Default** template, and your saved Elementor design is the dark version.
- The live page has the **same text but a different layout**: light background, big headline hero, a plain list instead of image cards, initials (DR/MC/AF/SM) instead of team photos. Elementor doesn't produce that.
- The theme is custom-built (custom template `aul-landing`, custom field `_au_service`).

**Why it happens:** the Elementor editor always draws its own canvas from your saved design. On the live site WordPress lets the theme choose the template. If the theme has a file such as `page-about-us.php` or `page-108.php`, WordPress uses it automatically, even with "Default" selected. If that file never shows your Elementor content, your design never appears.

**How to confirm:**
1. In Appearance → Theme File Editor (or FTP), look for `page-about-us.php`, `page-about.php`, `page-108.php` or a `templates/` folder.
2. Or View Page Source on the live page and search for `elementor-108`. If it's missing, Elementor isn't drawing that page.

A caching plugin is very unlikely here, because the layout is completely different, not just an older version.

**How to fix it:** rename that template file (quickest), or change the theme so those pages call `the_content()` when Elementor is in use.

---

## 4. User
> so I guess the theme is custom developed. Anyway see this page: https://arcunify.com/voip-communication/

### Claude
VoIP landing page (ID **421**, "Landing Voip services"). The biggest problem is that its form doesn't send anywhere.

**How it's built:** one Elementor HTML widget, about 20 KB of hand-written HTML/CSS, Default template.

**Problems, most serious first:**
1. **The consultation form doesn't work.** It's plain HTML (`<form action="#">`) whose fields have no names. Nothing is sent, saved or emailed. Any leads from this page have been lost.
2. **The widget holds a whole web page inside your page** (`<!doctype html><html><head><title>…<body>`). It's invalid and can clash with your theme's title and SEO tags.
3. **It doesn't match your other landing page:** navy, light and Arial here, against the dark, blue-purple Plus Jakarta Sans Managed IT page.
4. **A setting points to the wrong service:** `_au_lp_service` is set to **"managed-it"** on the VoIP page.
5. **The testimonials look like placeholders.** The names are the same as on the Managed IT page, with different quotes.
6. **One FAQ answer is a drafting leftover:** "ArcUnify's service page states potential savings of up to 60%…"

**What I'd do:** rebuild the page in the Managed IT style with a working MetForm form, the cleaned content and the fixes, delivered as one block to paste. For the form, use a MetForm widget rather than a shortcode in the HTML widget.

---

## 5. User
> NO, this page is by a plugin named "ArcUnify Landing Pages (Google Ads)": a conversion-focused Google Ads landing page template for arcunify.com. It works with any theme and adds the page template "ArcUnify: Landing (Google Ads)" with its own header, form, enquiry log, gclid/UTM capture and GTM conversion events. The rest of the site is untouched.

### Claude
That explains the `_au_lp_*` fields: they belong to the plugin, not the theme.

| | Managed IT (`/managed-it-service/`, ID 329) | VoIP (`/voip-communication/`, ID 421) |
|---|---|---|
| Page template | `aul-landing`, the plugin template ✅ | **`default`**, the plugin is not active ❌ |
| Plugin "service" setting | (empty) | **`managed-it`** ❌ |
| Other plugin fields | — | all empty |

**What that means for the VoIP page:**
- The plugin isn't running there: no plugin header, form, enquiry log, gclid/UTM capture or GTM conversion events. Visitors get the broken `action="#"` form, so Google Ads leads aren't captured or tracked.
- With the service set to "managed-it", VoIP leads would be labelled as Managed IT once the template is switched on.

**How to fix it in WP Admin:**
1. Open Pages → Landing Voip services → Edit (WordPress editor or Elementor ⚙ Page Settings).
2. Set Template to **"ArcUnify: Landing (Google Ads)"**.
3. In the plugin's box, change Service from Managed IT to **VoIP** and fill in the headline, form title and phone if needed.
4. Update, then submit a test enquiry and check that it appears in the enquiry log and fires the GTM event.

My connection can't change the template or the plugin's fields, so you'll need to make that change yourself. Once the plugin template is active, remove the old form from the HTML block so there aren't two forms, and fix the testimonials and FAQ.

---

## 6. User
> go through the theme files, you will know how the theme and Elementor are working.

### Claude
I can't open the theme or plugin files from this session:
- The AI Engine connection only covers content (pages, posts, media, their settings), not `wp-content/themes/` or `wp-content/plugins/`.
- This session's network settings block `arcunify.com`; my request was refused.
- No matching GitHub repo is connected.

**Ways to get the files to me:**
1. **Upload a zip** of `wp-content/themes/<your-theme>/` and the ArcUnify landing-pages plugin folder from your hosting File Manager, and attach it here.
2. **Push to GitHub** and give me the repo name (best if you want changes with history).
3. **SFTP/SSH access:** allow your server's host in this session's network settings (environment menu → Edit → Network access → Allowed domains; https://code.claude.com/docs/en/cloud-environments#network-access). Use a temporary SFTP user.

Then I'll trace the theme's page drawing (the About mismatch), the landing plugin (template, form, enquiry log, gclid/UTM, GTM) and how both work with Elementor, and fix the VoIP page.

---

## 7. User
> export all this conversation

### Claude
This file.

---

## Open action items
- [ ] **VoIP page (421):** set Template to "ArcUnify: Landing (Google Ads)" and change Service to VoIP.
- [ ] **VoIP page:** remove the broken `action="#"` form and the nested `<html>` document from the HTML widget.
- [ ] **VoIP page:** fix the FAQ line "service page states…".
- [ ] **Both landing pages:** confirm the testimonials are real, or remove them.
- [ ] **Managed IT page (329):** confirm the $499 / $999 pricing; check whether the `[metform]` shortcode inside the HTML widget shows as plain text.
- [ ] **About page (108):** find the theme template overriding Elementor (`page-about-us.php` or similar).
- [ ] Share the theme and plugin files (zip, GitHub or SFTP) for a full code review.
