<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">



        <!-- Bootstrap Core CSS -->
		<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

        <!-- MetisMenu CSS -->
        <link href="{{ asset('css/metisMenu.min.css') }}" rel="stylesheet">

        <!-- Timeline CSS -->
        <link href="{{ asset('css/timeline.css') }}" rel="stylesheet">

        <!-- Custom CSS -->
        <link href="{{ asset('css/style.css') }}" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/mdi/css/materialdesignicons.min.css') }}">
        <link href="{{ asset('css/startmin.css') }}" rel="stylesheet">
      
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

        <!-- Morris Charts CSS -->
        <link href="{{ asset('css/morris.css') }}" rel="stylesheet">
		<link href="{{ asset('css/toastr.css') }}" rel="stylesheet">

        <!-- Custom Fonts -->
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" type="text/css">
		<link rel="dns-prefetch" href="//fonts.gstatic.com">
		<link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    </head>
    <body>
<div class="container-fluid login-section-cs">
   
<div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="content-wrapper d-flex align-items-center auth">
          <div class="row flex-grow">
            <div class="col-lg-4 mx-auto">
              <div class="auth-form-light text-center p-5">
                <div class="brand-logo">
                  <img src="images/logo.jpg">
                </div>
                <h4>Hello! let's get started</h4>
                <h6 class="font-weight-light">Sign in to continue.</h6>
                <form class="pt-3">
                  <div class="form-group">
                    <input type="email" class="form-control  @error('email') is-invalid @enderror" id="exampleInputEmail1" value="{{ old('email') }}" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control  @error('password') is-invalid @enderror" id="exampleInputPassword1" placeholder="Password" required autocomplete="current-password" >
                  </div>
                  <div class="mt-3">
                    <a class="btn btn-block btn-gradient-primary font-weight-medium auth-form-btn" href="{{route('home')}}" >   {{ __('Login') }}</a>
                  </div>
                  

                  <div class="my-2 d-flex justify-content-between align-items-center">
                    <div class="form-check form-check-success">
                      <label class="form-check-label text-muted">
                                <input type="checkbox" class="form-check-input "  checked=""> Keep me signed in <i class="input-helper"></i></label>
                            </div>
                            <a href="#" class="auth-link text-black">Forgot password?</a>
                            </div>

               
                   
               
                  <!-- <div class="mb-2">
                    <button type="button" class="btn btn-block btn-facebook auth-form-btn">
                      <i class="mdi mdi-facebook mr-2"></i>Connect using facebook </button>
                  </div> -->
                  <div class="text-center mt-4 font-weight-light"> Don't have an account? <a href="register.html" class="text-primary">Create</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>              

</div>
                          
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('js/jquery.min.js') }}"></script>
		<script src="{{ asset('js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('js/metisMenu.min.js') }}"></script>
		<script src="{{ asset('js/raphael.min.js') }}"></script>
		<script src="{{ asset('js/startmin.js') }}"></script>

    </body>
</html>