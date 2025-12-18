<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aktivitas User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2 class="text-center mb-4">Aktivitas {{ $user['name'] ?? 'User' }}</h2>

        <table class="table table-bordered table-striped">
            <thead class="table-primary">
                <tr>
                    <th>Tanggal</th>
                    <th>Aktivitas</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activities as $act)
                    <tr>
                        <td>{{ $act['tanggal'] }}</td>
                        <td>{{ $act['aktivitas'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-center mt-4">
            <a href="/home" class="btn btn-secondary">Kembali ke Halaman Utama</a>
            <a href="/logout" class="btn btn-outline-danger">Logout</a>
        </div>
    </div>
</div>

</body>
</html>
