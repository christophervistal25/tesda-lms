@extends('layouts.admin.app')
@section('title', 'Edit Instructor')
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endprepend

@if(Session::has('success'))
	<div class="card bg-success text-white shadow mb-2">
		<div class="card-body">
			{{ Session::get('success') }} <a class="text-white" href=" {{ route('instructor.index') }}"> / <u>View records</u></a>
		</div>
	</div>
@endif

<div class="card shadow mb-4">
	<div class="card-header py-3">
		<h6 class="m-0 font-weight-bold text-primary text-capitalize">{{ $instructor->firstname . ' ' . $instructor->middlename . ' ' . $instructor->lastname}} Information</h6>
	</div>
	
	<div class="card-body">

		<form method="POST" action="{{ route('instructor.update', [ $instructor ]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="form-group row">
                                <label for="email" class="col-md-auto  text-md-right">{{ __('Firstname') }}</label>
 
                                <div class="col-md-12">
                                    <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror" name="firstname" value="{{ old('firstname') ?? $instructor->firstname }}" required autocomplete="firstname" autofocus>

                                    @error('firstname')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>


                            <div class="form-group row">
                                <label class="col-md-auto  text-md-right">{{ __('M.I') }} (Optinal)</label>

                                <div class="col-md-12">
                                    <input id="middlename" type="text" class="form-control @error('middlename') is-invalid @enderror" name="middlename" value="{{ old('middlename')  ?? $instructor->middlename }}"  autocomplete="middlename" autofocus>

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
                                    <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror" name="lastname" value="{{ old('lastname')  ?? $instructor->lastname }}" required autocomplete="lastname" autofocus>

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
                                    <input id="contact_no" type="text" class="form-control @error('contact_no') is-invalid @enderror" name="contact_no" value="{{ old('contact_no')  ?? $instructor->contact_no }}" required autocomplete="contact_no" autofocus>

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
    $('.selectpicker').selectpicker('val', {{ $instructor->courses->pluck('id') }});
  </script>
@endpush
@endsection