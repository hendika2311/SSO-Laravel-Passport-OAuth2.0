<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get("/login", function(Request $request){
    $request->session()->put("state",  $state = Str::random(40));
    $query = http_build_query([
        "client_id" => "9df5a67a-641f-4cb0-b171-03dab5b09c94",
        "redirect_uri" => "http://127.0.0.1:8080/callback",
        "response_type" => "code",
        "scope" => "view-user",
        "state" => $state
    ]);
    return redirect("http://127.0.0.1:8000/oauth/authorize?" . $query);
});


Route::get("/callback", function(Request $request){
    $state = $request->session()->pull("state");

    throw_unless(strlen($state) > 0 && $state == $request->state,
        InvalidArgumentException::class);


        $response = Http::asForm()->post(
            "http://127.0.0.1:8000/oauth/token",
            [
            "grant_type" => "authorization_code",
            "client_id" => "9df5a67a-641f-4cb0-b171-03dab5b09c94",
            "client_secret" => "rMT0lL7DX7qDaJG833XplBWSigVUGJbKb8JkpydB",
            "redirect_uri" => "http://127.0.0.1:8080/callback",
            "code" => $request->code
        ]); 
        $request->session()->put($response->json());
        return redirect("/authuser");
    }); 
Route::get("/authuser", function(Request $request){
    $access_token = $request->session()->get("access_token");

    // Ambil data user dari server SSO
    $response = Http::withHeaders([
        "Accept" => "application/json",
        "Authorization" => "Bearer " . $access_token
    ])->get("http://127.0.0.1:8000/api/user");

    $user = $response->json();

    // Arahkan ke halaman utama (bukan dashboard)
    return view('home', compact('user'));
});
Route::get('/logout', function (Request $request) {
    // Hapus semua data session termasuk token
    $request->session()->flush();

    // (Opsional) Redirect ke halaman welcome atau login
    return redirect('/');
});
Route::get('/activity', function (Request $request) {
    $access_token = $request->session()->get('access_token');

    // Ambil data user (biar bisa tampil nama)
    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $access_token,
    ])->get('http://127.0.0.1:8000/api/user');

    $user = $response->json();

    // Data aktivitas dummy
    $activities = [
        ['tanggal' => '2025-10-27 08:23', 'aktivitas' => 'Login ke aplikasi client'],
        ['tanggal' => '2025-10-27 08:25', 'aktivitas' => 'Melihat halaman profil'],
        ['tanggal' => '2025-10-27 08:27', 'aktivitas' => 'Logout dari aplikasi'],
    ];

    return view('activity', compact('user', 'activities'));
    
});
Route::get('/home', function (Request $request) {
    $access_token = $request->session()->get('access_token');

    $response = Http::withHeaders([
        'Accept' => 'application/json',
        'Authorization' => 'Bearer ' . $access_token,
    ])->get('http://127.0.0.1:8000/api/user');

    $user = $response->json();

    return view('home', compact('user'));
});
