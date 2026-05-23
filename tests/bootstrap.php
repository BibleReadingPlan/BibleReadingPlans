<?php
/**
 * Bootstrap for BibleReadingPlans test suite.
 *
 * Provides minimal WordPress stubs and a real HTTP implementation of
 * wp_remote_get() via PHP's curl extension, so integration tests can
 * hit live APIs without running inside WordPress.
 */

declare(strict_types=1);

// Change to plugin root so relative require paths inside the plugin resolve
// correctly when load_property_values() is called.
chdir(dirname(__DIR__));

// ── WordPress stubs ────────────────────────────────────────────────────────────

if (!class_exists('WP_Error')) {
    class WP_Error
    {
        public function __construct(
            private readonly string $code    = '',
            private readonly string $message = ''
        ) {}

        public function get_error_code(): string    { return $this->code; }
        public function get_error_message(): string { return $this->message; }
    }
}

if (!function_exists('is_wp_error')) {
    function is_wp_error(mixed $thing): bool
    {
        return $thing instanceof WP_Error;
    }
}

/**
 * Real HTTP GET via curl, returning a WordPress-compatible response array
 * or WP_Error on network failure.
 */
if (!function_exists('wp_remote_get')) {
    function wp_remote_get(string $url, array $args = []): array|WP_Error
    {
        $headers = $args['headers'] ?? [];
        $timeout = (int) ($args['timeout'] ?? 60);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,            $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER,         true);
        curl_setopt($ch, CURLOPT_TIMEOUT,        $timeout);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_USERAGENT,      'BibleReadingPlans/3.0 (integration-test)');

        if (!empty($headers)) {
            $formatted = [];
            foreach ($headers as $name => $value) {
                $formatted[] = "{$name}: {$value}";
            }
            curl_setopt($ch, CURLOPT_HTTPHEADER, $formatted);
        }

        $raw         = curl_exec($ch);
        $curlError   = curl_error($ch);
        $httpCode    = (int) curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $headerSize  = (int) curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        // curl_close($ch);

        if ($curlError !== '') {
            return new WP_Error('http_request_failed', $curlError);
        }

        $rawStr      = (string) $raw;
        $body        = substr($rawStr, $headerSize);
        $statusLine  = strtok(substr($rawStr, 0, $headerSize), "\r\n");
        preg_match('/HTTP\/[\d.]+ \d+ (.+)/', (string) $statusLine, $m);

        return [
            'headers'  => [],
            'body'     => $body,
            'response' => ['code' => $httpCode, 'message' => trim($m[1] ?? '')],
            'cookies'  => [],
        ];
    }
}

if (!function_exists('wp_remote_retrieve_body')) {
    function wp_remote_retrieve_body(array $response): string
    {
        return $response['body'] ?? '';
    }
}

if (!function_exists('plugin_dir_url')) {
    function plugin_dir_url(string $file): string { return ''; }
}

if (!function_exists('plugin_dir_path')) {
    function plugin_dir_path(string $file): string
    {
        return rtrim(dirname($file), '/') . '/';
    }
}

if (!function_exists('__')) {
    function __(string $text, string $domain = 'default'): string { return $text; }
}

if (!function_exists('_e')) {
    function _e(string $text, string $domain = 'default'): void { echo $text; }
}

if (!function_exists('get_option')) {
    function get_option(string $option, mixed $default = false): mixed { return $default; }
}

if (!function_exists('update_option')) {
    function update_option(string $option, mixed $value, bool $autoload = true): bool { return true; }
}

if (!function_exists('delete_option')) {
    function delete_option(string $option): bool { return true; }
}

if (!function_exists('is_admin')) {
    function is_admin(): bool { return false; }
}

if (!function_exists('add_shortcode')) {
    function add_shortcode(string $tag, callable $callback): void {}
}

if (!function_exists('add_action')) {
    function add_action(string $hook, mixed $callback, int $priority = 10, int $accepted_args = 1): bool { return true; }
}

if (!function_exists('add_filter')) {
    function add_filter(string $hook, mixed $callback, int $priority = 10, int $accepted_args = 1): bool { return true; }
}

if (!function_exists('admin_url')) {
    function admin_url(string $path = '', string $scheme = 'admin'): string
    {
        return '/wp-admin/' . ltrim($path, '/');
    }
}

if (!function_exists('includes_url')) {
    function includes_url(string $path = ''): string { return ''; }
}

if (!function_exists('shortcode_atts')) {
    function shortcode_atts(array $pairs, array $atts, string $shortcode = ''): array
    {
        $out = [];
        foreach ($pairs as $name => $default) {
            $out[$name] = array_key_exists($name, $atts) ? $atts[$name] : $default;
        }
        return $out;
    }
}

if (!function_exists('wp_register_style'))  { function wp_register_style(): void {} }
if (!function_exists('wp_enqueue_style'))   { function wp_enqueue_style(): void {} }
if (!function_exists('wp_enqueue_script'))  { function wp_enqueue_script(): void {} }
if (!function_exists('wp_register_script')) { function wp_register_script(): void {} }

// ── Load the plugin class ─────────────────────────────────────────────────────

require_once dirname(__DIR__) . '/bible-reading-plans-class.inc.php';

// ── BibleReadingPlansTestHelper ───────────────────────────────────────────────

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

    /**
     * Uses absolute paths and plain `require` so that every new instance in
     * the same PHP process gets freshly-set properties (require_once would
     * skip re-execution after the first instance).
     */
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

    /** Prevent plan files from being deleted during tests. */
    protected function add_readings_plans_arrays_to_database(): void {}

    // ── Source / version helpers ───────────────────────────────────────────────

    /** Set the active Bible source (ABS, DBP, or ESV). */
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

    // ── Exposed protected methods ─────────────────────────────────────────────

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
