<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title','HestaMail')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script
    src="https://code.jquery.com/jquery-3.5.1.js"
    integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
    crossorigin="anonymous"></script>
    
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
    

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Icons -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/myStyles.css')}}">

    <script>
        tinymce.init({
          selector: 'textarea#message',
          skin: 'bootstrap',
          plugins: 'lists, link, image, media',
          toolbar: 'h1 h2 bold italic strikethrough blockquote bullist numlist backcolor | link image media | removeformat help',
          menubar: false
        });
      </script>
    @yield('styles')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'HestaMail') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    
                                    

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @if (! empty(Auth::user()->email_verified_at))
            <div class="sidebar">
                <div class="text-center">
                    
                    <img src="{{Auth::user()->profile_image}}" style="width: 100px; height:100px" alt="Profile Picture">
                    <h5>{{Auth::user()->email}}</h5>
                    
                </div>
                <div class="items-container">
                    <a href="#ComposeEmailModal" data-toggle="modal" data-target="#ComposeEmailModal"><h6 class="menu-item compose"><i class="fa fa-plus-square" aria-hidden="true"></i>Compose</h6></a>
                    <a href="{{route('home')}}"><h6 class="menu-item"><i class="fa fa-envelope" aria-hidden="true" ></i>Inbox</h6></a>
                    <a href="{{route('fetchSentEmails')}}"><h6 class="menu-item"><i class="fa fa-paper-plane" aria-hidden="true"></i>Sent</h6></a>
                    <a href="{{route('fetchDraftEmails')}}"><h6 class="menu-item"><i class="fa fa-file" aria-hidden="true" ></i>Draft</h6></a>
                    <a href="{{route('fetchImportantEmails')}}"><h6 class="menu-item"><i class="fa fa-star" aria-hidden="true" style="color: rgb(252, 209, 19);"></i>Important</h6></a>
                    <a href="{{route('fetchDeletedEmails')}}"><h6 class="menu-item trash"><i class="fa fa-trash" aria-hidden="true" style="color:rgb(255, 0, 0);"></i>Trash</h6></a>
                </div>
            </div>
            @endif
                <div class="content">
                    @yield('content')
                </div>  
                @if (Auth::check())
                    @include('layouts.ComposeModal')
                @endif 
        </main>
    </div>
    <script>
        $(document).ready(function(){
          $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
    @yield('scripts')
</body>
</html>
