<?php

namespace Tests\Feature\Feature;

use App\Models\Url;
use Tests\TestCase;
use App\Models\Check;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Url::factory()->count(2)->make();
    }

    public function testChecksStoreAndShow()
    {
        Check::factory()->count(6)->create([
            'url_id' => 2,
        ]);

        $checks = DB::table('url_checks')->count();
        $this->assertEquals(6, $checks);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
