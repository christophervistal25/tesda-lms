@extends('layouts.student.short-app')
@section('title', '')
@section('content')
@prepend('page-css')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
@endprepend
<div class="alert alert-info" role="alert">
	Click the event to read more information.
</div>
<div class="card text-dark rounded-0">
	<div class="card-body">
		<div id="calendar"></div>
	</div>
</div>
<div class="modal fade" id="eventInfoModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-dark rounded-0">
			<div class="modal-header">
				<h4 class="modal-title" id="create-event-modal-title">Event information</h4>
			</div>
			<div class="modal-body">
					<div class="form-group row">
					<label class="col-md-auto">Title</label>
					<div class="col-md-12">
						<input type="text" readonly id="title" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-auto">Description</label>
					<div class="col-md-12">
						<input type="text" readonly id="description" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-auto">Location</label>
					<div class="col-md-12">
						<input type="text" readonly id="location" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-12">Time</label>
					<div class="col-md-12">
						<div id="time" class="text-center alert alert-info font-weight-bold" role="alert">
					</div>

					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="rounded-0 btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>
<script>
	    let calendarEl = document.getElementById('calendar');
	    let calendarProps = {
	     events: {
		    url: '/events',
		    method: 'GET',
		    failure: function() {
		      alert('there was an error while fetching events!');
		    }
		  },
    	 headerToolbar: {
	        left: 'prev,next,today',
	        center: 'title',
	        right: 'dayGridMonth,timeGridWeek,timeGridDay'
	      },
	      timeZone: 'Asia/Manila',
	      initialView: 'dayGridMonth',
	      selectable: true,
	      height: 650,
	       eventClick: function(schedule, jsEvent, view) {
	       		// Ajax request.
	       		$.get({
	       			url : `/student/event/view/${schedule.event.id}`,
	       			success : function (event) {
	       				$('#title').val(event.title);
	       				$('#description').val(event.description);
	       				$('#location').val(event.location);
	       				$('#time').html(`${moment(event.start).format('dddd, MMMM Do YYYY, h:mm A')} - ${moment(event.end).format('dddd, MMMM Do YYYY, h:mm A')}`)
	       				
	       			},
	       		});
	       		$('#eventInfoModal').modal('toggle');
		  },
		
		  
	    };

	    let calendar = new FullCalendar.Calendar(calendarEl, calendarProps);

	    calendar.render();



</script>
@endpush
@endsection