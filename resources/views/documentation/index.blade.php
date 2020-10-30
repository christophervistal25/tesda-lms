
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

  li > a.side-link:hover {
    opacity : 0.5;
    transition: all 0.35s;
  }

  </style>
</head>

<body>

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top effect1">
    <div class="container">
      <a class="navbar-brand" href="{{ route('admin.dashboard') }}"><img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1604075952/page-image/logo2_l0iqkt.webp" alt=""></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="rounded-0 text-white btn btn-success" target="_blank" href="{{ route('admin.dashboard') }}">Try it yourself</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Page Content -->
  <div class="container-fluid">

    <div class="row">
      <div class="col-lg-3">
      <h3 class="mt-5 ml-5">Guides</h3>
     	<ul class="text-left ml-5 pl-5" style="list-style: none;">
     		<li><a href="#dashboard" class="side-link text-dark font-size-link text-decoration-none">Dashboard</a>
          <ul style="list-style: none;">
            <li class="mb-2 mt-2"><a href="#" class="side-link text-dark text-decoration-none">Widgets</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">Side Navigation</a></li>
          </ul>
        </li>
     		<li><a href="#batch" class="side-link text-dark font-size-link text-decoration-none">Batch</a>
          <ul style="list-style: none;">
            <li class="mb-2 mt-2"><a href="#" class="side-link text-dark text-decoration-none">Create Batch</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">Edit Batch</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">Delete Batch</a></li>
          </ul>
        </li>
     		<li><a href="#" class="side-link text-dark font-size-link text-decoration-none">Course</a>
          <ul style="list-style: none;">
            <li class="mb-2 mt-2"><a href="#" class="side-link text-dark text-decoration-none">Add Module</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">View Module</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">Edit Course</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">Badges</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">Add Badge</a></li>
          </ul>
        </li>
     		<li><a href="#" class="side-link text-dark font-size-link text-decoration-none">Instructors</a>
          <ul style="list-style: none;">
            <li class="mb-2 mt-2"><a href="#" class="side-link text-dark text-decoration-none">Add Instructor</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Edit Instructor</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Assign Course</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Handle Course</a></li>
          </ul>
        </li>
     		<li><a href="#" class="side-link text-dark font-size-link text-decoration-none">Students</a>
          <ul style="list-style: none;">
            <li class="mb-2 mt-2"><a href="#" class="side-link text-dark text-decoration-none">Module Progress</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Edit Information</a></li>
          </ul>
        </li>
     		<li><a href="#" class="side-link text-dark font-size-link text-decoration-none">Events</a>
          <ul style="list-style: none;">
            <li class="mb-2 mt-2"><a href="#" class="side-link text-dark text-decoration-none">Add Event</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Edit Event</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Reschedule Event</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Month Display</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Week Display</a></li>
            <li class="mb-2 "><a href="#" class="side-link text-dark text-decoration-none">Day Display</a></li>
          </ul>
        </li>
     		<li><a href="#" class="side-link text-dark font-size-link text-decoration-none">Announcements</a>
            <ul style="list-style: none;">
            <li class="mb-2 mt-2"><a href="#" class="side-link text-dark text-decoration-none">Add Announcement</a></li>
            <li class="mb-2"><a href="#" class="side-link text-dark text-decoration-none">Edit Announcement</a></li>
          </ul>
        </li>
     	</ul>
      </div>
      <!-- /.col-lg-3 -->
      <div id="dashboard"></div>
      <div class="col-lg-8 mt-5">
      	<h2># Dashboard</h2>
        <hr>
        <img class="img-fluid mb-2 shadow" src="{{ asset('documentation_images/dashboard.png') }}" alt="Dashboard Image">
       	<div class="text-justify">
          <p id="">Let's first tackle the gray outline in the image above; inside the box are called widgets. This can help you check the current count of Students, Course, Modules,
          and especially Activities; by clicking those widgets, you can quickly jump
          to it sections (e.g.) You've clicked the # of students, you will automatically
          redirect to a list of students.</p>

          <p>The second outline with yellow color is called side
          navigation's like a menu in a restaurant, and by clicking one of those items
          you will redirect to a page containing the information that you want.</p>
        </div>
        <div class="border border-success mb-3"></div>
        <br>

        {{-- BATCH --}}
        <div id="batch"></div>
        <h2># Batch</h2>
        <hr>
        <img class="img-fluid mb-2 shadow" src="{{ asset('documentation_images/batch.png') }}" alt="Batch Image">
        <div class="text-justify">
          <p class="text-center">The image above is a list of batch.</p>

          <h4>Create new batch</h4>
          <p>If you’ve decided to add another batch, all you need to do is click the button at the right side corner with “New Batch” text, then a dialog will appear with some input fields; take note you must fill in it all.</p>

          <div class="border border-success mb-3"></div>

          <h4>Edit batch</h4>
          <p>Are you confused about the two buttons inside the last column for every row? Let's talk about the first one with a blue background and a pencil icon. This is for modifying/edit batch; it has the identical method as creating a new batch, except all fields already have a value; replace it if you have a typo, etc.</p>
          
          <div class="border border-success mb-3"></div>

          <h4>Delete batch</h4>
          <p>As you read the title, you already had an idea of what this button with a red background and trash icon can do once you've click this button, a dialog box will show holding a message <span class="text-danger">"Please double check the record before hitting DELETE button"</span> click the delete button to proceed.</p>
        </div>
        <div class="border border-success mb-5"></div>
        {{-- END OF BATCH --}}

        {{-- COURSE --}}
        <h2># Course</h2>
        <hr>
        <img class="img-fluid mb-2 shadow" src="{{ asset('documentation_images/batch.png') }}" alt="Course Image">
        <div class="text-justify">
          <p class="text-center">The image above is a list of batch.</p>

          <h4>Add Module</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>View Module</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
          
          <div class="border border-success mb-3"></div>

          <h4>Edit Course</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>
          <h4>Badges</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
          

          <div class="border border-success mb-3"></div>
          
          <h4>Add Badge</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
         
        </div>
        <div class="border border-success mb-5"></div>
        {{-- END OF COURSE --}}

        {{-- INSTRUCTOR --}}
        <h2># Instructor</h2>
        <hr>
        <img class="img-fluid mb-2 shadow" src="{{ asset('documentation_images/batch.png') }}" alt="Instructor Image">
        <div class="text-justify">
          <p class="text-center">The image above is a list of batch.</p>

          <h4>Add Instructor</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Edit Instructor</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
          
          <div class="border border-success mb-3"></div>

          <h4>Assign Course</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>
          <h4>Handle Course</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
        </div>
        <div class="border border-success mb-5"></div>
        {{-- END OF INSTRUCTOR --}}

        {{-- STUDENTS --}}
        <h2># Students</h2>
        <hr>
        <img class="img-fluid mb-2 shadow" src="{{ asset('documentation_images/batch.png') }}" alt="Students Image">
        <div class="text-justify">
          <p class="text-center">The image above is a list of batch.</p>

          <h4>Module Progress</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Edit Information</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
        </div>
        <div class="border border-success mb-5"></div>
        {{-- END OF STUDENTS --}}

        {{-- EVENTS --}}
         <h2># Events</h2>
        <hr>
        <img class="img-fluid mb-2 shadow" src="{{ asset('documentation_images/batch.png') }}" alt="Events Image">
        <div class="text-justify">
          <p class="text-center">The image above is a list of batch.</p>

          <h4>Add Event</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Edit Event</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Reschedule Event</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Month Display</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Week Display</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Day Display</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
        </div>
        <div class="border border-success mb-5"></div>
        {{-- END OF EVENTS --}}

        {{-- ANNOUNCEMENTS --}}
         <h2># Announcements</h2>
        <hr>
        <img class="img-fluid mb-2 shadow" src="{{ asset('documentation_images/batch.png') }}" alt="Events Image">
        <div class="text-justify">
          <p class="text-center">The image above is a list of batch.</p>

          <h4>Add Announcement</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>

          <div class="border border-success mb-3"></div>

          <h4>Edit Announcement</h4>
          <p>(Temporary Text) Lorem ipsum, dolor sit amet consectetur adipisicing, elit. Officia veniam consequatur error sit ipsa non assumenda aliquid eius quis explicabo molestiae nemo modi accusantium temporibus velit aliquam dolores, ratione debitis.</p>
  
        </div>
        <div class="border border-success mb-3"></div>
        {{-- END OF ANNOUNCEMENTS --}}

      </div>
      <!-- /.col-lg-8 -->

    </div>

  </div>
  <!-- /.container -->


</body>

</html>
