@extends('layouts.admin.app')
@section('title', 'Create Final Exam for ' . $module->title)
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
<div class="card shadow mb-4 rounded-0">
	<div class="card-header py-3 bg-info text-white rounded-0">
		<p class="card-text">In multiple choice and true or false select the correct answer before hitting submit button</p>
	</div>
	
	<div class="card-body rounded-0">
		<form method="POST" id="formExamination">
			@csrf
			<div class="row">
				<div class="col-lg-3">
					<div class="card rounded-0 text-center">
						<ul class="list-group list-group-flush">
							<li class="item-generator list-group-item rounded-0 cursor-pointer" id="btnGenerateMultipleChoice">Multiple Choice</li>
							<li class="item-generator list-group-item rounded-0 cursor-pointer" id="btnGenerateTrueOrFalse">True or False</li>
							<li class="item-generator list-group-item rounded-0 cursor-pointer" id="btnGenerateFillInTheBlank">Fill in the blank</li>
						</ul>
					</div>
				</div>
				<div class="col-lg-9">
					<div class="alert alert-danger rounded-0 d-none" role="alert" id="form-message-error"></div>
					<div id="dynamic-question-container">
						
					</div>
				</div>
			</div>
			<br>
			<div class="float-right">
				<input type="submit" class="btn btn-primary d-none" value="Create examination" id="btnSubmitFinalExam">
			</div>
			<div class="clearfix"></div>
		</form>
	</div>
</div>
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
	let questionIndex = 0;

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
		$('#dynamic-question-container').append(`<div class="card text-white bg-info rounded-0">
						<div class="card-body">
							${questionIndex}. <div class="card-text p-2 text-white border border-white mb-2 questions multiple-question" contenteditable="true" data-question-type="MULTIPLE" data-question-index="${questionIndex}"></div>
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
					</div>`);
	});

	$('#btnGenerateTrueOrFalse').click(function () {
		$('#btnSubmitFinalExam').removeClass('d-none');
		questionIndex++;
		$('#dynamic-question-container').append(`<div class="card text-white bg-info rounded-0">
						<div class="card-body">
							${questionIndex}.<div class="card-text p-1 text-white border border-white questions true-or-false-question" contenteditable="true" data-question-type="TORF" data-question-index="${questionIndex}"></div>
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
						${questionIndex}.
							<div class="card-text p-1 text-white questions border border-white fill-in-the-blank-question" contenteditable="true" data-question-type="FITB" data-question-index=${questionIndex}></div>
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
	
	function elementError(data) {
		if (typeof data.errors[`${data.group}.${data.index}.${data.type}`] != 'undefined') {
			return `<li>(${data.text}) - Question ${data.question_no} ${data.errors[`${data.group}.${data.index}.${data.type}`]}</li>`
		} 
	}

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


			if (qType === 'MULTIPLE') {
				let choices = [];

				$(`#dynamic-choice-${qIndex}`).children().each(function (i, e) {
					if ($(e).attr('data-choice')) {
						let letterChoice = $(e).attr('data-choice');
						let value = $(e).text();
						choices.push(`${letterChoice}-${value.trim()}`);	
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
				url : '{{ route('module.final.exam.submit', $module->id) }}',
				method : 'POST',
				data : { multipleChoice, fillIntheBlank, trueOrFalse },
				success : (response) => {
					if (response.success) {
						$('#form-message-error').addClass('d-none');
						swal("Good job!", "Succesfully add final examination", "success");	
					}
				},
				error : (response) => {
					
					if (response.status === 422) {
						// navigate to top
						$('.scroll-to-top').trigger('click');
						// show the form message container
						$('#form-message-error').removeClass('d-none');
						// clean previous content.
						$('#form-message-error').html('');

						// form errors
						let errors = response.responseJSON.errors;

						// Check error for each multiple choice question
						$('.multiple-question').each(function (index, element) {
							var questionNo = $(this).attr('data-question-index');
					
							questionError = elementError({
								question_no : questionNo,
								errors : errors,
								group : 'multipleChoice',
								index : index,
								type : 'question',
								text : 'Multiple Choice',
							});


							questionCorrectAnswerError = elementError({
								question_no : questionNo,
								errors : errors,
								group : 'multipleChoice',
								index : index,
								type : 'correct_answer',
								text : 'Multiple Choice',
							})

							questionChoicesError =  elementError({
								question_no : questionNo,
								errors : errors,
								group : 'multipleChoice',
								index : index,
								type : 'choices',
								text : 'Multiple Choice',
							});

							$('#form-message-error').prepend(questionError);
							$('#form-message-error').prepend(questionChoicesError);
							$('#form-message-error').prepend(questionCorrectAnswerError);
							
						});

						// Check error for each true or false question
						$('.true-or-false-question').each(function (index, element) {
							var questionNo = $(this).attr('data-question-index');
					
							questionError = elementError({
								question_no : questionNo,
								errors : errors,
								group : 'trueOrFalse',
								index : index,
								type : 'question',
								text : 'True or False',
							});


							$('#form-message-error').prepend(questionError);
						});
	            		
	            		// Check error for each fill in the blank question
	            		$('.fill-in-the-blank-question').each(function (index, element) {
	            			console.log(element);
	            			var questionNo = $(this).attr('data-question-index');
					
							questionError = elementError({
								question_no : questionNo,
								errors : errors,
								group : 'fillIntheBlank',
								index : index,
								type : 'question',
								text : 'Fill in the blank',
							});

							questionCorrectAnswerError = elementError({
								question_no : questionNo,
								errors : errors,
								group : 'fillIntheBlank',
								index : index,
								type : 'correct_answer',
								text : 'Fill in the blank',
							});


							$('#form-message-error').prepend(questionError);
							$('#form-message-error').prepend(questionCorrectAnswerError);
	            		});
					}
				}
			});
	});
</script>
@endpush
@endsection
