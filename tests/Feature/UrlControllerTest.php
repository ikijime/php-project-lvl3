<?php

namespace Tests\Feature;


use App\Models\Url;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

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

    public function testEmptyInputError():void
    {
        $response = $this->post('/urls', [
            'url' => [
                'name' => ''
            ]
        ]);

        $response->assertSessionHasErrors();
    }
    /**
     * @dataProvider urlProvider
     */
    public function testUrlStoring(string $url, string $expectedUrl): void
    {
        $response = $this->post('/urls', [
            'url' => [
                'name' => $url
            ]
        ]);

        $response->assertSessionHasNoErrors();

        $url = DB::table('urls')->first();

        $this->assertEquals($expectedUrl, $url->name);
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
            $response = $this->post('/urls', [
                'url' => [
                    'name' => $url->name
                ]
            ]);
        }
        $expects = DB::table('urls')->count();
        $this->assertEquals(10, $expects);
        $response->assertRedirect();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
