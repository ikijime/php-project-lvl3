<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Document;
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
        $status = $response->status();

        $document = new Document($response->body());

        $keywords =  $document->has('meta[name=keywords]') ?
                     $document->find('meta[name=keywords]')[0]->getAttribute('content') : "not found";

        $description = $document->has('meta[name=description]') ?
                        $document->find('meta[name=description]')[0]->getAttribute('content') : "not found";
                        
        $h1Tag = $document->has('h1') ? $document->find('h1')[0]->text() : "not found";

        DB::table('url_checks')->insert([
            'url_id' => $request->urlid,
            'status_code' => $status,
            'h1' => $h1Tag,
            'keywords' => $keywords,
            'description' => $description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('urls')->where('id', $request->urlid)->update(['updated_at' => Carbon::now()]);

        return redirect()->back();
    }
}
