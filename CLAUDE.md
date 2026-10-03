# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project

WordPress plugin ("Bible Reading Plans") that renders daily Bible reading plans via the `[bible-reading-plan ...]` shortcode, pulling scripture text/audio from three APIs: ABS (API.Bible), DBP (Bible Brain / Digital Bible Platform v4), and ESV. Published to wordpress.org via SVN. The plugin header claims PHP 5.6 support; dev tooling (composer/PHPUnit 11) requires PHP 8.2+.

## Commands

```sh
make wp-env-start        # start wp-env (Docker WordPress, plugin mapped to wp-content/plugins/BibleReadingPlans)
make test                # run PHPUnit inside the wp-env tests-cli container
make test-local          # run phpunit locally, sourcing API keys from .env
make test-show-dep       # local run with --display-deprecations
make composer            # composer update (dev deps: phpunit, wp-phpunit, polyfills)
make zip                 # build bible-reading-plans.zip for distribution
make svn                 # copy release files into ~/src/svn/bible-reading-plans/trunk
```

Single test: `npx wp-env run tests-cli --env-cwd wp-content/plugins/BibleReadingPlans -- phpunit --filter testDbpUrlConstructionForJanuary1` (or `vendor/bin/phpunit --filter <name>` locally).

- `make test-local` only works with a configured `wp-tests-config.php` (WP_TESTS_DOMAIN etc.); otherwise use wp-env.
- `phpunit.xml` only includes `tests/RemoteGetTest.php`; `tests/BibleReadingPlansTest.php` is an older mock-based file not in the suite.
- URL-construction tests need no keys. Live remote-fetch tests are skipped unless `BRP_DBP_KEY`, `BRP_ABS_KEY`, `BRP_ESV_KEY` are set (env vars locally, or wp-config constants via the gitignored `.wp-env.override.json`, which `tests/bootstrap.php` promotes to env vars).

## Architecture

- `bible-reading-plans.php`: plugin header + includes. `bible-reading-plans-hooks.inc.php`: on `init`, instantiates `BibleReadingPlans` and registers admin/AJAX (`wp_ajax_put_bible_reading_plan`, etc.) or front-end hooks.
- `bible-reading-plans-class.inc.php`: a single ~3400-line `BibleReadingPlans` class containing everything (settings page, shortcode, API URL building, fetching, HTML rendering). Per-source logic follows a naming pattern: `construct_urls_array_{abs,dbp,esv}`, `put_verses_{abs,dbp,esv}`, `remote_get_scriptures[_dbp]`.
- Rendering flow: the shortcode (`shortcodeAttributes`) outputs a placeholder; `addScriptureLoader` (wp_footer) emits jQuery that AJAX-calls `putBibleReadingPlan`, which runs `get_bible_reading_plan` to fetch and format that day's passages.
- `includes/properties/*.inc.php`: data files `require`d inside `load_property_values()` that assign `$this->...` properties (sources, book codes, defaults, holy days, etc.). They run in class scope, so they must use `$this`.
- `includes/abs.php`: ABS base URL selection (key length 21 → newer `rest.api.bible` endpoint).
- DBP text is fetched per book from a fileset chosen by `dbp_text_fileset_for_book()`. Some versions (e.g. NLT: `ENGNLTO_ET` / `ENGNLTN_ET`) have no complete-Bible text fileset, so when `bible_id` covers only one testament the companion fileset is found from the cached `bible_reading_plans_dbp_versions` option (matching `bible_abbr`, `type`, `size`), falling back to swapping the O/N 7th character of the ID. Audio has explicit `bible_ot_audio_id` / `bible_nt_audio_id` attributes instead.
- Reading plans are stored canonically in DBP v4 format (`dbp_v => 4`, verses like `GEN/1?verse_start=1&verse_end=999`); ABS versions are derived with `convert_dbp4_plan_to_abs_plan`, and older DBP2 plans are upgraded via `convert_dbp2_plan_to_dbp4_plan`. Plans also come from the premium "Create Bible Reading Plans" plugin (option keys with `cbrp_` prefix vs. built-in `brp_` prefix).

### Gotcha: plan files delete themselves

`add_readings_plans_arrays_to_database()` (called from the constructor) includes each `includes/plans/*.php`, saves it to `wp_options` for each source, then **`unlink`s the file**. Because wp-env mounts the repo directly, loading WordPress locally deletes the tracked plan files from the working tree. `npx wp-env start` alone triggers this, since the plugin is active on the dev site. Restore with `git checkout HEAD -- includes/plans/` after starting wp-env and before testing or committing, and never commit those deletions. `RemoteGetTest` reads `includes/plans/mcheyne.php` directly, and `tests/class-brp-test-helper.php` overrides this method as a no-op.

## Releases

A version bump updates `bible-reading-plans.php` (header `@version` and `Version:`), `README.md`, and `readme.txt` (stable tag + changelog). Keep `README.md` and `readme.txt` in sync. The copyright notice from the scripture source must remain on rendered pages.
