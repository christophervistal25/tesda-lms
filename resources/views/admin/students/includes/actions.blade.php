@if($student->progress() != 0)
	<div class="progress rounded-0">
	  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar"  aria-valuemin="0" aria-valuemax="{{ config('student_progress.max_percentage') }}" style="width: {{ $student->progress() }}%"></div>
	</div>
@endif
