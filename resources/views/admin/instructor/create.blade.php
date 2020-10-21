@extends('layouts.admin.app')
@section('title', 'Add new instructor')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend

@if(Session::has('success'))
	<div class="card bg-primary text-white shadow mb-2">
		<div class="card-body">
			{{ Session::get('success') }} <a class="text-white" href=" {{ route('instructor.index') }}"> / <u>View records</u></a>
		</div>
	</div>
@endif


<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Instructor Information</h6>
	</div>
	
	<div class="card-body">

		<form method="POST" action="{{ route('instructor.store') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="form-group row">
                                <label for="email" class="col-md-auto  text-md-right">{{ __('Firstname') }}</label>

                                <div class="col-md-12">
                                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-auto  text-md-right">{{ __('Middlename') }} (Optinal)</label>

                                <div class="col-md-12">
                                    <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename') }}"  autocomplete="middlename" autofocus>

                                    @error('middlename')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-auto  text-md-right">{{ __('Lastname') }}</label>

                                <div class="col-md-12">
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                                    @error('lastname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-auto  text-md-right">{{ __('Contact No.') }}</label>

                                <div class="col-md-12">
                                    <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no') }}" required autocomplete="contact_no" autofocus>

                                    @error('contact_no')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                          <div class="form-group row pr-3 pl-3">
                            <label>Image (Optional)</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="image">
                                <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                              </div>    
                          </div>

                    <hr>

                          <span class="text-primary font-weight-bold">Select an course if you want to assign this instructor. (leave blank if not)</span>

                            <div class="form-group row">
                                <label for="" class="col-md-auto  text-md-right">Course</label>
                                <div class="col-md-12">
                                 <select class="form-control selectpicker" data-live-search="true" name="course">
                                    <option value="">N/A</option>
                                    @foreach($courses as $course)
                                      <option value="{{ $course->id }}" data-tokens="{{ $course->name }}">{{ $course->program->batch->name }} Batch / {{ $course->program->name }} / {{ $course->program->batch->batch_no}} {{ $course->name }}</option>
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
@endpush
@endsection