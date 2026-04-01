<!doctype html>
<html lang="en" dir="">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{Session::get('nama_aplikasi')}}</title>
    @include('layouts.css')
    @stack('css')
    <style type="text/css">
        /* Dropdown submenu scrollable agar tidak melebihi layar */
        .iq-submenu {
            max-height: 70vh;
            overflow-y: auto;
        }
        .iq-submenu::-webkit-scrollbar {
            width: 5px;
        }
        .iq-submenu::-webkit-scrollbar-track {
            background: transparent;
        }
        .iq-submenu::-webkit-scrollbar-thumb {
            background: rgba(0,0,0,0.15);
            border-radius: 10px;
        }
        .iq-submenu::-webkit-scrollbar-thumb:hover {
            background: rgba(0,0,0,0.25);
        }

        .pagination {
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.42rem;
            float: right !important;
        }

        .iq-navbar-logo img {
            height: 80px;
        }

        #container_spinner {
            width: 100%;
            height: auto;
            text-align: center;
            position: absolute;
            top: 50%;
        }

        /* css loading spinner */
        .lds-spinner {
            color: official;
            display: inline-block;
            position: relative;
            margin: auto 0;
            width: 80px;
            height: 80px;
        }

        .lds-spinner div {
            transform-origin: 40px 40px;
            animation: lds-spinner 1.2s linear infinite;
        }

        .lds-spinner div:after {
            content: " ";
            display: block;
            position: absolute;
            top: 3px;
            left: 37px;
            width: 6px;
            height: 18px;
            border-radius: 20%;
            /* background: red; */
            background: #8c99e0;
        }

        .lds-spinner div:nth-child(1) {
            transform: rotate(0deg);
            animation-delay: -1.1s;
        }

        .lds-spinner div:nth-child(2) {
            transform: rotate(30deg);
            animation-delay: -1s;
        }

        .lds-spinner div:nth-child(3) {
            transform: rotate(60deg);
            animation-delay: -0.9s;
        }

        .lds-spinner div:nth-child(4) {
            transform: rotate(90deg);
            animation-delay: -0.8s;
        }

        .lds-spinner div:nth-child(5) {
            transform: rotate(120deg);
            animation-delay: -0.7s;
        }

        .lds-spinner div:nth-child(6) {
            transform: rotate(150deg);
            animation-delay: -0.6s;
        }

        .lds-spinner div:nth-child(7) {
            transform: rotate(180deg);
            animation-delay: -0.5s;
        }

        .lds-spinner div:nth-child(8) {
            transform: rotate(210deg);
            animation-delay: -0.4s;
        }

        .lds-spinner div:nth-child(9) {
            transform: rotate(240deg);
            animation-delay: -0.3s;
        }

        .lds-spinner div:nth-child(10) {
            transform: rotate(270deg);
            animation-delay: -0.2s;
        }

        .lds-spinner div:nth-child(11) {
            transform: rotate(300deg);
            animation-delay: -0.1s;
        }

        .lds-spinner div:nth-child(12) {
            transform: rotate(330deg);
            animation-delay: 0s;
        }

        @keyframes lds-spinner {
            0% {
                opacity: 1;
            }

            100% {
                opacity: 0;
            }
        }

        .iq-navbar-logo img {
            height: 60px;
        }
    </style>
</head>

<body class="color-light fixed-top-navbar">
    <div id="loading">
        <div id="loading-center"></div>
    </div>
    <div class="wrapper">
        <div class="iq-top-navbar">
            <div class="iq-navbar-custom">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="iq-navbar-logo d-flex align-items-center justify-content-between">
                        <i class="ri-menu-line wrapper-menu"></i>
                        <a href="{{URL::to('/')}}" class="header-logo">
                            <img src="{{URL::to('assets/images/logo_panjang.png')}}" class="img-fluid rounded-normal light-logo" alt="logo">
                            <img src="{{URL::to('assets/images/logo_panjang.png')}}" class="img-fluid rounded-normal darkmode-logo" alt="logo">
                        </a>
                    </div>
                    <div class="iq-menu-horizontal">
                        <nav class="iq-sidebar-menu">
                            <div class="iq-sidebar-logo d-flex align-items-center justify-content-between">
                                <a href="{{URL::to('/')}}" class="header-logo">
                                    <img src="{{URL::to('assets/images/logo_panjang.png')}}" class="img-fluid rounded-normal light-logo" alt="logo">
                                    <img src="{{URL::to('assets/images/logo_panjang.png')}}" class="img-fluid rounded-normal darkmode-logo" alt="logo">
                                </a>
                                <div class="iq-menu-bt-sidebar">
                                    <i class="las la-bars wrapper-menu"></i>
                                </div>
                            </div>
                            <ul id="iq-sidebar-toggle" class="iq-menu d-flex">
                                @if(auth()->user()->ganti_pass == null)
                                @if(Session::get('level') == "SA" || Session::get('level') == "A" || Session::get('level') == "PI")
                                @include('menu.admin')
                                @elseif(Session::get('level')=="P")
                                @include('menu.pegawai')
                                @elseif(Session::get('level')=="B")
                                @include('menu.baak')
                                @endif
                                @endif
                            </ul>
                        </nav>
                    </div>
                    <nav class="navbar navbar-expand-lg navbar-light p-0">
                        <div class="change-mode">
                            <div class="custom-control custom-switch custom-switch-icon custom-control-indivne">
                                <div class="custom-switch-inner">
                                    <p class="mb-0"> </p>
                                    <input type="checkbox" class="custom-control-input" id="dark-mode" data-active="true">
                                    <label class="custom-control-label" for="dark-mode" data-mode="toggle">
                                        <span class="switch-icon-left"><i class="a-left ri-moon-clear-line"></i></span>
                                        <span class="switch-icon-right"><i class="a-right ri-sun-line"></i></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                            aria-label="Toggle navigation">
                            <i class="ri-menu-3-line"></i>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            <ul class="navbar-nav ml-auto navbar-list align-items-center">
                                <li class="nav-item nav-icon dropdown ml-4 rtl-ml-0">

                                </li>
                                <li class="nav-item nav-icon dropdown">

                                </li>
                                <li class="nav-item iq-full-screen"><a href="#" class="" id="btnFullscreen"><i class="ri-fullscreen-line"></i></a></li>
                                <li class="caption-content">
                                    <a href="#" class="iq-user-toggle">
                                        <img src="{{URL::to('assets/images/user/1.jpg')}}" class="img-fluid rounded" alt="user">
                                    </a>
                                    <div class="iq-user-dropdown">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between align-items-center mb-0">
                                                <div class="header-title">
                                                    <h4 class="card-title mb-0">Profile</h4>
                                                </div>
                                                <div class="close-data text-right btn btn-primary cursor-pointer"><i class="fas fa-window-close"></i></div>
                                            </div>
                                            <div class="data-scrollbar" data-scroll="2">
                                                <div class="card-body">
                                                    <div class="profile-header">
                                                        <div class="cover-container ">
                                                            <div class="media align-items-top mb-4">
                                                                <img src="{{URL::to('assets/images/user/1.jpg')}}" alt="profile-bg" class="rounded img-fluid" width="30%">
                                                                <div class="media-body profile-detail ml-3 rtl-ml-0 rtl-mr-3">
                                                                    <h6>{{Session::get('nama_pengguna')}}</h6>
                                                                    <hr />
                                                                    <div class="d-flex flex-wrap">
                                                                        <p class="mb-1">{{Session::get('userlevel')}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="p-3">
                                                        @if(Session::get('usertype'))
                                                        @if(count(Session::get('user_unit'))>0 && Session::get('jns_usertype') == "Dosen")
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="{{URL::to('loginaspimpinan')}}/{{Session::get('id_pengguna')}}" class="btn btn-primary"><i class="fas fa-user-graduate"></i> Login as pimpinan</a>
                                                            </div>
                                                        </div><br />
                                                        @endif
                                                        @if(Session::get('login_pimpinan')!=null or Session::get('login_satuan')!=null)
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="{{URL::to('loginas')}}/{{Session::get('id_pengguna')}}" class="btn btn-primary"><i class="fas fa-user-tie"></i> Login as Dosen</a>
                                                            </div>
                                                        </div><br />
                                                        @endif
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <a href="{{ url('logout') }}" class="btn btn-danger"><i class="fas fa-power-off"></i> Logout</a>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        <hr />
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <center>
                                                                    <a href="{{route('ubahpassword')}}" class="btn btn-primary">Ubah Password</a>
                                                                </center>
                                                            </div>
                                                        </div>
                                                        <br />
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <center>
                                                                    <a href="{{route('logout')}}" class="btn btn-danger">Logout</a>
                                                                </center>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </div>
        <div class="content-page">
            <div class="container">
                @yield('content')
            </div>

            <div id="container_spinner">
                <div class="lds-spinner">
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                    <div></div>
                </div>
            </div>
        </div>
    </div>
    <div id="balik"></div>
    @include('layouts.js')
    <script>
        let body = $("body");

        $('#container_spinner').hide();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
            }
        });
    </script>
    @stack('js')
</body>

</html>