<?php
/**
 * Integration tests for the remote-get features of BibleReadingPlans.
 *
 * URL-construction tests run without any API key.
 * Remote-fetch tests hit the live APIs and are automatically skipped unless
 * the corresponding environment variable is exported before running phpunit:
 *
 *   BRP_ABS_KEY  – API.Bible (American Bible Society) key
 *   BRP_DBP_KEY  – Bible Brain (Digital Bible Platform v4) key
 *   BRP_ESV_KEY  – ESV Bible Web Service key
 *
 * Example (run with a single key):
 *   BRP_DBP_KEY=xxxxxxxx-xxxx-xxxx phpunit
 *
 * Example (run all integration tests):
 *   BRP_ABS_KEY=... BRP_DBP_KEY=... BRP_ESV_KEY=... phpunit
 */

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class RemoteGetTest extends TestCase
{
    /** Jan-1 readings from the M'Cheyne plan in DBP (v4) format. */
    private array $jan1Dbp;

    /** Jan-1 readings from the M'Cheyne plan converted to ABS format. */
    private array $jan1Abs;

    /** Keyless helper instance (sufficient for URL-construction tests). */
    private BibleReadingPlansTestHelper $helper;

    protected function setUp(): void
    {
        // Ensure the plugin root is the working directory so that any relative
        // require paths still used inside the plugin resolve correctly.
        chdir(dirname(__DIR__));

        // Load the M'Cheyne reading plan directly from its source file.
        // The plan file sets $reading_plan in the local scope via include.
        $reading_plan = null;
        include dirname(__DIR__) . '/includes/plans/mcheyne.php';

        if (!is_array($reading_plan)) {
            throw new RuntimeException(
                "Failed to load M'Cheyne plan from includes/plans/mcheyne.php"
            );
        }

        $this->jan1Dbp = $reading_plan['01-01'];

        // Build a keyless helper to use for URL-construction tests and for
        // converting the DBP plan to ABS format.
        $this->helper  = new BibleReadingPlansTestHelper();
        $absPlan       = $this->helper->callConvertDbp4PlanToAbsPlan($reading_plan);
        $this->jan1Abs = $absPlan['01-01'];
    }

    // =========================================================================
    // URL construction tests — no API key required
    // =========================================================================

    /**
     * DBP URL builder must produce one text URL per passage (keyed by passage
     * name) plus one metadata entry for the copyright call.
     */
    public function testDbpUrlConstructionForJanuary1(): void
    {
        $this->helper->setSource('DBP');
        $this->helper->setBibleId('ENGNAS');

        $urls = $this->helper->callConstructUrlsArrayDbp($this->jan1Dbp);

        foreach (['Genesis 1', 'Matthew 1', 'Ezra 1', 'Acts 1'] as $passage) {
            $this->assertArrayHasKey($passage, $urls,
                "DBP URL missing for passage '$passage'");
            $this->assertArrayHasKey('text', $urls[$passage],
                "No 'text' key for passage '$passage'");
            $this->assertNotEmpty($urls[$passage]['text'],
                "Empty text URL array for passage '$passage'");
        }

        $this->assertArrayHasKey('metadata', $urls, 'Metadata URL is missing');

        // Spot-check the Genesis 1 text URL.
        $gen1Url = $urls['Genesis 1']['text'][0];
        $this->assertStringContainsString('4.dbt.io/api/bibles/filesets/ENGNAS', $gen1Url);
        $this->assertStringContainsString('GEN/1',         $gen1Url);
        $this->assertStringContainsString('verse_start=1', $gen1Url);
        $this->assertStringContainsString('verse_end=999', $gen1Url);
        $this->assertStringContainsString('v=4',           $gen1Url);

        // Metadata URL must reference the copyright endpoint.
        $this->assertStringContainsString('4.dbt.io/api/bibles', $urls['metadata']);
        $this->assertStringContainsString('copyright',            $urls['metadata']);
    }

    /**
     * ABS URL builder must produce one verse URL per reading and correctly
     * convert DBP-style verse codes (GEN/1?...) to ABS dot-notation (GEN.1.x).
     */
    public function testAbsUrlConstructionForJanuary1(): void
    {
        $this->helper->setSource('ABS');
        $this->helper->setVersion('ASV');

        $absPassages = [];
        $urls        = $this->helper->callConstructUrlsArrayAbs($this->jan1Abs, $absPassages);

        $this->assertCount(4, $urls,        'Expected 4 ABS URLs for January 1st');
        $this->assertCount(4, $absPassages, 'Expected 4 passage labels');

        $this->assertStringContainsString('scripture.api.bible', $urls[0]);
        $this->assertStringContainsString('verses',              $urls[0]);
        $this->assertStringContainsString('GEN.1.',              $urls[0]);

        foreach (['Genesis 1', 'Matthew 1', 'Ezra 1', 'Acts 1'] as $expected) {
            $this->assertContains($expected, $absPassages,
                "ABS passage label '$expected' not found");
        }
    }

    /**
     * ESV URL builder must produce one URL per reading pointing to api.esv.org
     * with the passage name appended to the query string.
     */
    public function testEsvUrlConstructionForJanuary1(): void
    {
        $this->helper->setSource('ESV');

        $urls = $this->helper->callConstructUrlsArrayEsv($this->jan1Dbp);

        $this->assertCount(4, $urls, 'Expected 4 ESV URLs for January 1st');

        $this->assertStringContainsString('api.esv.org', $urls[0]);
        $this->assertStringContainsString('Genesis',     $urls[0]);
        $this->assertStringContainsString('api.esv.org', $urls[1]);
        $this->assertStringContainsString('Matthew',     $urls[1]);
    }

    // =========================================================================
    // DBP remote-get tests — requires BRP_DBP_KEY
    // =========================================================================

    /**
     * Fetches Genesis 1 from the Bible Brain (DBP) API using the ENGNAS (NAS)
     * Bible and verifies the JSON structure contains verse text.
     */
    public function testDbpRemoteGetReturnsGenesis1(): void
    {
        $key = (string) getenv('BRP_DBP_KEY');
        if (!$key) {
            $this->markTestSkipped('BRP_DBP_KEY environment variable is not set.');
        }

        $helper = new BibleReadingPlansTestHelper('', $key, '');
        $helper->setSource('DBP');
        $helper->setBibleId('ENGNAS');

        // Use Genesis 1 only to keep the test fast.
        $genesis1 = [$this->jan1Dbp[0]];
        $urls     = $helper->callConstructUrlsArrayDbp($genesis1);
        $result   = $helper->callRemoteGetScripturesDbp($urls);

        $this->assertIsArray($result,
            'remote_get_scriptures_dbp must return an array');
        $this->assertArrayHasKey('Genesis 1', $result,
            '"Genesis 1" key missing from DBP result');

        $textBodies = $result['Genesis 1']['text'] ?? [];
        $this->assertNotEmpty($textBodies,
            'No text body received for Genesis 1 from DBP — check that BRP_DBP_KEY is valid');

        $decoded = json_decode($textBodies[0], true);
        $this->assertNotNull($decoded,
            'DBP response is not valid JSON: ' . substr($textBodies[0], 0, 300));
        $this->assertArrayHasKey('data', $decoded,
            '"data" key missing from DBP JSON response');
        $this->assertNotEmpty($decoded['data'],
            'DBP "data" array is empty — no verses returned');

        $firstVerse = $decoded['data'][0];
        $this->assertArrayHasKey('verse_text', $firstVerse,
            '"verse_text" missing from first DBP verse object');
        $this->assertNotEmpty($firstVerse['verse_text'],
            'DBP verse_text is empty');
    }

    /**
     * Fetches all four January 1st M'Cheyne passages from the DBP API.
     */
    public function testDbpRemoteGetReturnsAllJanuary1Readings(): void
    {
        $key = (string) getenv('BRP_DBP_KEY');
        if (!$key) {
            $this->markTestSkipped('BRP_DBP_KEY environment variable is not set.');
        }

        $helper = new BibleReadingPlansTestHelper('', $key, '');
        $helper->setSource('DBP');
        $helper->setBibleId('ENGNAS');

        $urls   = $helper->callConstructUrlsArrayDbp($this->jan1Dbp);
        $result = $helper->callRemoteGetScripturesDbp($urls);

        $this->assertIsArray($result);

        foreach (['Genesis 1', 'Matthew 1', 'Ezra 1', 'Acts 1'] as $passage) {
            $this->assertArrayHasKey($passage, $result,
                "Passage '$passage' missing from DBP result");

            $bodies = $result[$passage]['text'] ?? [];
            $this->assertNotEmpty($bodies,
                "No text body for '$passage' from DBP");

            $decoded = json_decode($bodies[0], true);
            $this->assertIsArray($decoded,
                "Non-JSON body for '$passage': " . substr($bodies[0], 0, 200));
            $this->assertArrayHasKey('data', $decoded,
                "'data' key missing for '$passage'");
            $this->assertNotEmpty($decoded['data'],
                "'data' is empty for '$passage'");
        }
    }

    // =========================================================================
    // ABS remote-get tests — requires BRP_ABS_KEY
    // =========================================================================

    /**
     * Fetches Genesis 1 from the API.Bible (ABS) endpoint using the ASV and
     * verifies the JSON structure contains verse content.
     */
    public function testAbsRemoteGetReturnsGenesis1(): void
    {
        $key = (string) getenv('BRP_ABS_KEY');
        if (!$key) {
            $this->markTestSkipped('BRP_ABS_KEY environment variable is not set.');
        }

        $helper = new BibleReadingPlansTestHelper($key, '', '');
        $helper->setSource('ABS');
        $helper->setVersion('ASV');

        $genesis1    = [$this->jan1Abs[0]];
        $absPassages = [];
        $urls        = $helper->callConstructUrlsArrayAbs($genesis1, $absPassages);
        $result      = $helper->callRemoteGetScriptures($urls);

        $this->assertIsArray($result,
            'remote_get_scriptures must return an array for ABS');
        $this->assertNotEmpty($result,
            'ABS result is empty — check that BRP_ABS_KEY is valid');

        $body = $result[0][0] ?? '';
        $this->assertNotEmpty($body, 'ABS response body is empty');

        $decoded = json_decode($body);
        $this->assertNotNull($decoded,
            'ABS response is not valid JSON: ' . substr($body, 0, 300));
        $this->assertTrue(isset($decoded->data),
            'ABS JSON missing "data" field');
        $this->assertTrue(isset($decoded->data->content),
            'ABS JSON missing "data.content" field');
        $this->assertNotEmpty($decoded->data->content,
            'ABS "data.content" is empty');
    }

    /**
     * Fetches all four January 1st M'Cheyne passages from the ABS API.
     */
    public function testAbsRemoteGetReturnsAllJanuary1Readings(): void
    {
        $key = (string) getenv('BRP_ABS_KEY');
        if (!$key) {
            $this->markTestSkipped('BRP_ABS_KEY environment variable is not set.');
        }

        $helper = new BibleReadingPlansTestHelper($key, '', '');
        $helper->setSource('ABS');
        $helper->setVersion('ASV');

        $absPassages = [];
        $urls        = $helper->callConstructUrlsArrayAbs($this->jan1Abs, $absPassages);
        $result      = $helper->callRemoteGetScriptures($urls);

        $this->assertIsArray($result);
        $this->assertCount(4, $result,
            'Expected 4 passage results for January 1st from ABS');

        foreach ($result as $idx => $bodies) {
            $body    = $bodies[0] ?? '';
            $decoded = json_decode($body);
            $this->assertNotNull($decoded,
                "ABS result[$idx] is not JSON: " . substr($body, 0, 200));
            $this->assertTrue(isset($decoded->data),
                "ABS result[$idx] missing 'data' field");
        }
    }

    // =========================================================================
    // ESV remote-get tests — requires BRP_ESV_KEY
    // =========================================================================

    /**
     * Fetches Genesis 1 from the ESV Bible Web Service and verifies the JSON
     * structure contains a non-empty passages array.
     */
    public function testEsvRemoteGetReturnsGenesis1(): void
    {
        $key = (string) getenv('BRP_ESV_KEY');
        if (!$key) {
            $this->markTestSkipped('BRP_ESV_KEY environment variable is not set.');
        }

        $helper = new BibleReadingPlansTestHelper('', '', $key);
        $helper->setSource('ESV');

        $genesis1 = [$this->jan1Dbp[0]];
        $urls     = $helper->callConstructUrlsArrayEsv($genesis1);
        $result   = $helper->callRemoteGetScriptures($urls);

        $this->assertIsArray($result,
            'remote_get_scriptures must return an array for ESV');
        $this->assertNotEmpty($result,
            'ESV result is empty — check that BRP_ESV_KEY is valid');

        $body = $result[0][0] ?? '';
        $this->assertNotEmpty($body, 'ESV response body is empty');

        $decoded = json_decode($body);
        $this->assertNotNull($decoded,
            'ESV response is not valid JSON: ' . substr($body, 0, 300));
        $this->assertTrue(isset($decoded->passages),
            'ESV JSON missing "passages" field');
        $this->assertNotEmpty((array) $decoded->passages,
            'ESV "passages" array is empty');
    }

    /**
     * Fetches all four January 1st M'Cheyne passages from the ESV API.
     */
    public function testEsvRemoteGetReturnsAllJanuary1Readings(): void
    {
        $key = (string) getenv('BRP_ESV_KEY');
        if (!$key) {
            $this->markTestSkipped('BRP_ESV_KEY environment variable is not set.');
        }

        $helper = new BibleReadingPlansTestHelper('', '', $key);
        $helper->setSource('ESV');

        $urls   = $helper->callConstructUrlsArrayEsv($this->jan1Dbp);
        $result = $helper->callRemoteGetScriptures($urls);

        $this->assertIsArray($result);
        $this->assertCount(4, $result,
            'Expected 4 ESV passage results for January 1st');

        foreach ($result as $idx => $bodies) {
            $body    = $bodies[0] ?? '';
            $decoded = json_decode($body);
            $this->assertNotNull($decoded,
                "ESV result[$idx] is not JSON: " . substr($body, 0, 200));
            $this->assertTrue(isset($decoded->passages),
                "ESV result[$idx] missing 'passages' field");
        }
    }
}
