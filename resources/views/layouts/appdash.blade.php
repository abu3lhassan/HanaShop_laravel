<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <!-- Fonts -->
    <link href='https://fonts.googleapis.com/css?family=Almarai' rel='stylesheet'>
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

<style>
    *{
        font-family:Almarai
    }
    
</style>
</head>
<body dir="rtl">
    <div id="app">
       
    <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark text-white">
  <div class="container-fluid">
    <div>
    @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif

                           
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
</header>
       
        <main class="">
            <!-- Content --> 
             <div class="row">
             <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark text-white">
            <div class="d-flex flex-column align-items-start align-items-sm-start px-3 pt-2 text-white min-vh-100">
                <a href="/" class=" text-white text-decoration-none">
                <i class="fs-4 bi-speedometer2"></i> <span class="fs-5 d-none d-sm-inline text-center">لوحة التحكم</span>
                </a>
                <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-start align-items-sm-start" id="menu">
                    <li class="nav-item">
                        <a href="#" class="nav-link align-start text-white px-0">
                            <i class="fs-4 bi-house text-white"></i> <span class="ms-1 d-none d-sm-inline">الرئيسية</span>
                        </a>
                    </li>
                   
                    <li>
                        <a href="{{route('products')}}" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-table text-white p-2"></i> <span class="ms-1 d-none d-sm-inline text-white">المنتجات</span></a>
                    </li>
                  
                    <li>
                        <a href="{{route('showdet')}}"  class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-grid text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">تفاصيل المنتجات</span> </a>
                         
                               </li>
                    <li>
                        <a href="#" class="nav-link px-0 align-middle">
                            <i class="fs-4 bi-people text-white"></i> <span class="ms-1 d-none d-sm-inline text-white">العملاء</span> </a>
                    </li>
                </ul>
                <hr>
                <div class="dropdown pb-4">
                    <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://github.com/mdo.png" alt="hugenerd" width="30" height="30" class="rounded-circle">
                        <span class="d-none d-sm-inline mx-1">loser</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark text-small shadow">
                        <li><a class="dropdown-item" href="#">New project...</a></li>
                        <li><a class="dropdown-item" href="#">Settings</a></li>
                        <li><a class="dropdown-item" href="#">Profile</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#">Sign out</a></li>
                    </ul>
                </div>
            </div>
        </div>
                <div class="col-sm-8">
                    @yield('content')
                </div>
             </div>
         
        </main>

        <footer>
             <!-- Footer -->
        </footer>
        
    </div>
    <script src="{{asset('js/main.js')}}"></script>
</body>
</html>
