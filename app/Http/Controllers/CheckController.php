<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class CheckController extends Controller
{
    public function index()
    {
    }

    public function store(Request $request)
    {
        $urlRecord = DB::table('urls')->where('id', $request->urlid)->first();

            try {
                $response = Http::timeout(3)->get($urlRecord->name);
                
            } catch ( \Exception $e) {
                $errorMsg = $e->getMessage();
                flash($errorMsg)->error();
                return redirect("/urls/" . $request->urlid);
            }
        
        $url_id = $request->urlid;
        $html = $response->body();
        $status = $response->status();

        DB::table('url_checks')->insert([
            'url_id' => $request->urlid,
            'status_code' => $status,
            // 'h1' => 'Header One11',
            // 'keywords' => 'Some keywords',
            // 'description' => 'Some description',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('urls')->where('id', $request->urlid)->update(['updated_at' => Carbon::now()]);

        return redirect()->back();
    }
}
