@extends('layouts.admin.app')
@section('title', '')
@section('content')
@if(Session::has('success'))
	<div class="alert alert-primary" role="alert">
		{{ Session::get('success') }}
	</div>
	@else
	@include('layouts.admin.error')
@endif
<div class="card rounded-0 mb-4">
	
	<div class="card-body">
		<div class="row">
			<div class="col-lg-12">
				<form action="{{ route('submit.new.admin') }}" method="POST">
					@csrf
					<div class="form-group row text-dark">
						<label  class="col-lg-2 mt-2">Full name</label>
						<input type="text" name="name" class="form-control col-lg-6 rounded-0" value="{{ old('name') }}"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Email</label>
						<input type="email" name="email" value="{{ old('email')  }}" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Password</label>
						<input type="password" name="password" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2">Confirm Password</label>
						<input type="password" name="password_confirmation" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row">
						<div class="col-lg-8 text-right">
							<button type="submit" class="btn btn-primary col-lg-2 rounded-0">Create</button>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@push('page-scripts')
@endpush
@endsection