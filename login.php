<?php
require 'function.php';
if (!isset($_SESSION['login'])) {
    // Menangani jika session login tidak ada
} else {
    header('location:index.php');
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        body {
            background: linear-gradient(135deg, #5f2c82, #49a09d);
            font-family: 'Arial', sans-serif;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .card {
            width: 100%;
            max-width: 400px; /* Membatasi lebar card agar tidak terlalu lebar */
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #ddd;
            padding: 1rem;
        }

        .card-header h3 {
            color: #333;
            font-size: 24px;
        }

        .card-body {
            background-color: #fff;
            padding: 2rem;
        }

        .form-floating {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-control {
            border-radius: 8px;
            padding: 1rem;
            font-size: 16px;
            box-shadow: none;
            transition: border-color 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #49a09d;
            box-shadow: 0 0 5px rgba(73, 160, 157, 0.5);
        }

        /* Label styling ketika fokus */
        .form-floating > label {
            position: absolute;
            top: 0;
            left: 0;
            padding: 1rem;
            font-size: 16px;
            transition: all 0.2s ease-out;
            pointer-events: none; /* Agar label tidak mengganggu input */
        }

        .form-floating > .form-control:focus ~ label,
        .form-floating > .form-control:not(:placeholder-shown) ~ label {
            top: -10px; /* Posisi label lebih tinggi saat input fokus */
            left: 10px;
            font-size: 12px; /* Ukuran font label lebih kecil saat fokus */
            color: #49a09d;
        }

        .btn-primary {
            background-color: #49a09d;
            border: none;
            border-radius: 8px;
            padding: 1rem;
            font-size: 16px;
            text-transform: uppercase;
            transition: background-color 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #5f2c82;
        }

    </style>
</head>

<body>
    <div class="card shadow-lg border-0 rounded-lg mt-5">
        <div class="card-header">
            <h3 class="text-center font-weight-light my-4">Login</h3>
        </div>
        <div class="card-body">
            <!-- Form Login -->
            <form method="post">
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputUsername" name="username" type="text" placeholder="Username" required />
                    <label for="inputUsername">Username</label>
                </div>
                <div class="form-floating mb-3">
                    <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" required />
                    <label for="inputPassword">Password</label>
                </div>
                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                    <button type="submit" name="login" class="btn btn-primary w-100">Login</button>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>
