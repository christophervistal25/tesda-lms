@extends('layouts.student.app')
@section('title', '')
@section('content')
@prepend('page-css')
	<style>
		.border-right {
			border-left-width: 1px;
		}

		.label-background {
			background :#f0f0f0;
		}
	</style>
@endprepend
<div class="card rounded-0 mb-4">
	<div class="card-body">
		<h1 class="text-dark">{{ $course->name }}</h1>
	</div>
</div>
<div class="row">
	<div class="col-lg-9">
		<div class="card rounded-0 mb-4">
			<div class="card-body text-dark">
				<table class="table table-sm p-0">
					<tbody class="text-dark">
						<tr>
							<th class="text-right p-0 pr-1 border-right label-background" width="200px">Started on</th>
							<td class="p-0 pl-1">{{ Auth::user()->exam_attempt->first()->created_at->format('l d F Y, h:i A') }}</td>
						</tr>

						<tr>
							<th class="text-right p-0 pr-1 border-right label-background" width="200px">State</th>
							<td class="p-0 pl-1">Finished</td>
						</tr>

						<tr>
							<th class="text-right p-0 pr-1 border-right label-background" width="200px">Completed on</th>
							<td class="p-0 pl-1">{{ $questions[0]->result->created_at->format('l d F Y, h:i A') }}</td>
						</tr>

						<tr>
							<th class="text-right p-0 pr-1 border-right label-background" width="200px">Time Taken</th>
							<td class="p-0 pl-1">
								{{
									$questions[0]->result->created_at->diff(
										Auth::user()->exam_attempt->first()->created_at
									)->format('%H hours %i minutes %s seconds')
								}}
								</td>
						</tr>

						<tr>
							<th class="text-right p-0 pr-1 border-right label-background" width="200px">Marks</th>
							<td class="p-0 pl-1">
								{{ $marks }}.00 / {{ $questions->count() }}.00
							</td>
						</tr>

						<tr>
							<th class="text-right p-0 pr-1 border-right label-background" width="200px">Grade</th>
							<td class="p-0 pl-1">
								<strong>{{ number_format(( 100 / $questions->count() ) *  $marks , 2, '.', '') }}</strong>
								out of {{ config('student_progress.max_percentage') }}.00
							</td>
						</tr>

					</tbody>
				</table>
				<div class="row">
					@foreach($questions as $q)
						<div class="col-lg-1 mb-2 pl-1 pr-1" style="background :#dee2e6; height : 16vh; border : 1px solid #cad0d7;">
							<small>Question</small> <strong>{{ $q->question_no }}</strong>
							<small class="text-capitalize">{{ $q->result->status }}</small>
							<br>
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
											@if($q->result->answer == $c->choice)
												<p>
													<label for="choice-{{ $c->id }}">
														<input type="radio" checked id="choice-{{ $c->id }}"  value="{{ $c->choice }}"  name="question_{{ $q->question_no }}"> {{ $c->choice }}
													</label>
													@if($q->result->status === 'correct')
														<span class="text-success"><i class="fas fa-check"></i></span>
													@else
														<span class="text-danger"><i class="fas fa-times"></i></span>
													@endif
												</p>
											@else
												<p><label for="choice-{{ $c->id }}"><input type="radio" disabled id="choice-{{ $c->id }}"  value="{{ $c->choice }}" name="question_{{ $q->question_no }}"> {{ $c->choice }}</label></p>
											@endif
											@endforeach
										</div>
									@endif
								</div>
								<div class="card text-dark border-0 mt-2 rounded-0" style="background :#fcefdc;">
									<div class="card-body">
										@if($q->result->status === 'wrong')
											<p class="card-text">Your answer is {{ str_replace('wrong', 'incorrect', $q->result->status) }} 
												<br>
												correct answer : {{ $q->answer }}
											</p>
										@else
											<p class="card-text">Your answer is {{ $q->result->status }} 
													<br>
												{{ $q->result->answer }}
											</p>
										@endif
									</div>
								</div>
							<br>
							@elseif($q->type == 'TORF')
								<div class="pl-4 pt-3 pb-3" style="background:#def2f8; height : 25vh;">
									{{ preg_replace('/\d+\./', '', $q->question) }}
									<p></p>
									<p>Select one:</p>
									<div class="ml-3">
										@foreach(['true', 'false'] as $booleanChoice)
										<p>
											<label  class="text-capitalize"  for="choice-true-{{ $q->question_no }}">
												<input 
													type="radio"
													id="choice-true-{{ $q->question_no }}" 
													{{ strtolower($q->result->answer) === $booleanChoice ? 'checked' : 'disabled' }}
													value="{{ $booleanChoice }}" 
													name="question_{{ $q->question_no }}"> 
													{{ $booleanChoice }}
													@if(strtolower($q->result->answer) === $booleanChoice && $q->result->status == 'correct')
														<span class="text-success"><i class="fas fa-check"></i></span>
													@elseif(strtolower($q->result->answer) === $booleanChoice && $q->result->status == 'wrong')
														<span class="text-danger"><i class="fas fa-times"></i></span>
													@endif
											</label>
										</p>
										@endforeach
									</div>
								</div>
								<div class="card text-dark border-0 mt-2 rounded-0" style="background :#fcefdc;">
									<div class="card-body">
										@if($q->result->status === 'wrong')
											<p class="card-text">Your answer is {{ str_replace('wrong', 'incorrect', $q->result->status) }} 
												<br>
												correct answer : {{ $q->answer }}
											</p>
										@else
											<p class="card-text">Your answer is {{ $q->result->status }} 
													<br>
													{{ $q->result->answer }}
											</p>
										@endif
										
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
											<div class="col-lg-6 form-inline">
													<p>
														<input type="text" class="rounded-0 form-control" disabled value="{{ $q->result->answer }}" name="question_{{$q->question_no}}">
														@if($q->result->status === 'correct')
															<span class="text-success"><i class="fas fa-check"></i></span>
														@else
															<span class="text-danger"><i class="fas fa-times"></i></span>
														@endif
													</p>
											</div>
									</div>
									<p></p>
								</div>
								<div class="card text-dark border-0 mt-2 rounded-0" style="background :#fcefdc;">
									<div class="card-body">
										@if($q->result->status === 'wrong')
											<p class="card-text">Your answer is {{ str_replace('wrong', 'incorrect', $q->result->status) }} 
												<br>
												correct answer : {{ $q->answer }}
											</p>
										@else
											<p class="card-text">Your answer is {{ $q->result->status }} 
													<br>
													{{ $q->result->answer }}
											</p>
										@endif
										
									</div>
								</div>
							<br>
							@endif
						</div>
					@endforeach
				</div>
				{{-- <div class="pl-4 pr-4"></div> --}}
				<div class="float-right">
					<a href=" {{ route('view.final.exam', $module) }}">Finish review</a>
				</div>
				<div class="clearfix"></div>
			</div>
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
				@foreach($questions as $q)
						<a href="">{{ $q->question_no }}</a>
						@if($q->result->status == 'correct')
							<span class="text-success"><i class="fas fa-check"></i></span>
						@else
							<span class="text-danger"><i class="fas fa-times"></i></span>
						@endif | 
				@endforeach
				<br>
				<br>
				<a href=" {{ route('view.final.exam', $module) }}">Finish review</a>
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