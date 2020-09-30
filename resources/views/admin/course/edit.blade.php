@extends('layouts.admin.app')
@section('title', 'Edit ' . $course->name)
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend

@if(Session::has('success'))
	<div class="card bg-success text-white shadow mb-2">
		<div class="card-body">
			{{ Session::get('success') }} <a class="font-weight-bold text-white" href=" {{ route('course.index') }}"> / <u>View records</u></a>
		</div>
	</div>
@endif

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Form for editing {{ $course->name }}</h6>
	</div>
	
	<div class="card-body">

		<form method="POST" action="{{ route('course.update', $course) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="email" class="col-md-auto  text-md-right">{{ __('Course name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') ?? $course->name }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                              <label>Course Design</label>
                              <textarea name="design" id="course_design" class="form-control @error('design') is-invalid @enderror">{{ old('design') ?? $course->design }}</textarea>
                              @error('design')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>


                            <div class="form-group row">
                            	<label for="description" class="col-md-auto  text-md-right">Course Description</label>
                            	<div class="col-md-12">
                            		<textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ old('description') ?? $course->description }}</textarea>
                            	</div>
                            </div>

                            <div class="form-group row">
                                <label for="email" class="col-md-auto  text-md-right">{{ __('Course Duration') }}</label>

                                <div class="col-md-12">
                                    <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') ?? $course->duration }}" required autocomplete="duration" autofocus>

                                    @error('duration')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                     

                             <div class="form-group">
                                <label for="" class="col-md-auto  text-md-right">Program</label>
                                <div class="col-md-12">
                                 <select class="form-control edit-selectpicker" data-live-search="true" name="program">
                                    @foreach($programs as $program)
                                      <option value="{{ $program->id }}" data-tokens="{{ $program->name }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="" class="col-md-auto  text-md-right">Pre-requisites</label>
                                <div class="col-md-12">
                                 <select class="form-control selectpicker" data-live-search="true" name="pre_requisites[]" multiple>
                                    @empty($courses)
                                      <option value="">N/A</option>
                                    @endempty
                                    @foreach($courses as $c)
                                    @if(in_array($c->id, $course->prerequisites->pluck('id')->toArray()))
                                        <option class='text-capitalize' selected value="{{ $c->id }}" data-tokens="{{ $c->name }}">{{ $c->name }}</option>
                                        @else
                                        <option class='text-capitalize' value="{{ $c->id }}" data-tokens="{{ $c->name }}">{{ $c->name }}</option>
                                      @endif
                                    @endforeach
                                </select>
                                </div>
                            </div>

                            <hr>
                            <span class="text-primary">You can easily add a instructor for this course (Leave N/A if you don't want to assign a instructor)</span>


                             <div class="form-group">
                                <label for="" class="col-md-auto  text-md-right">Instructors</label>
                                <div class="col-md-12">
                                 <select class="form-control selectpicker instructor-selectpicker text-capitalize" multiple data-live-search="true" name="instructor[]">
                                    @empty($instructors)
                                      <option value="">N/A</option>
                                    @endempty
                                    @foreach($instructors as $instructor)
                                      @if(in_array($instructor->id, $course->instructors->pluck('id')->toArray()))
                                        <option class='text-capitalize' selected value="{{ $instructor->id }}" data-tokens="{{ $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename }}">{{ $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename }}</option>
                                        @else
                                        <option class='text-capitalize'  value="{{ $instructor->id }}" data-tokens="{{ $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename }}">{{ $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename }}</option>
                                      @endif
                                    @endforeach
                                </select>
                                </div>
                            </div>




                            <div class="form-group mb-0">
                                <div class="float-right">
                                	<div class="col-md-auto">
	                                    <button type="submit" class="btn btn-primary">
	                                        {{ __('Update') }}
	                                    </button>
                                	</div>
                                </div>
                            </div>
                        </form>
	</div>
</div>
@push('page-scripts')
<!-- Latest compiled and minified JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
  <script src="//cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
  <script>
      CKEDITOR.replace( 'course_design' );
      // set the value of selectpicker to current value of course batch.
      $('.selectpicker').selectpicker('val', {{ $course->batch_id }});
      $('.edit-selectpicker').selectpicker('val', {{ $course->program_id }});
  </script>
@endpush
@endsection