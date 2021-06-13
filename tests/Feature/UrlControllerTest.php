<?php

namespace Tests\Feature;

use App\Models\Url;
use Composer\Util\Http\Response;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UrlControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    public function testUrlsPageLoading(): void
    {
        $response = $this->get(route('urls.index'));
        $response->assertStatus(200);
    }

    public function testEmptyInputError(): void
    {
        $response = $this->post('/urls', [
            'url' => [
                'name' => ''
            ]
        ]);

        $response->assertSessionHasErrors('name');
    }
    /**
     * @dataProvider urlProvider
     */
    public function testUrlStoring(string $urlName, string $expectedUrl): void
    {
        $response = $this->post('/urls', [
            'url' => [
                'name' => $urlName
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $url = DB::table('urls')->first();

        if (isset($url->name)) {
            $this::assertEquals($expectedUrl, $url->name);
        }
    }

    public function urlProvider(): mixed
    {
        return [
            'Full link' => ['https://www.fullurl.com/12', 'https://www.fullurl.com'],
            'Without path' => ['https://www.full.com', 'https://www.full.com'],
        ];
    }

    public function testUrlHasRecords(): void
    {
        $urls = Url::factory()->count(10)->make();

        foreach ($urls as $url) {
            $res = $this->post('/urls', [
                'url' => [
                    'name' => $url->name
                ]
            ]);
        }
        $expects = DB::table('urls')->count();
        $this::assertEquals(10, $expects);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
