<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="csrf-token" content="{{ csrf_token() }}" >
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css" integrity="sha512-xA6Hp6oezhjd6LiLZynuukm80f8BoZ3OpcEYaqKoCV3HKQDrYjDE1Gu8ocxgxoXmwmSzM4iqPvCsOkQNiu41GA==" crossorigin="anonymous" />

  	<link href="https://fonts.googleapis.com/css?family=Poppins" rel="stylesheet">

  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/startbootstrap-sb-admin-2/4.0.7/css/sb-admin-2.min.css" integrity="		sha512-FXgL8f6gtCYx8PjODtilf5GCHlgTDdIVZKRcUT/smwfum7hr4M1ytewqTtNd9LK4/CzbW4czU6Tr3f3Xey6lRg==" crossorigin="anonymous" />
</head>
<body>

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
<div class="card text-white bg-warning rounded-0 mb-2">
	<div class="card-body">
		<p class="card-text">In multiple choice and true or false select the correct answer before hitting submit button</p>
	</div>
</div>
<div class="card  mb-4">
	<!-- Card Header - Dropdown -->
	<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
		<h6 class="m-0 font-weight-bold text-primary">Final Examination</h6>
	</div>
	<!-- Card Body -->
	<div class="card-body">
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

 <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <!-- Bootstrap core JavaScript-->
<script>
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
</script>

<script>
	let questionIndex = 0;

	let pushValue = (e, noOfChoicesByQuestion, question_index) => {
		let choiceValue = $(e).text();
		let option = new Option(`${choiceValue}`,`${choiceValue}`);
		$(`#multiple_correct_answer-${question_index}`).append(option);
	};


	function generateChoice(question_index)	{
		// Count the number of choices in container 
		let noOfChoicesByQuestion = $(`#dynamic-choice-${question_index}`).children().length + 1;

		$(`#dynamic-choice-${question_index}`).append(`
			<div contenteditable="true" id="choice-${String.fromCharCode(64 + noOfChoicesByQuestion)}-${question_index}" class="border border-white p-2 ml-2 mb-2" onfocusout="pushValue(this, ${noOfChoicesByQuestion}, ${question_index})" data-choice="${String.fromCharCode(64 + noOfChoicesByQuestion)}">${String.fromCharCode(64 + noOfChoicesByQuestion)}. Answer here ${noOfChoicesByQuestion}</div>
		`);


	}

	

	$('#btnGenerateMultipleChoice').click(function () {
		$('#btnSubmitFinalExam').removeClass('d-none');
		questionIndex++;
		$('#dynamic-question-container').append(`<div class="card text-white bg-info rounded-0">
						<div class="card-body">
							<div class="card-text p-2 text-white border border-white mb-2 questions" contenteditable="true" data-question-type="MULTIPLE" data-question-index="${questionIndex}">${questionIndex}. (Click this label to enter question)</div>
							<div id="dynamic-choice-${questionIndex}"></div>
							<hr style="background :white;">
							<button class="btn btn-sm btn-primary" onclick="generateChoice(${questionIndex})"><i class="fas fa-plus" data-question-index="${questionIndex}"></i> Add choices</button>
							<br>
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


			if (qType === 'MULTIPLE') {
				let choices = [];

				$(`#dynamic-choice-${qIndex}`).children().each(function (i, e) {
					let letterChoice = $(e).attr('data-choice');
					let value = $(e).text();
					choices.push(`${letterChoice}-${value.trim()}`);
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
						swal("Good job!", "Succesfully add final examination", "success");	
					}
				},
			})
	});
</script>

</body>
</html>