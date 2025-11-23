<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Ribetina - Retail System</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * { font-family: "Poppins", sans-serif; }
        body { background: #f4f6f9; }

        nav.navbar {
            background: #03AC0E;
            box-shadow: 0 4px 18px rgba(0,0,0,0.15);
            padding: 14px 0;
        }

        .navbar-brand {
            color: #fff !important;
            font-weight: 700;
            font-size: 1.5rem;
            letter-spacing: .5px;
        }

        .card {
            border-radius: 16px;
            border: none;
            background: #fff;
            box-shadow: 0 6px 20px rgba(0,0,0,0.07);
        }

        h2, h3, h4 {
            font-weight: 700;
            color: #222;
        }

        .btn-main {
            background: #03AC0E;
            color: white;
            font-weight: 600;
        }
        .btn-main:hover {
            background: #01900B;
            transition: .25s;
        }

        .table thead {
            background: linear-gradient(90deg,#03AC0E,#01900B);
            color:#fff;
            font-weight: 600;
        }

        .table tbody tr:hover { background:#e9ffe7; transition:0.3s; }

        .form-control {
            border-radius: 10px;
            padding: 12px;
            border: 1px solid #cfd2d4;
        }

        .form-control:focus {
            border-color:#03AC0E;
            box-shadow:0 0 0 3px rgba(3,172,14,0.2);
        }
    </style>
</head>
<body>

<nav class="navbar">
    <div class="container">
        <a href="/barang" class="navbar-brand">Toko Ribetina Retail System</a>
    </div>
</nav>

<div class="container mt-4 mb-5">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@yield('scripts')

</body>
</html>
