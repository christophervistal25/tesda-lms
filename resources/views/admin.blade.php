@extends('layouts.admin.app')
@prepend('meta-data')
  <meta name="chart-value" content="{{ json_encode($registered) }}">
  <meta name="days" content="{{ json_encode($days) }}">
  <meta name="weeks" content="{{ json_encode($weeks) }}">
  <meta name="type" content="{{ $type }}">
@endprepend
@prepend('page-css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css" integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w==" crossorigin="anonymous" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
@endprepend
@section('title', 'Dashboard')
@section('content')
{{ Breadcrumbs::render('dashboard') }}

<div class="row">
	<div class="col-xl-3 col-md-6 mb-4">
		<a href="{{ route('student.index') }}" class="text-decoration-none">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1"># of Students</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $students }}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-book-reader fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>  
    </a>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<a href="{{ route('course.index') }}" class="text-decoration-none">
    <div class="card border-left-success shadow h-100 py-2">
      <div class="card-body">
        <div class="row no-gutters align-items-center">
          <div class="col mr-2">
            <div class="text-xs font-weight-bold text-success text-uppercase mb-1"># of Course </div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $course }}</div>
          </div>
          <div class="col-auto">
            <i class="fas fa-book-reader fa-2x text-gray-300"></i>
          </div>
        </div>
      </div>
    </div>  
    </a>
	</div>
	<!-- Earnings (Monthly) Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-info shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-info text-uppercase mb-1"># of Modules</div>
						<div class="row no-gutters align-items-center">
							<div class="col-auto">
								<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $modules }}</div>
							</div>
						</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Pending Requests Card Example -->
	<div class="col-xl-3 col-md-6 mb-4">
		<div class="card border-left-warning shadow h-100 py-2">
			<div class="card-body">
				<div class="row no-gutters align-items-center">
					<div class="col mr-2">
						<div class="text-xs font-weight-bold text-warning text-uppercase mb-1"># of Activities</div>
						<div class="h5 mb-0 font-weight-bold text-gray-800">{{ $activities }}</div>
					</div>
					<div class="col-auto">
						<i class="fas fa-comments fa-2x text-gray-300"></i>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Content Row -->
<div class="row">
    <div class="col-lg-12 mb-2">
      <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h6 class="m-0 font-weight-bold text-dark">Administrator Accounts</h6>
      </div>
      <div class="card-body text-dark">
        <div class="float-right">
          <a href="{{ route('create.new.admin') }}" class="btn btn-primary mb-2">Register new admin</a>
        </div>
        <div class="clearfix"></div>
        {{-- administrator list --}}
        <table class="table table-bordered" id="admin-table">
          <thead>
            <tr class="text-dark">
              <th>Name</th>
              <th>Email</th>
              <td>Status</td>
              <th>Registered At</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
              @foreach($admins as $admin)
                <tr class="{{ $admins->count() != 1 && Auth::user()->id === (int) $admin->id ? 'bg-info text-white' : 'text-dark' }}">
                    <td class="align-middle">{{ $admin->name }}</td>
                    <td class="align-middle">{{ $admin->email }}</td>
                    <td class="align-middle text-center">
                      @if($admin->status === 'active')
                        <span class="badge badge-pill badge-primary">Active</span>
                        @else
                        <span class="badge badge-pill badge-danger">In-Active</span>
                      @endif
                    </td>
                    <td class="align-middle">{{ $admin->created_at->diffForHumans() }}</td>
                    <td class="text-center"><a href="{{ route('admin.edit', $admin->id) }}" class="btn {{ $admins->count() != 1 && Auth::user()->id === (int) $admin->id ? 'btn-primary' : 'btn-success' }} text-white">Edit</a></td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
	<!-- Area Chart -->
	<div class="col-xl-12 col-lg-12">

    <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                  <select id="chart-type" class="form-control rounded-0 ">
                      <option {{ $type == 'monthly' ? 'selected' : '' }} value="monthly">Monthly Registered Students</option>
                      <option {{ $type == 'weekly' ? 'selected' : '' }} value="weekly">Weekly Registered Students</option>
                      <option {{ $type == 'daily' ? 'selected' : '' }} value="daily">Daily Registered Students</option>
                  </select>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                   <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                  </div>
                </div>
              </div>
	</div>
</div>
@push('page-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js" integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA==" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="{{ asset('js/dashboard.min.js') }}"></script>
@endpush
@endsection