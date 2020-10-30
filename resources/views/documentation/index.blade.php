
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>{{ env('APP_NAME') }} | Documentation</title>
  <link rel="icon" href="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1604075788/icons/loder_h2qnck.webp">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">
  <style>
  * { font-family : "Poppins", sans-serif; }
	body { padding-top: 56px; }
	.effect1 {
		-webkit-box-shadow: 0 10px 6px -6px #a1a1a1;
	   	-moz-box-shadow: 0 10px 6px -6px #a1a1a1;
	        box-shadow: 0 10px 6px -6px #a1a1a1;
	}

	.font-size-link {
		font-size :1.2em;
	}
  </style>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top effect1">
    <div class="container">
      <a class="navbar-brand" href="#"><img src="{{ asset('assets/img/logo/logo2.png') }}" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-white" href="{{ route('admin.dashboard') }}">Dashboard</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container">

    <div class="row">
      <div class="col-lg-3 offset-2 mt-5 fixed-top">
        <h3 class="mt-5">Guides</h3>
     	<ul class="text-left" style="list-style: none;">
     		<li class="mb-3"><a href="#" class="text-dark font-size-link">Dashboard</a></li>
     		<li class="mb-3"><a href="#" class="text-dark font-size-link">Batch</a></li>
     		<li class="mb-3"><a href="#" class="text-dark font-size-link">Course</a></li>
     		<li class="mb-3"><a href="#" class="text-dark font-size-link">Instructors</a></li>
     		<li class="mb-3"><a href="#" class="text-dark font-size-link">Students</a></li>
     		<li class="mb-3"><a href="#" class="text-dark font-size-link">Events</a></li>
     		<li class="mb-3"><a href="#" class="text-dark font-size-link">Announcements</a></li>
     	</ul>
      </div>
      <!-- /.col-lg-3 -->

      <div class="col-lg-9 offset-2 mt-5">
      	<h2>Dashboard</h2>
      	<hr>
       	<p>Lorem, ipsum dolor, sit amet consectetur adipisicing elit. Voluptatibus vel quis nisi, quia iure et doloribus assumenda impedit ab harum animi quod, maiores in unde nihil blanditiis reprehenderit laborum aliquid?</p>
      </div>
      <!-- /.col-lg-9 -->

    </div>

  </div>
  <!-- /.container -->


</body>

</html>
