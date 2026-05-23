<?php
declare(strict_types=1);

/**
 * Testable subclass of BibleReadingPlans.
 *
 * - Skips all WordPress-database access in the constructor.
 * - Overrides load_property_values() to use absolute paths and `require`
 *   (not `require_once`) so that multiple instances created in the same PHP
 *   process all have their properties populated correctly.
 * - Overrides add_readings_plans_arrays_to_database() as a no-op to prevent
 *   plan PHP files from being deleted during tests.
 * - Exposes protected methods via public call*() wrappers.
 */
class BibleReadingPlansTestHelper extends BibleReadingPlans
{
    public function __construct(
        string $abs_api_key = '',
        string $dbp_api_key = '',
        string $esv_api_key = ''
    ) {
        // plugin_url must be set before load_property_values() because
        // miscellaneous.inc.php uses it to build the loading_image path.
        $this->plugin_url = '';

        $this->load_property_values();

        // API keys.
        $this->abs_api_key = $abs_api_key;
        $this->dbp_api_key = $dbp_api_key;
        $this->esv_api_key = $esv_api_key;

        // Append key to DBP query base (mirrors the real constructor).
        $this->dbp_query_base .= "&key={$this->dbp_api_key}";

        // Fields set by the real constructor via __() calls.
        $this->end_verse_name  = 'end';
        $this->err_flag        = 'ERROR';
        $this->api_request_err = ' in request to API -- most probably due to a missing or incorrect API Key for ';
        $this->text_source     = '<br />Scriptures provided by the ';
        $this->no_versns_found = 'No versions found.';

        // Populate ABS version map (required by construct_urls_array_abs).
        $this->abs_versions = $this->abs_vers_default;

        // Disable audio by default.
        $this->dbp_use_audio_all  = false;
        $this->dbp_use_audio_nt   = false;
        $this->dbp_use_audio_ot   = false;
        $this->bible_all_audio_id = '';
        $this->bible_nt_audio_id  = '';
        $this->bible_ot_audio_id  = '';

        // Default source / version / bible_id.
        $this->source           = 'DBP';
        $this->scptr_src_prefix = 'dbp_';
        $this->version          = 'NAS';
        $this->bible_id         = 'ENGNAS';
        $this->dam_id           = 'ENGNAS';
        $this->lng_code_iso     = 'eng';
    }

    protected function load_property_values(): void
    {
        $props = dirname(__DIR__) . '/includes/properties/';
        require $props . 'abs.inc.php';
        require $props . 'book-codes.inc.php';
        require $props . 'dbp.inc.php';
        require $props . 'esv.inc.php';
        require $props . 'holydays-moveablefeasts.inc.php';
        require $props . 'language-name-to-2-letter-code.inc.php';
        require $props . 'miscellaneous.inc.php';
        require $props . 'one-chapter-books.inc.php';
        require $props . 'poetic-passages.inc.php';
        require $props . 'short_code_atts.inc.php';
        require $props . 'sources.inc.php';
    }

    protected function add_readings_plans_arrays_to_database(): void {}

    public function setSource(string $source): void
    {
        $this->source           = $source;
        $this->scptr_src_prefix = strtolower($source) . '_';
    }

    public function setVersion(string $version): void
    {
        $this->version = $version;
    }

    public function setBibleId(string $bible_id): void
    {
        $this->bible_id = $bible_id;
        $this->dam_id   = $bible_id;
    }

    public function callRemoteGetScriptures(array $urls_ary, string $date_key = ''): mixed
    {
        return $this->remote_get_scriptures($urls_ary, $date_key);
    }

    public function callRemoteGetScripturesDbp(array $urls_ary, string $date_key = ''): mixed
    {
        return $this->remote_get_scriptures_dbp($urls_ary, $date_key);
    }

    public function callConstructUrlsArrayAbs(
        array  $readings_querys,
        array &$abs_passages,
        string $version = ''
    ): array {
        return $this->construct_urls_array_abs($readings_querys, $abs_passages, $version);
    }

    public function callConstructUrlsArrayDbp(array $readings_querys): array
    {
        return $this->construct_urls_array_dbp($readings_querys);
    }

    public function callConstructUrlsArrayEsv(array $readings_querys): array
    {
        return $this->construct_urls_array_esv($readings_querys);
    }

    public function callConvertDbp4PlanToAbsPlan(array $reading_plan): array
    {
        return $this->convert_dbp4_plan_to_abs_plan($reading_plan);
    }
}
