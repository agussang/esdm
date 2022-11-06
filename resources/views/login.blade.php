<!doctype html>
<html lang="en">
<head>
   <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
      <title>{{$rsData->nama_aplikasi}} - {{$rsData->nama_instansi}}</title>
      <link rel="stylesheet" href="{{URL::to('assets/css/backend-plugin.min28b5.css?v=2.0.0')}}">
      <link rel="stylesheet" href="{{URL::to('assets/css/backend28b5.css?v=2.0.0')}}">
      <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
      <link rel="stylesheet" href="{{URL::to('assets/vendor/%40fortawesome/fontawesome-free/css/all.min.css')}}">
      <link rel="stylesheet" href="{{URL::to('assets/vendor/line-awesome/dist/line-awesome/css/line-awesome.min.css')}}">
      <link rel="stylesheet" href="{{URL::to('assets/vendor/remixicon/fonts/remixicon.css')}}">
      <link rel="stylesheet" href="{{URL::to('assets/vendor/%40icon/dripicons/dripicons.css')}}">
      <link rel='stylesheet' href="{{URL::to('assets/vendor/fullcalendar/core/main.css')}}" />
      <link rel='stylesheet' href="{{URL::to('assets/vendor/fullcalendar/daygrid/main.css')}}" />
      <link rel='stylesheet' href="{{URL::to('assets/vendor/fullcalendar/timegrid/main.css')}}" />
      <link rel='stylesheet' href="{{URL::to('assets/vendor/fullcalendar/list/main.css')}}" />
      <link rel="stylesheet" href="{{URL::to('assets/vendor/mapbox/mapbox-gl.css')}}">
   </head>
   <body class=" ">
      <div id="loading">
          <div id="loading-center">
          </div>
      </div>
      <div class="wrapper">
      <section class="login-content">
         <div class="container h-100">
            <div class="row align-items-center justify-content-center h-100">
               <div class="col-12">
                  <div class="row align-items-center">
                     <div class="col-lg-6">
                        <img src="{{URL::to('assets/images/logo_panjang.png')}}" class="img-fluid w-40" alt="">
                        <h2 class="mb-2">{{$rsData->nama_aplikasi}} <br/> {{$rsData->nama_instansi}}</h2>
                        <p>Masukkan Username dan Password Anda.</p>
                            <form class="form" action="{{route('login')}}" method="post">
						    {!! csrf_field() !!}
                           <div class="row">
                              <div class="col-lg-12">
                                 <div class="floating-label form-group">
                                    <input class="floating-input form-control" type="text" name="username" id="username" required>
                                    <label>Email</label>
                                 </div>
                              </div>
                              <div class="col-lg-12">
                                 <div class="floating-label form-group">
                                    <input class="floating-input form-control" type="password" name="password" id="password" required>
                                    <label>Password</label>
                                 </div>
                              </div>
                           </div>
                           <button type="submit" class="btn btn-primary">Login Ke Aplikasi</button>
                        </form>
                     </div>
                     <div class="col-lg-6 mb-lg-0 mb-4 mt-lg-0 mt-4">
                        <img src="{{URL::to('assets/images/login/01.png')}}" class="img-fluid w-80" alt="">
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
      </div>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="{{URL::to('assets/js/backend-bundle.min.js')}}"></script>
    <script src="{{URL::to('assets/js/flex-tree.min.js')}}"></script>
    <script src="{{URL::to('assets/js/tree.js')}}"></script>
    <script src="{{URL::to('assets/js/table-treeview.js')}}"></script>
    <script src="{{URL::to('assets/js/masonry.pkgd.min.js')}}"></script>
    <script src="{{URL::to('assets/js/imagesloaded.pkgd.min.js')}}"></script>
    <script src="{{URL::to('assets/js/mapbox-gl.js')}}"></script>
    <script src="{{URL::to('assets/js/mapbox.js')}}"></script>
    <script src="{{URL::to('assets/vendor/fullcalendar/core/main.js')}}"></script>
    <script src="{{URL::to('assets/vendor/fullcalendar/daygrid/main.js')}}"></script>
    <script src="{{URL::to('assets/vendor/fullcalendar/timegrid/main.js')}}"></script>
    <script src="{{URL::to('assets/vendor/fullcalendar/list/main.js')}}"></script>
    <script src="{{URL::to('assets/js/sweetalert.js')}}"></script>
    <script src="{{URL::to('assets/js/vector-map-custom.js')}}"></script>
    <script src="{{URL::to('assets/js/customizer.js')}}"></script>
    <script src="{{URL::to('assets/js/rtl.js')}}"></script>
    <script src="{{URL::to('assets/js/chart-custom.js')}}"></script>
    <script src="{{URL::to('assets/js/slider.js')}}"></script>
    <script src="{{URL::to('assets/js/app.js')}}"></script>
    <script>
        @if(Session::has('message'))
            var type="{{Session::get('alert-type','info')}}"
            switch(type){
                case 'info':
                     toastr.info("{{ Session::get('message') }}");
                     break;
                case 'success':
                    toastr.success("{{ Session::get('message') }}");
                    break;
                case 'warning':
                    toastr.warning("{{ Session::get('message') }}");
                    break;
                case 'error':
                    toastr.error("{{ Session::get('message') }}");
                    break;
            }
        @endif
    </script>
  </body>
</html>
