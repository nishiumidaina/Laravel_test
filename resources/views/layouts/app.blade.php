<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SimpleNote') }}</title>

    <!-- Scripts -->
    <script src="{{ '/js/app.js' }}" defer></script>
    @yield('js')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ '/css/app.css' }}" rel="stylesheet">
    <link href="{{ '/css/utility.css' }}" rel="stylesheet">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
   integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
   crossorigin=""/>
 <!-- Make sure you put this AFTER Leaflet's CSS -->

    @yield('css')
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
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

        <main class="main">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
              {{ session('success') }}
            </div>
        @endif
          <div class="row" style='height: 92vh;'>
            <div class="col-md-6 p-0">
              <div class="card h-100">
              <div class="card-body py-2 px-4">
                <a class='d-block' href='/'>全て表示</a>
                <!-- GISの表示 -->
                <link rel='stylesheet' href='https://unpkg.com/leaflet@1.3.0/dist/leaflet.css' />
                <script src='https://unpkg.com/leaflet@1.3.0/dist/leaflet.js'></script>
                <div id='mapcontainer' style='width:100%; height:300px; z-index:0;'></div>
                {{ $a=1 }}
                {{ $a }}
                
                <!--<script type="text/javascript" src="{{ asset('/js/gis.js') }}"></script>-->
                <script>//ピンの表示
                    const data = @json($spots);
                    console.log(data[0]);
                    function init_map() {

                    var map = L.map('mapcontainer');
                    map.setView([35.7102, 139.8132], 10); //初期の中心位置とズームレベルを設定
                    //マーカーを表示
                    for (let i=0; i<data.length; i++){
                        var name = data[i].name                    
                        var long = data[i].longitude                    
                        var lat = data[i].latitude
                        var newline = "<br>"
                        var ex = data[i].ex
                        var url = data[i].url
                        var marker = L.marker([long,lat]).addTo(map);
                        marker.bindPopup( name + newline + ex + newline + url).openPopup();
                    }
                    //マップタイル読み込み
                    L.tileLayer('http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', 
                        {attribution: "<a href='http://osm.org/copyright'> ©OpenStreetMap </a>"}).addTo(map);
                    }
                    //ダウンロード時に初期化する
                    window.addEventListener('DOMContentLoaded', init_map());

                </script>
                </div>
              </div>
                </div>
            <div class="col-md-2 p-0">
              <div class="card h-100">
                <div class="card-header d-flex">登録地点一覧 <a class='ml-auto' href='/create'><i class="fas fa-plus-circle"></i></a></div>
                <div class="card-body p-2">
                @foreach($spots as $spot)
                  <a href="/edit/{{ $spot['id'] }}" class='d-block'>{{ $spot['name'] }}</a>
                @endforeach
                </div>
              </div>    
            </div> <!-- col-md-3 -->
            <div class="col-md-4 p-0">
              @yield('content')
            </div>
          </div> <!-- row justify-content-center -->
        </main>
    </div>
    @yield('footer')
</body>
</html>