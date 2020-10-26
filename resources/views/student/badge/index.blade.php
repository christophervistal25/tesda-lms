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
					<th>Name</th>
					<th>Description</th>
					<th>Image</th>
					<th>Criteria</th>
					<th>Date Issued</th>
				</tr>
			</thead>
			<tbody>
				@foreach($course->badge as $badge)
					<tr class="text-dark">
						<td class="align-middle">{{ $badge->name }}</td>
						<td class="align-middle">{{ $badge->description }}</td>
						<td class="text-center align-middle">
							<img src="{{ asset('badges/' . $badge->image) }}" alt="Badge Image" width="50px">
						</td>
						<td>
							<ul>
								@foreach($badge->modules as $module)
									@if($module->is_overview == 1)
										@foreach($module->files as $file)
											<li>{{ $file->title }}</li>
										@endforeach
									@endif
								@endforeach

								@foreach($badge->modules as $module)
									@if($module->is_overview == 0)
										@foreach($module->activities as $activity)
											<li>{{ $activity->title }}</li>
										@endforeach
									@endif
								@endforeach

								@foreach($badge->files as $file)
										<li>{{ $file->title }}</li>
								@endforeach

								@foreach($badge->activities as $activity)
										<li>{{ $activity->title }}</li>
								@endforeach

							</ul>
						</td>
						<td></td>
					</tr>
				@endforeach
			</tbody>
		</table>
		
	</div>
</div>
@endsection