<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CheckController extends Controller
{
    public function index()
    {
        
    }

    public function check(Request $request)
    {

        $urlRecord = DB::table('urls')->where('id', $request->urlid)->first();
        $response = HTTP::get($urlRecord->name);

        DB::table('url_checks')->insert([
            'url_id' => $request->urlid,
            'status_code' => $response->status(),
            'h1' => 'Header One11',
            'keywords' => 'Some keywords',
            'description' => 'Some description',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('urls')->where('id', $request->urlid)->update(['updated_at' => Carbon::now()]);

        return redirect()->back();
    }
}
