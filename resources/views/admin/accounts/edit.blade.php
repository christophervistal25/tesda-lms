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
				<div class="alert alert-warning" role="alert">
					@if(Auth::user()->id === (int) $admin->id)
						* If you decided to change your<storng> password</strong> just fill in those fields.
						@else
						* If you decided to change <strong>{{ $admin->name }} password</strong> just fill in those fields.
					@endif
				</div>
				<hr>

				<form action="{{ route('admin.update', $admin->id) }}" method="POST">
					@csrf
					@method('PUT')
					<div class="form-group row text-dark">
						<label  class="col-lg-2 mt-2">Full name</label>
						<input type="text" name="name" class="form-control col-lg-6 rounded-0" value="{{ old('name') ?? $admin->name }}"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
					</div>
					<div class="form-group row text-dark">
						<label class="col-lg-2 mt-2">Email</label>
						<input type="email" name="email" value="{{ old('email') ?? $admin->email  }}" class="form-control col-lg-6 rounded-0"> <span class="ml-1 mt-2 font-weight-bold text-danger">*</span>
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
						<label class="col-lg-2">Status</label>
						<select name="status" class="form-control col-lg-6 rounded-0">
							@foreach($status as $s)
								<option value="{{ $s }}" {{ $admin->status == $s ? 'selected' : '' }}> {{ ucfirst($s) }}</option>
							@endforeach
						</select>
						<div class="col-lg-8 text-right">
							@if(Auth::user()->id === (int) $admin->id)
								<span class="text-danger">Changing your status to "In-Active" will automatically logout your account.</span>
							@endif	
						</div>
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