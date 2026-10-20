# Study Mind Blocks (homepage + header/footer)

ACF blocks built from the **Study Mind Block Library** design. The design's markup and CSS are reused as-is. Only the text and images were swapped for fields, so class names match the design one-for-one.

Requires **WordPress 6.4+** and **ACF PRO 6.x** (for repeaters, galleries, the options page and ACF blocks).

## Install

1. Copy `studymind-blocks/` to `wp-content/plugins/` and activate it. Later it can move into the theme (see "Moving into the theme").
2. Go to **ACF > Field Groups**. If "Sync available" appears, sync the 8 Study Mind groups. Nothing breaks without syncing: the fields still load from `/acf-json`.
3. Header and footer: their content is under **Appearance > Header & Footer**.
   - Classic theme: call `<?php studymind_header(); ?>` right after `wp_body_open()` in `header.php`, and `<?php studymind_footer(); ?>` in `footer.php`.
   - Block theme: put the **Site Header** block in the header template part and the **Site Footer** block in the footer one.
4. Homepage: create the page, open the inserter, go to **Patterns > Study Mind** and insert **Study Mind homepage**. That adds all 7 blocks in order. They're also listed one by one under the **Study Mind** block category.

Each block falls back to the design's own copy when a field is empty, so it looks exactly like the design as soon as it's inserted. Content editors overwrite fields from there.

## Blocks

| Block | Design code | Notes |
|---|---|---|
| Site Header | F01 Navigation | Options page. Menu is a repeater with optional dropdowns and a dropdown icon per link. The section matching the current URL gets the design's `current` style. Mobile burger in `view.js`. |
| Homepage Hero | H01 | Background video (MP4) + poster, service pills, product finder (search tab + 4-question quiz), government badge, avatars. |
| Products Toolkit | R07 | Product tabs on the left swap the panel on the right. Stats are shared by all products. |
| Sister Brands | R08 | 3 cards. Pick each card's colour theme (Medic / Oxbridge / Law). |
| Why Study Mind | T06 | Count-up stats + testimonial carousel. Giving a card a video link adds the play icon. |
| Success Stories | T07 | Masonry cards: image, "tall" toggle, optional video link. |
| Trust Logos | T08 | Logo gallery. |
| Awards and Enquiry | T09 | Award badges + dark form card. Add your form plugin's shortcode in **Form shortcode**. Until then the design form shows but doesn't submit. The section keeps `id="enquire"` because the header's Contact Us button links to `#enquire`. |
| Site Footer | F05 | Options page. The library notes F05 replaces the homepage's older footer. |

**Starter content to replace:** the finder's product list and quiz questions 2–4 (the design only shows the empty search box and question 1), and toolkit products 2–5's chips, button labels and links (the design only shows product 1's panel). Everything else is the design's copy. The order of the homepage blocks follows the Block Library. Confirm it with the designer.

## How the CSS works

- `assets/css/sm-home.css` and `assets/css/sm-shared.css` are the design's stylesheets, **unchanged** apart from being scoped under `.sm-home` and `.sm-shared`. The design has two stylesheets with clashing class names (`.wrap`, `.btn`, `.hero`...), so scoping keeps them apart. `sm-shared.css` is the full shared sheet, so other pages' blocks can use it later.
- `assets/css/wp-fixes.css` is the only hand-written CSS: the scope wrappers use `display: contents`, there's real-image handling inside the design's `.ph` placeholders, a sticky-header offset for the admin bar, and the mobile menu scroll lock.
- Don't edit the two design files by hand. If the design changes, regenerate them: `node tests/scope-css.js designs/homepage.css sm-home assets/css/sm-home.css` (needs `npm i postcss`).
- All CSS and the Google Fonts request load in both the front end and the block editor, so the editor preview is the real design.
- `display: contents` on the wrappers means WordPress block-gap margins have nothing to attach to. If your theme still adds spacing or heading styles, check `theme.json` global styles first.

## Verified

Every block was rendered from its `render.php` with default content and screenshot-diffed against the design's own markup and CSS at 390, 834 and 1440px wide. **Every block came out at 0% pixel difference.** The header matches on an Our Services URL, because the design snapshot shows that item as current. The finder, toolkit tabs, counters, carousel and mobile menu were also clicked through in a browser with no JS errors. `tests/harness.php` renders any block outside WordPress (`php tests/harness.php home-hero`) if you want to rerun the comparison. The original block markup is in `/designs` for reference.

## Moving into the theme

Copy the folder into the theme (e.g. `inc/studymind-blocks/`), `require` `studymind-blocks.php` from `functions.php`, and swap `plugin_dir_path`/`plugin_dir_url` for `get_theme_file_path`/`get_theme_file_uri` in the three `define()` lines.
