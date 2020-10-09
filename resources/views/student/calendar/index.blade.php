@extends('layouts.student.short-app')
@section('title', '')
@section('content')
@prepend('page-css')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
@endprepend
<div class="card text-dark rounded-0">
	<div class="card-body">
		<div id="calendar"></div>
	</div>
</div>
@push('page-scripts')
<script>
	document.addEventListener('DOMContentLoaded', function() {
	    var calendarEl = document.getElementById('calendar');

	    var calendar = new FullCalendar.Calendar(calendarEl, {
	      timeZone: 'Asia/Manila',
	      initialView: 'dayGridMonth',
	      editable: true,
	      selectable: true,
	      height: 650,
	      dateClick: function(info) {
		    alert('Clicked on: ' + info.dateStr);
		
		    info.dayEl.style.backgroundColor = 'red';    // change the day's background color just for fun
		  }
	    });

	    calendar.render();
  	});



</script>
@endpush
@endsection