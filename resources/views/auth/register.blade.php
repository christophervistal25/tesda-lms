<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" >
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>TESDA TANDAG LMS |  @yield('title') </title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==" crossorigin="anonymous" />
    <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.7/css/sb-admin-2.min.css" integrity="sha512-FXgL8f6gtCYx8PjODtilf5GCHlgTDdIVZKRcUT/smwfum7hr4M1ytewqTtNd9LK4/CzbW4czU6Tr3f3Xey6lRg==" crossorigin="anonymous" />
    <style>
    * { font-family : "Poppins", sans-serif; }
    body {
    background : #eef5f9;
    }
    </style>
  </head>
  <body >
    
    <!-- Begin Page Content -->
    <div class="row">
      <div class="col-lg-8 offset-2 py-5">
        <div class="card mb-4 rounded-0">
          <div class="card-body">
            <form action="{{ route('register') }}" method="POST">
              @csrf
              @if($errors->any())
                @foreach($errors->all() as $error)
                  <li class="text-danger">{{ $error }}</li>
                @endforeach
              @endif
              <h4 class="text-dark">New account</h4>
              <h5 class="text-dark">Choose your username and password</h5>
              <div class="form-group row">
                <label for="inputUsername" class="col-sm-2 col-form-label text-dark">Username</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control rounded-0 text-dark" id="inputUsername" name="username" value="{{ old('username') }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label text-dark"></label>
                <div class="col-sm-10 text-dark">
                  <span class="text-dark">The password must have at least 8 characters, at least 1 digit(s), at least 1 lower case letter(s), at least 1 upper case letter(s), at least 1 non-alphanumeric character(s) such as as *, -, or #</span>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputPassword" class="col-sm-2 col-form-label text-dark">Password</label>
                <div class="col-sm-10">
                  <input type="password" class="form-control rounded-0 text-dark" name="password" id="inputPassword">
                </div>
              </div>
              <h5 class="text-dark">More details</h5>
              <div class="form-group row">
                <label for="inputEmail" class="col-sm-2 col-form-label text-dark">Email</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control rounded-0 text-dark" name="email" id="inputEmail">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputConfirmEmail" class="col-sm-2 col-form-label text-dark">Email (again)</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control rounded-0 text-dark" name="confirm_email" id="inputConfirmEmail">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputFirstname" class="col-sm-2 col-form-label text-dark">First name</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control rounded-0 text-dark" name="first_name" id="inputFirstname" value="{{ old('first_name') }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputSurname" class="col-sm-2 col-form-label text-dark">Surname</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control rounded-0 text-dark" name="surname" id="inputSurname" value="{{ old('surname') }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputCityTown" class="col-sm-2 col-form-label text-dark">City/town</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control rounded-0 text-dark" name="city_town" id="inputCityTown" value="{{ old('city_town') }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="inputCountry" class="col-sm-2 col-form-label text-dark">Country</label>
                <div class="col-sm-10">
                  <select name="country" id="inputCountry" class="form-control rounded-0 text-dark">
                    @foreach(config('country.list') as $shortVal => $displayVal)
                     <option value="{{ $shortVal }}" {{ old('country') == $shortVal ? 'selected' : '' }}>{{ $displayVal }}</option>
                    @endforeach
                  </select>
                </div>
              </div>
              <div class="form-group row">
                <label for="inputCountry" class="col-sm-2 col-form-label text-dark"></label>
                <div class="col-sm-10">
                  <input type="submit" class="btn btn-primary rounded-0" value="Create my new account">
                  <input type="button" class="btn btn-light rounded-0" value="Cancel" style="background :#CED4DA">
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
    
    
    <!-- Bootstrap core JavaScript-->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <!-- Core plugin JavaScript-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js" integrity="sha512-0QbL0ph8Tc8g5bLhfVzSqxe9GERORsKhIn1IrpxDAgUsbBGz/V7iSav2zzW325XGd1OMLdL4UiqRJj702IeqnQ==" crossorigin="anonymous"></script>
    <!-- Custom scripts for all pages-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.7/js/sb-admin-2.min.js" integrity="sha512-tEHlevWV9EmBCnrR098uzR3j8T3x4wtGnNY6SdsZN39uxICadRZaxrRH90iHPqjsqZK5z76gw0uuAvlCoasOUQ==" crossorigin="anonymous"></script>
  </body>
</html>