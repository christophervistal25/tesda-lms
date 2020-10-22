@extends('layouts.admin.app')
@section('title', '')
@section('content')
@prepend('page-css')
<style>
	.cursor-pointer {
		cursor: pointer;
	}
	.item-generator:hover {
		background :#0035a9;
		transition: 0.3s;
		color :white;
		font-weight: 500;
	}
</style>
@endprepend
<div class="row">
	<div class="col-lg-3">
		<div class="card rounded-0 text-center ">
						<ul class="list-group list-group-flush">
							<li class="item-generator list-group-item rounded-0 cursor-pointer" id="btnGenerateMultipleChoice">Multiple Choice</li>
							<li class="item-generator list-group-item rounded-0 cursor-pointer" id="btnGenerateTrueOrFalse">True or False</li>
							<li class="item-generator list-group-item rounded-0 cursor-pointer" id="btnGenerateFillInTheBlank">Fill in the blank</li>
						</ul>
					</div>
	</div>
	<div class="col-lg-9">
		<div class="card rounded-0 mb-4">
{{-- 			<form action="" method="POST"> --}}
				@csrf
			<div class="card-body text-dark">
				<div class="row">
					
					@foreach($questions as $q)
						<div class="col-lg-12">
							@if($q->type == 'MULTIPLE')
								<div class="pl-4 pt-3 pb-1  bg-info text-white">
									<div class="card-text p-1 mr-3 text-white border border-white questions" contenteditable="true" data-question-type="{{ $q->type }}" data-question-index="{{ $q->question_no }}">{{ $q->question }}
									</div>
									
									<p></p>
									@if($q->choices->count() !== 0)
										<div class="ml-3">
											<div id="dynamic-choice-{{ $q->question_no }}" class="mr-3">
												@foreach($q->choices as $c)
												<div contenteditable="true" id="choice-{{ $c->choice[0] }}-{{ $q->question_no }}" class="border border-white p-2 ml-2 mb-2"  data-choice="{{ $c->choice[0] }}">{{ $c->choice }}</div> 
												@endforeach
											</div>
										</div>
									@endif
									<div class="form-inline">
										<button class="btn btn-sm btn-primary mr-3" onclick="generateChoice({{ $q->question_no }})"><i class="fas fa-plus" data-question-index="{{ $q->question_no }}"></i> Add choices</button>
										<button class="btn btn-sm btn-success" onclick="submitChoices({{ $q->question_no }})"><i class="fas fa-plus" data-question-index="{{ $q->question_no }}"></i> Submit Choices</button>
									</div>
									<hr style="background :white;">
									<div class="form-group pr-3">
										<label for="multiple_correct_answer-{{ $q->question_no }}">Choose correct answer</label>
										<select id="multiple_correct_answer-{{ $q->question_no }}" class="form-control">
											@foreach($q->choices as $c)
												<option value="{{ $c->choice }}">{{ $c->choice }}</option>
											@endforeach
										</select>
									</div>
									<br>
								</div>
							<br>
							@elseif($q->type == 'TORF')
								<div class="pl-4 pt-3 pb-3 bg-info text-white">
									<div class="card-text p-1 border border-white questions" contenteditable="true" data-question-type="{{ $q->type }}" data-question-index="{{ $q->question_no }}">{{ $q->question }}
									</div>
									<p></p>
									<p>Select one:</p>
									<div class="ml-3">

										<label for="choice-true-{{ $q->question_no }}">
											<input type="radio" id="choice-true-{{ $q->question_no }}" value="True" name="question_{{ $q->question_no }}"> True
										</label>

										<p>
											<label for="choice-false-{{ $q->question_no }}">
												<input type="radio" id="choice-false-{{ $q->question_no }}" value="False" name="question_{{ $q->question_no }}"> False
											</label>
										</p>
									</div>
									<div class="form-group pr-3">
										<label for="true_or_false_correct_answer-{{ $q->question_no }}">Choose correct answer</label>
										<select id="true_or_false_correct_answer-{{ $q->question_no }}" class="form-control">
											<option {{ strtolower($q->question_no) === 'true' ? 'checked' : '' }} value="True">True</option>
											<option {{ strtolower($q->question_no) === 'false' ? 'checked' : '' }} value="False">False</option>
										</select>
									</div>
								</div>
							<br>
							@elseif($q->type == 'FITB')
								<div class="pl-4 pt-3 pb-3 bg-info text-white"  style="height : 25vh;">
									<div class="card-text p-1 text-white border border-white questions" contenteditable="true" data-question-type="{{ $q->type }}" data-question-index="{{ $q->question_no }}">{{ $q->question }}
									</div>
									<p></p>
									<div class="row">
											<div class="col-lg-auto ml-3 text-right pr-0">
												<label>Answer: &nbsp;</label>
											</div>
											<div class="col-lg-6">
												<input type="text" class="rounded-0 form-control" id="fill_in_answer-{{ $q->question_no }}" value="{{ $q->answer }}" name="question_{{$q->question_no}}">
											</div>
									</div>
									<p></p>
								</div>
							<br>
							@endif
						</div>
					@endforeach
					<div class="col-lg-12">
						<div id="dynamic-question-container"></div>	
					</div>
					
				</div>
				<div class="float-right">
					<input type="submit" class="btn btn-success rounded-0" id="btnSubmitFinalExam" value="Update">
				</div>
				<div class="clearfix"></div>
			</div>
		{{-- </form --}}
		</div>
	</div>
</div>
	@if($forceview == 1)
		<div class="card rounded-0">
			<div class="card-body">
				<hr>
					<div class="container-fluid py-2">
						<div class="row">
							<div class="col-md-4 text-left">
								@if($previous instanceof App\Activity)
									<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
									<br>
									<a href="{{ route('activity.view', $previous->id) }}" class="btn btn-link" title="{{$previous->title}}">◄ {{ $previous->activity_no }} {{ $previous->title }}</a>
								@elseif($previous instanceof App\File)
									<span class="text-dark mr-3">PREVIOUS ACTIVITY</span>
									<br>
									<a href="{{ route('course.overview.show.file', [$course->id, $previous->id]) }}" id="prev-activity-link" class="btn btn-link" title="{{ $previous->title }}">◄ {{ $previous->title }}</a>
								@endif
							</div>

							<div class="col-md-4 mt-2">
								<select id="jumpToOptions" class="form-control rounded-0 text-dark">
									<option selected disabled>Jump to...</option>
									
									@foreach($overview->files as $f)
										<option data-link="/admin/course/{{ $course->id }}/overview/show/{{ $f->id }}">{{ $f->title }}</option>
									@endforeach

									@foreach($modules as $module)
										@foreach($module->activities->where('completion', null) as $activity)
											<option data-link="/admin/activity/view/{{ $activity->id }}">{{ $activity->activity_no }} {{ $activity->title }}</option>
										@endforeach
									@endforeach 

									<option selected data-link="/admin/final/exam/{{ $module->exam->id }}">{{ $module->exam->title }}</option>

									@foreach($modules as $module)
										@foreach($module->activities->where('completion', 1) as $activity)
											<option data-link="/admin/activity/view/{{ $activity->id }}">{{ $activity->title }}</option>
										@endforeach
									@endforeach

								</select>
							</div>

							<div class="col-md-4 text-right">
								@if(!is_null($next) && $next instanceof App\Activity)
									<span class="text-dark mr-3">NEXT ACTIVITY</span>
									<br>
									<a href="{{ route('activity.view', $next->id) }}" class="btn btn-link" title="{{$next->title}}"> {{ $next->title }} ►</a>
								@endif
							</div>
						</div>
					</div>
			</div>
		</div>
	@endif
@push('page-scripts')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
</script>
<script>
	$('#sidebarToggle').trigger('click');

	$('#jumpToOptions').change(function (e) {
		let selectedItemLink = $(this).children("option:selected").attr('data-link');
		location.href = selectedItemLink;
	});
</script>

<script>
	let questionIndex = {{ $exam->questions->count() }};

	let pushValue = (e, question_index) => {
		let choiceValue = $(e).text();
		let option = new Option(`${choiceValue}`,`${choiceValue}`);
		$(`#multiple_correct_answer-${question_index}`).append(option);
	};

	function removeChoice(e) {
		let pointId = $(e).attr('data-point-to');
		$(`#choice-${pointId}`).remove();
		$(e).remove();
	}

	function generateChoice(question_index)	{
		// Count the number of choices in container 
		let noOfChoicesByQuestion = 1;
		$(`#dynamic-choice-${question_index}`).children().each(function (index, element) {
			if (typeof $(element).attr('id') != 'undefined' && $(element).attr('id').includes('choice')) {
				noOfChoicesByQuestion++;
			}			
		});
		let id = `${String.fromCharCode(64 + noOfChoicesByQuestion)}-${question_index}`;
		$(`#dynamic-choice-${question_index}`).append(`
			<div class="float-right">
				<button onclick="removeChoice(this)" class="btn btn-sm btn-danger rounded-0" data-point-to="${id}"><i class="fas fa-times" ></i> </button>
			</div>
			<div class="clearfix"></div>
			<div contenteditable="true" id="choice-${id}" class="border border-white p-2 ml-2 mb-2"  data-choice="${String.fromCharCode(64 + noOfChoicesByQuestion)}">${String.fromCharCode(64 + noOfChoicesByQuestion)}. </div> 
		`);
	}

	function submitChoices(question_index) {
		$(`#multiple_correct_answer-${question_index} option`).remove();
		$(`#dynamic-choice-${question_index}`).children().each(function (index, element) {
			if (typeof $(element).attr('id') != 'undefined' && $(element).attr('id').includes('choice')) {
				let choiceValue = $(element).text();
				let option = new Option(`${choiceValue}`, `${choiceValue}`);
				$(`#multiple_correct_answer-${question_index}`).append(option);		
			}
		});
	}

	

	$('#btnGenerateMultipleChoice').click(function () {
		$('#btnSubmitFinalExam').removeClass('d-none');
		questionIndex++;
		$('#dynamic-question-container').append(`
			<div class="card text-white bg-info rounded-0">
						<div class="card-body">
							<div class="card-text p-2 text-white border border-white mb-2 questions" contenteditable="true" data-question-type="MULTIPLE" data-question-index="${questionIndex}">${questionIndex}. (Click this label to enter question)</div>
							<div id="dynamic-choice-${questionIndex}"></div>
							<hr style="background :white;">
							<div class="form-inline">
								<button class="btn btn-sm btn-primary mr-3" onclick="generateChoice(${questionIndex})"><i class="fas fa-plus" data-question-index="${questionIndex}"></i> Add choices</button>
								<button class="btn btn-sm btn-success" onclick="submitChoices(${questionIndex})"><i class="fas fa-plus" data-question-index="${questionIndex}"></i> Submit Choices</button>
							</div>
							<hr style="background :white;">
							<label for="multiple_correct_answer-${questionIndex}">Select correct answer</label>
							<select id="multiple_correct_answer-${questionIndex}" class="form-control"></select>
						</div>
					</div>
		`);
	});

	$('#btnGenerateTrueOrFalse').click(function () {
		$('#btnSubmitFinalExam').removeClass('d-none');
		questionIndex++;
		$('#dynamic-question-container').append(`<div class="card text-white bg-info rounded-0">
						<div class="card-body">
							<div class="card-text p-1 text-white border border-white questions" contenteditable="true" data-question-type="TORF" data-question-index="${questionIndex}">${questionIndex}. (Click this label to enter question)</div>
							<br>
							<div id="dynamic-true-or-false-${questionIndex}">
								<div contenteditable="true" class="ml-2 p-2 text-white border border-white mb-2">
									True
								</div>

								<div contenteditable="true" class="ml-2 p-2 text-white border border-white mb-2">
									False
								</div>

								<hr style="background :white;">

								<label for="true_or_false_correct_answer-${questionIndex}">Select correct answer</label>
								<select id="true_or_false_correct_answer-${questionIndex}" class="form-control">
									<option value="True">True</option>
									<option value="False">False</option>
								</select>
							</div>
						</div>
					</div>`);
	});

	$('#btnGenerateFillInTheBlank').click(function () {
		$('#btnSubmitFinalExam').removeClass('d-none');
		questionIndex++;
		$('#dynamic-question-container').append(`<div class="card text-white bg-info rounded-0">
						<div class="card-body">
							<div class="card-text p-1 text-white questions" contenteditable="true" data-question-type="FITB" data-question-index=${questionIndex}>${questionIndex}. (Click this label to enter question)</div>
							<p></p>
							<div id="dynamic-fill-in-blank-${questionIndex}">
								<div class="form-group">
									<label>Correct Answer</label>
									<input type="text" class="form-control" id="fill_in_answer-${questionIndex}" placeholder="Please enter the correct answer here.">
								</div>
							</div>
						</div>
					</div>`);
	});

	$('#formExamination').submit(function (e) {
		e.preventDefault();
	});

	$('#btnSubmitFinalExam').click(function (e) {
		e.preventDefault();

		let multipleChoice = [];
		let fillIntheBlank = [];
		let trueOrFalse    = [];

		// Collect all questions.
		$('.questions').each(function (index, element) {
			
			let qIndex = $(element).attr('data-question-index');
			let qText = $(element).text();
			let qType = $(element).attr('data-question-type');
			let choices = [];


			if (qType === 'MULTIPLE') {
				choices = [];
				$(`#dynamic-choice-${qIndex}`).children().each(function (i, e) {
					
					if ($(e).attr('data-choice')) {
						let letterChoice = $(e).attr('data-choice');
						let value = $(e).text();
						choices.push(`${value.trim()}`);	
					}
					
				});
				
				multipleChoice.push({
					question_no : qIndex,
					question : qText,
					choices,
					correct_answer : $(`#multiple_correct_answer-${qIndex}`).val(),
				});

			} else if (qType === 'FITB') {
				fillIntheBlank.push({
					question_no : qIndex,
					question : qText,
					correct_answer : $(`#fill_in_answer-${qIndex}`).val(),
				});				
			} else {
				trueOrFalse.push({
					question_no : qIndex,
					question : qText,
					correct_answer  : $(`#true_or_false_correct_answer-${qIndex}`).val(),
				})
			}
	
		});


		$.ajax({
				url : '{{ route('module.final.exam.update', $exam->id) }}',
				method : 'PUT',
				data : { multipleChoice, fillIntheBlank, trueOrFalse },
				success : (response) => {
					if (response.success) {
						swal("Good job!", "Succesfully update final examination", "success");	
					}
				},
			})
		

	});
</script>
@endpush
@endsection