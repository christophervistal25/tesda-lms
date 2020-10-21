<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico"> -->

    <title>Pricing example for Bootstrap</title>
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
       * { font-family : "Poppins", sans-serif; }
       .box-shadow {
          -webkit-box-shadow: 5px 0 10px rgba(0,0,0,.1);
          box-shadow: 0 0 20px rgba(0,0,0,.1);
       }
    </style>
  </head>

  <body>

    <div class="d-flex flex-column flex-md-row align-items-center p-0 px-md-4 mb-3 bg-white box-shadow">
      <img width="17%" src="//lms.mnpvi-tesda.com/pluginfile.php/1/theme_moove/logo/1598161402/Logo%20with%20site%20name.png" alt="HQ LMS">
    </div>

    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-5 ">
          Lorem ipsum dolor sit amet consectetur adipisicing elit. Eum dolorum ab consequuntur harum reiciendis amet, rerum accusantium neque alias excepturi soluta omnis iusto iure suscipit nulla. Officiis eaque reprehenderit quibusdam.
        </div>

       <div class="col-lg-5 offset-1 ">
              <div class="card">
                <div class="card-body">
                  <h3>Access to the platform</h3>
                  <form action="{{ route('login') }}" method="POST" >
                    @csrf
                    @if($errors->any())
                      @foreach($errors->all() as $error)
                        <li class="text-danger">{{ $error }}</li>
                      @endforeach
                    @endif
                    <div class="form-group">
                      <label>Username</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text rounded-0"><i class="fa fa-envelope add-on"></i></div>
                        </div>
                        <input type="text" class="form-control rounded-0" name="email" placeholder="Username">
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Password</label>
                      <div class="input-group">
                        <div class="input-group-prepend">
                          <div class="input-group-text rounded-0"><i class="fa fa-lock add-on"></i></div>
                        </div>
                        <input type="password" class="form-control rounded-0" name="password"  placeholder="password">
                      </div>
                    </div>
                    
                    
                    <div class="sign-up-btn mt-2">
                      <button type="submit" class="btn btn-primary btn-lg rounded-0">Log in</button>
                    </div>
                  </form>
                  
                  
                  <p class="my-2"><a href="http://lms.mnpvi-tesda.com/login/forgot_password.php">Forgotten your username or password?</a></p>
                  
                  <a class="btn btn-block btn-register btn-primary rounded-0" href="{{ route('register') }}">New account</a>
                  
                </div>
              </div>
        </div>
    </div>
    </div>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
  </body>
</html>
