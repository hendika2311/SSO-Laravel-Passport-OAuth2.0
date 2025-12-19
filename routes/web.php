<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

/**
 * LOGIN → redirect ke SSO Server
 */
Route::get('/login', function (Request $request) {
    $request->session()->put('state', $state = Str::random(40));

    $query = http_build_query([
        'client_id'     => config('services.sso.client_id'),
        'redirect_uri'  => config('services.sso.redirect_uri'),
        'response_type' => 'code',
        'scope'         => 'view-user',
        'state'         => $state,
    ]);

    return redirect(
        config('services.sso.server_url') . '/oauth/authorize?' . $query
    );
});

/**
 * CALLBACK dari SSO Server
 */
Route::get('/callback', function (Request $request) {
    $state = $request->session()->pull('state');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class
    );

    $response = Http::asForm()->post(
        config('services.sso.server_url') . '/oauth/token',
        [
            'grant_type'    => 'authorization_code',
            'client_id'     => config('services.sso.client_id'),
            'client_secret'=> config('services.sso.client_secret'),
            'redirect_uri' => config('services.sso.redirect_uri'),
            'code'          => $request->code,
        ]
    );

    $request->session()->put($response->json());

    return redirect('/authuser');
});

/**
 * Ambil user dari SSO Server
 */
Route::get('/authuser', function (Request $request) {
    $access_token = $request->session()->get('access_token');

    $response = Http::withToken($access_token)
        ->acceptJson()
        ->get(config('services.sso.server_url') . '/api/user');

    $user = $response->json();

    return view('home', compact('user'));
});

/**
 * Logout
 */
Route::get('/logout', function (Request $request) {
    $request->session()->flush();
    return redirect('/');
});

/**
 * Activity page
 */
Route::get('/activity', function (Request $request) {
    $access_token = $request->session()->get('access_token');

    $response = Http::withToken($access_token)
        ->acceptJson()
        ->get(config('services.sso.server_url') . '/api/user');

    $user = $response->json();

    $activities = [
        ['tanggal' => '2025-10-27 08:23', 'aktivitas' => 'Login ke aplikasi client'],
        ['tanggal' => '2025-10-27 08:25', 'aktivitas' => 'Melihat halaman profil'],
        ['tanggal' => '2025-10-27 08:27', 'aktivitas' => 'Logout dari aplikasi'],
    ];

    return view('activity', compact('user', 'activities'));
});

/**
 * Home
 */
Route::get('/home', function (Request $request) {
    $access_token = $request->session()->get('access_token');

    $response = Http::withToken($access_token)
        ->acceptJson()
        ->get(config('services.sso.server_url') . '/api/user');

    $user = $response->json();

    return view('home', compact('user'));
});
