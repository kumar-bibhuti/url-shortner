<?php

namespace App\Http\Controllers;

use App\Models\URL;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class URLController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->check()) {
            return view('welcome');
        }
        $user = auth()->user();
        if($user->role === 'super_admin') {
            $urls = URL::all();
        } elseif($user->role === 'admin') {
            $urls = URL::where('company_id', $user->company_id)->get();
        } else {
            $urls = URL::where('user_id', $user->id)->get();
        }
        return view('urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urls.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(auth()->user()->isSuperAdmin()) {
            abort(403, 'Super Admin cannot create URLs.');
        }
        $request->validate([
            'original_url' => 'required|url',
            'short_code' => 'nullable|string|unique:urls,short_code',
        ]);

        $shortCode = $request->short_code ?: Str::random(6);
        URL::create([
            'original_url' => $request->original_url,
            'short_code' => $shortCode,
            'user_id' => $request->user()->id,
            'company_id' => $request->user()->company_id,
        ]);

            return redirect()->route('url.index')->with('success', 'URL shortened successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(URL $uRL)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(URL $uRL)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, URL $uRL)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(URL $uRL)
    {
        //
    }

    public function redirect($shortCode)
    {
        $url = URL::where('short_code', $shortCode)->firstOrFail();
        return redirect($url->original_url);
    }
}
