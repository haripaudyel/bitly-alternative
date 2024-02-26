<?php

namespace App\Http\Controllers;

use App\Models\ShortenedUrl;
use Illuminate\Http\Request;

class UrlShortenerController extends Controller
{
    public function index()
    {
        return view('shorten');
    }

    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $originalUrl = $request->input('url');
        $shortCode = $this->generateShortCode();

        ShortenedUrl::create([
            'original_url' => $originalUrl,
            'short_code' => $shortCode,
        ]);

        return redirect('/')->with('success', 'URL shortened successfully.');
    }

    public function redirect($code)
    {
        $shortenedUrl = ShortenedUrl::where('short_code', $code)->firstOrFail();
        return redirect($shortenedUrl->original_url);
    }

    protected function generateShortCode()
    {
        // Generate a unique short code based on your logic
        // For simplicity, you can use base_convert, md5, etc.
        return substr(md5(uniqid()), 0, 6);
    }
}
