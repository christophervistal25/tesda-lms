@extends('layouts.admin.app')
@section('title', 'Create new course')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend

@if(Session::has('success'))
	<div class="card bg-primary text-white shadow mb-2">
		<div class="card-body">
			{{ Session::get('success') }} <a class="font-weight-bold text-white" href=" {{ route('course.index') }}"> / <u>View records</u></a>
		</div>
	</div>
@endif

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Course</h6>
	</div>
	
	<div class="card-body">

		<form method="POST" action="{{ route('course.store') }}"  enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-auto  text-md-right">{{ __('Course name') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-auto  text-md-right">{{ __('Course acronym') }}</label>

                                <div class="col-md-12">
                                    <input id="name" type="text" class="form-control @error('acronym') is-invalid @enderror" name="acronym" value="{{ old('acronym') }}" required autocomplete="acronym" autofocus>

                                    @error('acronym')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group">
                              <label>Course Design</label>
                              <textarea name="design" id="course_design" class="form-control @error('design') is-invalid @enderror">{{ old('design') }}</textarea>
                              @error('design')
                              <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                              </span>
                              @enderror
                            </div>

                            <div class="form-group row">
                            	<label for="description" class="col-md-auto  text-md-right">Course Description</label>
                            	<div class="col-md-12">
                            		<textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="3">{{ old('description') }}</textarea>
                            	</div>
                            </div>


                            <div class="form-group row">
                                <label for="email" class="col-md-auto  text-md-right">{{ __('Course Duration') }}</label>

                                <div class="col-md-12">
                                    <input id="duration" type="number" class="form-control @error('duration') is-invalid @enderror" name="duration" value="{{ old('duration') }}" required autocomplete="duration" autofocus>

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
                                 <select class="form-control selectpicker" data-live-search="true" name="program">
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
                                    @foreach($courses as $course)
                                      <option value="{{ $course->id }}" data-tokens="{{ $course->name }}">{{ $course->name }}</option>
                                    @endforeach
                                </select>
                                </div>
                            </div>

                           <div class="form-group row pr-3 pl-3">
                            <label>Course Image</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image">
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                              </div>    
                          </div>

                            <hr>
                            <span class="text-primary">You can easily add a instructor for this course (Leave N/A if you don't want to assign a instructor)</span>


                             <div class="form-group">
                                <label for="" class="col-md-auto  text-md-right">Instructors</label>
                                <div class="col-md-12">
                                 <select class="form-control selectpicker" data-live-search="true" name="instructor">
                                    @empty($instructors)
                                      <option value="">N/A</option>
                                    @endempty
                                    @foreach($instructors as $instructor)
                                      <option class="text-capitalize" value="{{ $instructor->id }}" data-tokens="{{ $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename }}">{{ $instructor->lastname . ', ' . $instructor->firstname . ' ' . $instructor->middlename }}</option>

                                    @endforeach
                                </select>
                                </div>
                            </div>


                            <div class="form-group mb-0">
                                <div class="float-right">
                                	<div class="col-md-auto">
	                                    <button type="submit" class="btn btn-primary">
	                                        {{ __('Create') }}
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
  <script>CKEDITOR.replace( 'course_design' );</script>
@endpush
@endsection