<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Form Login</title>
        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- FontAwesome CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    </head>

    <body>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header text-center">
                            <h4><i class="fas fa-user-plus"></i> Form Login</h4>
                        </div>
                        <div class="card-body">
                            <!-- Menampilkan pesan error -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('auth.login') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label"><i class="fas fa-envelope"></i>
                                        Email</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Masukkan email Anda" value="{{ old('email') }}" required>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label"><i class="fas fa-lock"></i>
                                        Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Masukkan password" required>
                                </div>

                                <button type="submit" class="btn btn-primary w-100"><i class="fas fa-user-check"></i>
                                    login</button>
                                <p>belum punya akun? <a href="{{ route('auth.registrasi.form') }}">registrasi</a></p>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap 5 JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>
