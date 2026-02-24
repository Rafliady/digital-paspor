<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Imigrasi</title>
    <link rel="icon" type="image/png" href="{{ asset('img/logo_imigrasi.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: linear-gradient(135deg, #0c2e8a 0%, #001f52 100%);
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Poppins', sans-serif;
        }
        .card-login {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body>

<div class="card-login text-center">
    <img src="{{ asset('img/logo_imigrasi.png') }}" alt="Logo" style="height: 60px; margin-bottom: 20px;">
    <h4 class="fw-bold text-dark mb-4">Login Admin</h4>

    @if ($errors->any())
        <div class="alert alert-danger small">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf
        <div class="mb-3 text-start">
            <label class="form-label small fw-bold">Email</label>
            <input type="email" name="email" class="form-control" placeholder="admin@imigrasi.go.id" required>
        </div>
        <div class="mb-4 text-start">
            <label class="form-label small fw-bold">Password</label>
            <input type="password" name="password" class="form-control" placeholder="******" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">MASUK</button>
    </form>
    
    <div class="mt-3">
        <a href="{{ url('/') }}" class="text-decoration-none small text-muted">← Kembali ke Form Paspor</a>
    </div>
</div>

</body>
</html>