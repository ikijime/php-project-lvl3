<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use DiDom\Document;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class UrlCheckController extends Controller
{
    public function index(): void
    {
    }

    public function store(int $id): RedirectResponse
    {
        $urlRecord = DB::table('urls')->where('id', $id)->first();

        if (!isset($urlRecord->name)) {
            flash('Something went wrong')->error();
            return redirect("/urls/" . $id);
        }

        try {
            $response = Http::timeout(3)->get($urlRecord->name);
        } catch (\Exception $e) {
            $errorMsg = $e->getMessage();
            flash($errorMsg)->error();
            return redirect("/urls/" . $id);
        }

        $status = $response->status();

        $document = new Document($response->body());

        $keywords =  $document->has('meta[name=keywords]') ?
                     $document->find('meta[name=keywords]')[0]->getAttribute('content') : "not found";

        $description = $document->has('meta[name=description]') ?
                        $document->find('meta[name=description]')[0]->getAttribute('content') : "not found";

        $h1Tag = $document->has('h1') ? $document->find('h1')[0]->text() : "not found";

        DB::table('url_checks')->insert([
            'url_id' => $id,
            'status_code' => $status,
            'h1' => $h1Tag,
            'keywords' => $keywords,
            'description' => $description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('urls')->where('id', $id)->update(['updated_at' => Carbon::now()]);

        return redirect()->back();
    }
}
