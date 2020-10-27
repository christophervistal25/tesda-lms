@extends('layouts.student.app')
@section('title', '')
@section('content')
<div class="card shadow mb-4 rounded-0">
	<div class="card-header py-3">
		<h6 class="m-0 text-primary">{{ $course->name }} Badge</h6>
	</div>
	<div class="card-body">
		<table class="table table-bordered">
			<thead>
				<tr class="text-dark">
					<th>Image</th>
					<th>Name</th>
					<th>Description</th>
					<th>Criteria</th>
					<th>Accomplish</th>
				</tr>
			</thead>
			<tbody>
				@forelse($course->badge as $badge)
					<tr class="text-dark">
						<td class="text-center align-middle">
							<img src="{{ asset('badges/' . $badge->image) }}" alt="Badge Image" width="100px">
						</td>
						<td class="align-middle">{{ $badge->name }}</td>
						<td class="align-middle">{{ $badge->description }}</td>
						<td class="text-truncate">
							Users are awarded this badge when they complete the following 
							<br>
							requirement:
							<br>
							All of the following activities are completed :
							<ul>
								@foreach($badge->modules as $module)
									@if($module->is_overview == 1)
										@foreach($module->files as $file)
											<li><span class="text-capitalize">{{ $file->type }}</span>  - {{ pathinfo($file->title, PATHINFO_FILENAME) }}</li>
										@endforeach
									@endif
								@endforeach

								@foreach($badge->modules as $module)
									@if($module->is_overview == 0)
										@foreach($module->activities as $activity)
										<li ><span class="text-capitalize">{{ $activity->downloadable ? 'File' : 'Page' }}</span>  - {{ $activity->title }}</li>
										@endforeach
									@endif
								@endforeach

								@foreach($badge->files as $file)
									<li ><span class="text-capitalize">{{ $file->type }}</span>  - {{ pathinfo($file->title, PATHINFO_FILENAME) }}</li>
								@endforeach

								@foreach($badge->activities as $activity)
									<li ><span class="text-capitalize">{{ $activity->downloadable ? 'File' : 'Page' }}</span>  - {{ $activity->title }}</li>
								@endforeach

							</ul>
						</td>
						<td class="text-center align-middle">
							@if(in_array('BADGE_' . $badge->id, $userBadges))
								<i class="icon fa fa-check text-success fa-fw"></i>
							@endif
						</td>
					</tr>
					@empty
					<div class="container-fluid">
		                  <div class="text-center">
		                    <tr>
		                    	<td colspan="5" class="text-center">
		                    		<img class="mb-3" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">		
		                    		<br>
		                    		<span class="text-danger">No available badge for {{ $course->name }}</span>
		                    	</td>
		                    </tr>
		                  </div>
		          	</div>
				@endforelse
			</tbody>
		</table>
		
	</div>
</div>
@endsection