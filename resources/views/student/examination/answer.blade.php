@extends('layouts.student.app')
@section('title', '')
@section('content')
<div class="card rounded-0 mb-4">
	<div class="card-body">
		<h1 class="text-dark">{{ $course->name }}</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-9">
		<div class="card rounded-0 mb-4">
			<form action="{{ route('answer.final.exam.submit', $module) }}" method="POST" id="formExam">
				@csrf
			<div class="card-body text-dark">
				<div class="row">
					
					@foreach($questions as $q)
						<div class="col-lg-1 mb-2 pl-1 pr-1" style="background :#dee2e6; height : 16vh; border : 1px solid #cad0d7;">
							<small>Question</small> <strong>{{ $q->question_no }}</strong>
							<small>Answer saved</small>
							<small>Marked out of 1.00</small>
							<br>
							<small><i class="fas fa-flag"></i> Flag Question</small>
						</div>
						<div class="col-lg-11">
							@if($q->type == 'MULTIPLE')
								<div class="pl-4 pt-3 pb-1 " style="background:#def2f8;">
									{{ preg_replace('/\d+\./', '', $q->question) }}
									<p></p>
									@if($q->choices->count() !== 0)
										<div class="ml-3">
											@foreach($q->choices as $c)
												<div class="float-right">
													<button onclick="removeChoice(this)" class="btn btn-sm btn-danger rounded-0" data-point-to="${id}"><i class="fas fa-times" ></i> </button>
												</div>
												<div class="clearfix"></div>
												<div contenteditable="true" id="choice-${id}" class="border border-white p-2 ml-2 mb-2"  data-choice="{{ $c->choice }}">
													{{ $c->choice }}
												</div> 
											@endforeach
										</div>
									@endif
								</div>
							<br>
							@elseif($q->type == 'TORF')
								<div class="pl-4 pt-3 pb-3" style="background:#def2f8; height : 25vh;">
									{{ preg_replace('/\d+\./', '', $q->question) }}
									<p></p>
									<p>Select one:</p>
									<div class="ml-3">
										<label for="choice-true-{{ $q->question_no }}"><input type="radio" id="choice-true-{{ $q->question_no }}" value="True" name="question_{{ $q->question_no }}"> True</label>
										<p><label for="choice-false-{{ $q->question_no }}"><input type="radio" id="choice-false-{{ $q->question_no }}" value="False" name="question_{{ $q->question_no }}"> False</label></p>
									</div>
								</div>
							<br>
							@elseif($q->type == 'FITB')
								<div class="pl-4 pt-3 pb-3" style="background:#def2f8; height : 25vh;">
									{{ preg_replace('/\d+\./', '', $q->question) }}
									<p></p>
									<div class="row">
											<div class="col-lg-auto ml-3 text-right pr-0">
												<label>Answer: &nbsp;</label>
											</div>
											<div class="col-lg-6">
												<input type="text" class="rounded-0 form-control" name="question_{{$q->question_no}}">
											</div>
									</div>
									<p></p>
								</div>
							<br>
							@endif
						</div>
					@endforeach
				</div>
				<input type="hidden" name="attempt_id" value="{{ $attempt_id }}">
				{{-- <div class="pl-4 pr-4"></div> --}}
				<div class="float-right">
					<input type="submit" class="btn btn-primary rounded-0" id="btnSubmitExam" value="Finish attempt...">
				</div>
				<div class="clearfix"></div>
			</div>
		</form>
			<hr>
			<div class="container-fluid py-2">
				<div class="row">
					<div class="col-md-4 text-left">
						@if($previous instanceof App\Activity)
							<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
							<br>
							<a href="{{ route('student.activity.view', $previous->id) }}" class="btn btn-link" title="{{$previous->title}}">◄ {{ $previous->activity_no }} {{ $previous->title }}</a>
						@elseif($previous instanceof App\File)
							<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
							<br>
							<a href="{{ route('student.course.overview.show.file', [$course->id, $previous->id]) }}" id="prev-activity-link" class="btn btn-link" title="{{ $previous->title }}">◄ {{ $previous->title }}</a>
						@endif
					</div>

					<div class="col-md-4 mt-2">
						<select id="jumpToOptions" class="form-control rounded-0 text-dark">
							<option selected disabled>Jump to...</option>
							
							@foreach($overview->files as $f)
								<option data-link="/student/course/{{ $course->id }}/overview/show/{{ $f->id }}">{{ $f->title }}</option>
							@endforeach

							@foreach($modules as $module)
								@foreach($module->activities->where('completion', null) as $activity)
									<option data-link="/student/activity/view/{{ $activity->id }}">{{ $activity->activity_no }} {{ $activity->title }}</option>
								@endforeach
							@endforeach 

							<option selected data-link="/student/final/exam/{{ $module->exam->id }}">{{ $module->exam->title }}</option>

							@foreach($modules as $module)
								@foreach($module->activities->where('completion', 1) as $activity)
									<option {{ $canDownloadCertificate ?: 'disabled' }} data-link="/student/activity/view/{{ $activity->id }}">{{ $activity->title }}</option>
								@endforeach
							@endforeach

						</select>
					</div>

					<div class="col-md-4 text-right">
						@if(!is_null($next) && $next instanceof App\Activity)
							<span class="text-dark mr-3">NEXT ACTIVITY</span>
							<br>
							<a href="{{ route('student.activity.view', $next->id) }}" class="btn btn-link" title="{{$next->title}}"> {{ $next->title }} ►</a>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="card rounded-0">
			<div class="card-body text-dark">
				<h5 class="card-title">Quiz Navigation</h5>
				<h3 class="card-text">Final Exam</h3>
				@foreach(range(1, $questions->count()) as $item)
					<button class="btn btn-sm btn-secondary">{{ $item }}</button>
				@endforeach
				<br>
				<br>
				<a href="#">Finish attempt ...</a>
			</div>
		</div>
	</div>
</div>

@push('page-scripts')
<script>
	$('#sidebarToggle').trigger('click');

	$('#jumpToOptions').change(function (e) {
		let selectedItemLink = $(this).children("option:selected").attr('data-link');
		location.href = selectedItemLink;
	});
	$('#formExam').submit(function () {
		$('#btnSubmitExam').prop('disabled', true);
	});
	
</script>
@endpush
@endsection