<?php

namespace Tests\Feature\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckControllerTest extends TestCase
{
    protected array $url;

    protected function setUp(): void
    {
        parent::setUp();
        $this->url['name'] = 'http://example.com';
        DB::table('urls')->insert($this->url);
        $this->url['id'] = DB::table('urls')->where('name', $this->url['name'])->value('id');
    }

    public function testChecksStoreAndShow(): void
    {
        $html = '<html>
                    <head>
                        <meta name="keywords" content="Test Keywords">
                        <meta name="description" content="Test Description">
                        <title>TEST TITLE</title>
                    </head>
                    <body><h1>TEST H1</h1></body>
                </html>';

        Http::fake([
            $this->url['name'] => Http::response($html, 200)
        ]);

        $expected = [
            'url_id' => $this->url['id'],
            'status_code' => 200,
            'h1' => 'TEST H1',
        ];

        $response = $this->post("/urls/1/checks", ['urlid' => 1]);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('url_checks', $expected);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
