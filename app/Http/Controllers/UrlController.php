<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class UrlController extends Controller
{
    public function index(): mixed {
        $urls = DB::table('urls')->paginate(15);
        return view('urls', ['urls' => $urls]);
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): mixed
    {
        $request->validate([
            'url.name' => 'required|max:255',
        ]);

        $newUrl = $request->url;
        $parsedUrl = parse_url($request->url['name']);

        if (isset($parsedUrl['scheme']) && isset($parsedUrl['host']))
        {
             $newUrlName = $parsedUrl['scheme'] . "://" . $parsedUrl['host'];
        } else {
             $newUrlName = 'http://' . $parsedUrl['path'];
        }

        // $valideteUrl = function ($url) {
        //     $path = parse_url($url, PHP_URL_PATH);
        //     $encoded_path = array_map('urlencode', explode('/', $path));
        //     $url = str_replace($path, implode('/', $encoded_path), $url);
        
        //     return filter_var($url, FILTER_VALIDATE_URL) ? true : false;
        // };

        // if ($valideteUrl($request->url['name'])) {
        //     $newUrlName = $request->url['name'];
        // } else {
        //     return redirect()->back()->withErrors(['Url not valid.']);
        // }

        // If url already in database redirect to it
        // Else insert new row and show /urls

        $oldUrl = DB::table('urls')->where('name', $newUrlName)->first();

        if ($oldUrl !== null) {
            flash("Домен {$oldUrl->name} уже проверялся.");
            return redirect('urls/' . $oldUrl->id);
        }

        DB::table('urls')->insert([
            'name' => $newUrlName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        flash('Новая запись добавлена');
        return redirect('urls');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $url = DB::table('urls')->where('id', $id)->first();
        $urlChecks = DB::table('url_checks')->where('url_id', $id)->get();
        return view('url', ['url' => $url, 'checks' => $urlChecks]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
