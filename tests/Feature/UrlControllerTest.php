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

    public function testUrlsPageLoading()
    {
        $response = $this->get(route('urls.index'));
        $response->assertStatus(200);
    }

    /**
    * @dataProvider urlProvider
    */
    public function testUrlStoring($url, $expectedUrl):void
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
            'Without schema' => ['www.withoutschema.com', 'http://www.withoutschema.com'],
            'Without path & schema' => ['withoutschema.com', 'http://withoutschema.com'],
        ];
    }
    
    public function testUrlHasRecords()
    {
        $urls = Url::factory()->count(11)->make();
        foreach ($urls as $url) {
            $response = $this->post('/urls', [
                'url' => [
                    'name' => $url->name
                ]
            ]);
        }
        $expects = DB::table('urls')->count();
        $this->assertEquals(11, $expects);
        $response->assertRedirect();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
