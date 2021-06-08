<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckController extends Controller
{
    public function index()
    {
        
    }

    public function check(Request $request)
    {
        DB::table('url_checks')->insert([
            'url_id' => $request->urlid,
            'status_code' => 200,
            'h1' => 'Header One11',
            'keywords' => 'Some keywords',
            'description' => 'Some description',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->back();
    }
}
