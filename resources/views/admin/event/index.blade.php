@extends('layouts.admin.app')
@section('title', 'Events')
@section('content')
@prepend('page-css')
<link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css' rel='stylesheet' />
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js'></script>
<style>
	.fade-scale {
	  transform: scale(0);
	  opacity: 0;
	  -webkit-transition: all .25s linear;
	  -o-transition: all .25s linear;
	  transition: all .25s linear;
	}

	.fade-scale.in {
	  opacity: 1;
	  transform: scale(1);
	}
</style>
@endprepend
<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Calendar</h6>
	</div>

	
	<div class="card-body">
		<div class="text-dark" id="calendar"></div>
	</div>
</div>

<div class="modal fade" id="createEventModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-dark rounded-0">
			<div class="modal-header">
				<h4 class="modal-title" id="create-event-modal-title">Create event</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger d-none" id="create-event-form-message" role="alert">
					
				</div>
				<form id="createEventForm">
					<div class="form-group row">
					<label class="col-md-auto">Title</label>
					<div class="col-md-12">
						<input type="text" id="title" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-auto">Description</label>
					<div class="col-md-12">
						<input type="text" id="description" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-auto">Location</label>
					<div class="col-md-12">
						<input type="text" id="location" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-6">Start time</label>
					<label class="col-md-6">End time</label>
					<div class="col-md-6">
						<input type="time" id="start" class="form-control rounded-0">
					</div>

					<div class="col-md-6">
						<input type="time" id="end" class="form-control rounded-0">
					</div>
				</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="rounded-0 btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="rounded-0 btn btn-primary" id="btnSaveEvent">Save Event</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="editEventModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-dark rounded-0">
			<div class="modal-header">
				<h4 class="modal-title" id="edit-event-modal-title">Edit event</h4>
			</div>
			<div class="modal-body">
				<div class="alert alert-danger d-none" id="edit-event-form-message" role="alert">
					
				</div>
				<form id="editEventForm">
					<div class="form-group row">
					<label class="col-md-auto">Title</label>
					<div class="col-md-12">
						<input type="text" id="edit-title" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-auto">Description</label>
					<div class="col-md-12">
						<input type="text" id="edit-description" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-auto">Location</label>
					<div class="col-md-12">
						<input type="text" id="edit-location" class="form-control rounded-0">
					</div>
				</div>

				<div class="form-group row">
					<label class="col-md-6">Start time</label>
					<label class="col-md-6">End time</label>
					<div class="col-md-6">
						<input type="time" id="edit-start" class="form-control rounded-0">
					</div>

					<div class="col-md-6">
						<input type="time" id="edit-end" class="form-control rounded-0">
					</div>
				</div>
				</form>

			</div>
			<div class="modal-footer">
				<button type="button" class="rounded-0 btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="rounded-0 btn btn-success" id="btnUpdateEvent">Save Event</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="confirmationEventModal">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-dark rounded-0">
			<div class="modal-header">
				<h4 class="modal-title" id="edit-event-modal-title">Re-schedule event</h4>
			</div>
			<div class="modal-body">
				<div id="confirmation-dynamic-content">
					
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="rounded-0 btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="rounded-0 btn btn-success" id="btnConfirmResched">Re-schedule Event</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@push('page-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous"></script>

<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
</script>
<script>
	let selectedDate     = null;
	let editSelectedDate = null;
	let eventId          = null;
	let rescheduleData   = {};


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
	      editable: true,
	      droppable: true, // this allows things to be dropped onto the calendar
	      timeZone: 'Asia/Manila',
	      initialView: 'dayGridMonth',
	      selectable: true,
	      height: 650,
	       eventClick: function(schedule, jsEvent, view) {
			editSelectedDate = schedule.event.startStr;
			eventId      = schedule.event.id;
	       	$.ajax({
	       		url : `/admin/event/${schedule.event.id}/edit`,
	       		method : 'GET',
	       		success : (event) => {
	       			$('#edit-title').val(event.title);
	       			$('#edit-description').val(event.description);
	       			$('#edit-location').val(event.location);
	       			document.getElementById('edit-start').value = moment(event.start).format('hh:mm:ss');
	       			document.getElementById('edit-end').value = moment(event.end).format('hh:mm:ss');
	       		}
	       	});
		    $('#edit-event-modal-title').text(`Edit event ${moment(editSelectedDate).format("dddd, MMMM Do YYYY")}`);
		    $('#editEventModal').modal('toggle');
		  },
	      dateClick: function(info) {
	      	let date = info.dateStr;
	      	$('#create-event-modal-title').text(`Create event for ${moment(info.dateStr).format("dddd, MMMM Do YYYY")}`);
	      	$('#createEventModal').modal('toggle');
	      	selectedDate = date;
		  },
		  eventDragStart : function (schedule, jsEvent, view) {
		  },
		  eventDrop : function (schedule) {
		  	$('#confirmation-dynamic-content')
		  			.text(`Are you sure to re-schedule this to (${moment(schedule.event.startStr).format('MMMM Do YYYY, h:mm A')} - ${moment(schedule.event.endStr).format(' MMMM Do YYYY, h:mm A')})`);
		  	$('#confirmationEventModal').modal('toggle');
		  	rescheduleData = {
		  		id : schedule.event.id,
		  		date : moment(schedule.event.startStr).format('MM/D/YYYY'),
		  		start : moment(schedule.event.startStr).format('MM/D/YYYY h:mm:ss A'),
		  		end : moment(schedule.event.endStr).format('MM/D/YYYY h:mm:ss A'),
		  	};
		  },
		  eventResize : function (schedule) {
		  	$('#confirmation-dynamic-content')
		  			.text(`Are you sure to re-schedule this to (${moment(schedule.event.startStr).format('MMMM Do YYYY, h:mm A')} - ${moment(schedule.event.endStr).format(' MMMM Do YYYY, h:mm A')})`);
		  	$('#confirmationEventModal').modal('toggle');
		  	rescheduleData = {
		  		id : schedule.event.id,
		  		date : moment(schedule.event.startStr).format('MM/D/YYYY'),
		  		start : moment(schedule.event.startStr).format('MM/D/YYYY h:mm:ss A'),
		  		end : moment(schedule.event.endStr).format('MM/D/YYYY h:mm:ss A'),
		  	};
		  }
    };

    let calendar = new FullCalendar.Calendar(calendarEl, calendarProps);

    calendar.render();

    $('#btnUpdateEvent').click(function(e) {

  		let data = {
  			title 		: $('#edit-title').val(),
			description : $('#edit-description').val(),
			location 	: $('#edit-location').val(),
			start 		: $('#edit-start').val(),
			end 		: $('#edit-end').val(),
			date 		: moment(editSelectedDate).format('MM/D/YYYY'),
  		};
  		
  		$.ajax({
  			url : `/admin/event/${eventId}`,
  			method : 'PUT',
  			data : data,
  			success : function (response) {
  				if (response.success) {
  					$('#editEventForm').trigger('reset');
  					$('#editEventModal').modal('toggle');
  					swal("Good job!", "Successfully update event", "success");
  					calendar.refetchEvents();
  				}
  			},
  			error : function (response) {
  				if (response.status === 422) {
  					$('#edit-event-form-message')
  								.html('')
  								.removeClass('d-none');

  					let errors = response.responseJSON.errors;
  					Object.values(errors).forEach((error, key) => $('#edit-event-form-message').append(`<li>${error}</li>`) );
  				}
  			}
  		});
  	
    });

  	$('#btnSaveEvent').click(function (e) {
  		let data = {
  			title 		: $('#title').val(),
			description : $('#description').val(),
			location 	: $('#location').val(),
			start 		: $('#start').val(),
			end 		: $('#end').val(),
			date 		: moment(selectedDate).format('MM/D/YYYY'),
  		};

  		$.ajax({
  			url : "{{ route('event.store') }}",
  			method : "POST",
  			data : data,
  			success : function (response) {
  				if (response.success) {
  					$('#createEventForm').trigger('reset');
  					$('#createEventModal').modal('toggle');
  					swal("Good job!", "Successfully create new event", "success");
  					calendar.refetchEvents();
  				}
  			},
  			error : function (response) {
  				if (response.status === 422) {
  					$('#create-event-form-message')
  								.html('')
  								.removeClass('d-none');

  					let errors = response.responseJSON.errors;
  					Object.values(errors).forEach((error, key) => $('#create-event-form-message').append(`<li>${error}</li>`) );
  				}
  			}
  		});
  	});

  	$('#confirmationEventModal').on('hide.bs.modal', function (e) {
	  calendar.refetchEvents();
	});

  	$('#btnConfirmResched').click(function (e) {
  		$.ajax({
  			url : `/admin/event/reschedule/${rescheduleData.id}`,
  			method : 'PUT',
  			data : rescheduleData,
  			success : function (response) {
  				if (response.success) {
  					$('#confirmationEventModal').modal('toggle');
  					swal("Good job!", "Successfully re-schedule a event", "success");
  					calendar.refetchEvents();
  				}
  			},
  		});
  	});
  </script>
@endpush
@endsection
