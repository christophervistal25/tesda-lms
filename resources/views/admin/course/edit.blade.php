@extends('layouts.admin.app')
@section('title', 'Create new course')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend

@if(Session::has('success'))
	<div class="card bg-success text-white shadow mb-2">
		<div class="card-body">
			{{ Session::get('success') }} <a class="font-weight-bold text-white" href=" {{ route('course.index') }}"><u>View records</u></a>
		</div>
	</div>
@endif

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary">Form for creating new course</h6>
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

                            <div class="form-group row">
                            	<label for="description" class="col-md-auto  text-md-right">Course Description</label>
                            	<div class="col-md-12">
                            		<textarea name="description" class="form-control @error('description') is-invalid @enderror" id="description" cols="30" rows="10">{{ old('description') ?? $course->description }}</textarea>
                            	</div>
                            </div>

                     
							<div class="form-group">
								<label for="description" class="col-md-auto  text-md-right">Batch</label>
								<div class="col-md-12">
								 <select class="form-control selectpicker" width="100%" data-live-search="true" name="batch_no">
								  	@foreach($batchs as $batch)
								  	  <option value="{{ $batch->id }}" data-tokens="{{ $batch->name }}">{{ $batch->name }} / Batch {{ $batch->batch_no }}</option>
								  	@endforeach
								</select>
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
  <script>
      // set the value of selectpicker to current value of course batch.
      $('.selectpicker').selectpicker('val', {{ $course->batch_id }});
      $('.edit-selectpicker').selectpicker('val', {{ $course->program_id }});
  </script>
@endpush
@endsection