<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Utama - SSO Laravel</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="{{ asset('js/script.js') }}"></script></body>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body class="bg-light">

    <x-navbar /> 

    <div class="container mt-5">
        <div class="card shadow-lg p-5">
            <h2 class="mb-3 text-center text-primary">Selamat Datang, {{ $user['name'] ?? 'Pengguna' }} 🎉</h2>
            <p class="text-center text-muted">Email: <strong>{{ $user['email'] ?? 'Tidak diketahui' }}</strong></p>
            <hr class="my-4">

            <div class="text-center">
                <p class="lead">Anda berhasil login menggunakan **Single Sign-On (SSO)** berbasis Laravel Passport.</p>
                <p class="text-muted">Ini adalah halaman beranda Anda, siap untuk menampilkan data akun!</p>
                
                <div class="d-grid gap-2 col-md-6 mx-auto mt-4">
                    <a href="/activity" class="btn btn-primary btn-lg">Lihat Aktivitas Akun</a>
                    <a href="/logout" class="btn btn-outline-danger">Logout</a>
                </div>
            </div>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="{{ asset('js/script.js') }}"></script>
<x-footer></x-footer>
</body>
</html>