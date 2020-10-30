@extends('layouts.admin.app')
@section('title', '')
@section('content')
@if(Session::has('success'))
	<div class="alert alert-success" role="alert">
		{{ Session::get('success') }}
	</div>
	@else
	@include('layouts.admin.error')
@endif
<div class="card rounded-0 mb-4">
	
	<div class="card-body">
		<div class="alert alert-info" role="alert">
			If you want to change student <strong>password</strong> just fill in those fields, same with <strong>image/profile</strong>.
		</div>
		<div class="row">
			<div class="col-lg-12">
				<form action="{{ route('student.update', $student->id) }}" method="POST" enctype="multipart/form-data">
					@csrf
					@method('PUT')
					<div class="form-group row text-dark">
						<label  class="col-lg-2 mt-2">Firstname</label>
						<input type="text" name="firstname" class="form-control col-lg-6 rounded-0" value="{{ old('firstname') ?? $student->firstname }}"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Surname</label>
						<input type="text" name="surname" value="{{ old('surname') ?? $student->surname }}" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Username</label>
						<input type="text" name="username" value="{{ old('username') ?? $student->username }}" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Email</label>
						<input type="email" name="email" value="{{ old('email') ?? $student->email }}" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">City/Town</label>
						<input type="text" name="city_town" value="{{ old('city_town') ?? $student->city_town }}" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Password</label>
						<input type="password" name="password" class="form-control col-lg-6 rounded-0">
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2">Confirm Password</label>
						<input type="password" name="password_confirmation" class="form-control col-lg-6 rounded-0">
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Profile</label>
						<input type="file" name="profile" class="form-control col-lg-6 rounded-0">
					</div>
					<div class="form-group row">
						<div class="col-lg-8 text-right">
							<button type="submit" class="btn btn-success col-lg-2 rounded-0">Update</button>
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