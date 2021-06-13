<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function index(): mixed
    {
        $urls = DB::table('urls')->paginate(15);

        $lastChecks = DB::table('url_checks')
            ->select('url_id', 'created_at', 'status_code')
            ->whereIn('url_id', $urls->pluck('id'))
            ->orderByDesc('url_id')
            ->orderByDesc('created_at')
            ->distinct('url_id')->get()->toArray();

        $checks = [];

        foreach ($lastChecks as $lastCheck) {
            $checks[$lastCheck->url_id] = $lastCheck;
        }

        return view('urls', ['urls' => $urls, 'checks' => $checks]);
    }

    public function create(): void
    {
        //
    }

    public function store(Request $request): mixed
    {
        if (!isset($request->url)) {
            return null;
        }

        $validator = Validator::make($request->url, [
            'name' => 'required|url'
        ]);

        if ($validator->fails() || !isset($request->url)) {
            flash('Not a valid url')->error()->important();
            return redirect()->back()->withErrors($validator);
        }

        $parsedUrl = parse_url($request->url['name']);

        if (isset($parsedUrl['scheme']) && isset($parsedUrl['host'])) {
             $newUrlName = $parsedUrl['scheme'] . "://" . $parsedUrl['host'];
        } else {
             $newUrlName = 'http://' . $parsedUrl['path'];
        }

        $oldUrl = DB::table('urls')->where('name', $newUrlName)->first();

        if (isset($oldUrl->id) && isset($oldUrl->name)) {
            flash("Домен {$oldUrl->name} уже проверялся.");
            return redirect(route('urls.show', $oldUrl->id));
        }

        DB::table('urls')->insert([
            'name' => $newUrlName,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        flash('Новая запись добавлена');
        return redirect('urls');
    }

    public function show(int $id): mixed
    {
        $url = DB::table('urls')->where('id', $id)->first();
        $urlChecks = DB::table('url_checks')->where('url_id', $id)->get();
        return view('url', ['url' => $url, 'checks' => $urlChecks]);
    }

    public function edit(int $id): void
    {
        //
    }

    public function update(Request $request, int $id): void
    {
        //
    }

    public function destroy(int $id): void
    {
        //
    }
}
