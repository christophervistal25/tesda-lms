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
			<form action="{{ route('answer.final.exam.submit', $module) }}" method="POST">
				@csrf
			<div class="card-body text-dark">
				<div class="row">
					@foreach($exam as $q)
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
												<p><label for="choice-{{ $c->id }}"><input type="radio" id="choice-{{ $c->id }}"  value="{{ $c->choice }}" name="question_{{ $q->question_no }}"> {{ $c->choice }}</label></p>
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
				{{-- <div class="pl-4 pr-4"></div> --}}
				<div class="float-right">
					<input type="submit" class="btn btn-primary rounded-0" value="Finish attempt...">
				</div>
				<div class="clearfix"></div>
			</div>
		</form>
		</div>
	</div>

	<div class="col-lg-3">
		<div class="card rounded-0">
			<div class="card-body text-dark">
				<h5 class="card-title">Quiz Navigation</h5>
				<h3 class="card-text">Final Exam</h3>
				@foreach(range(1, $exam->count()) as $item)
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
</script>
<script>
	$('#jumpToOptions').change(function (e) {
		let selectedItemLink = $(this).children("option:selected").attr('data-link');
		location.href = selectedItemLink;
	});
</script>
@endpush
@endsection