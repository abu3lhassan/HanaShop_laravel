<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping</title>
    
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Nunito', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar, footer {
            background-color: #333;
            color: white;
        }
        .navbar-brand, .nav-link {
            color: #fff !important;
        }
        .card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-primary {
            background-color: #333;
            border: none;
            color: white;
            border-radius: 30px;
            padding: 10px 20px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route('index') }}">Ali Hussain Al-Hanabi - Shopping</a>
            <div class="collapse navbar-collapse" id="navbarContent">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('index') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('electric') }}">Electronics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('zena') }}">Decor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('kitchenTools') }}">Kitchen Tools</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="text-center py-4">
        <p>Ali Hussain Al-Hanabi - Connect with me on social media.</p>
    </footer>
</body>
</html>
