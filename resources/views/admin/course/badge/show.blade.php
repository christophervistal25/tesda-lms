@extends('layouts.admin.app')
@section('title', 'Badges of ' . $course->name)
@section('content')
@prepend('page-css')
<style>
  ul.timeline {
    list-style-type: none;
    position: relative;
}
ul.timeline:before {
    content: ' ';
    background: #d4d9df;
    display: inline-block;
    position: absolute;
    left: 29px;
    width: 2px;
    height: 100%;
    z-index: 400;
}
ul.timeline > li {
    margin: 20px 0;
    padding-left: 20px;
}
ul.timeline > li:before {
    content: ' ';
    background: white;
    display: inline-block;
    position: absolute;
    border-radius: 50%;
    border: 3px solid #22c0e8;
    left: 20px;
    width: 20px;
    height: 20px;
    z-index: 400;
}
</style>
@endprepend
  {{ Breadcrumbs::render('course-badges', $course) }}

<div class="card  mb-4 rounded-0">
  <div class="card-header py-3">
    <h6 class="m-0 text-primary">Badges of {{ $course->name }}</h6>
  </div>

  <div class="card-body">
      <div class="row">
          @forelse($course->badge as $badge)
            <div class="col-md-12 border p-2 mb-2">
              <img src="{{ asset('/badges/' . $badge->image) }}" width="50px" alt="{{ $badge->name }} icon">
              <span class="text-dark">{{ $badge->name }}</span>
              <h4 class="text-dark mt-3">Criteria</h4>
              <ul class="timeline">
                @forelse($badge->modules->where('is_overview', 1) as $module)
                  @foreach($module->files as $file)
                      <li>
                      <a target="_blank" href="{{ str_replace('/student', '/admin', $file->link) }}">
                        <img src="{{ $file->icon }}" alt="file icon" width="24px">
                        {{ pathinfo($file->title, PATHINFO_FILENAME) }}
                      </a>
                      <span class="badge badge-primary float-right">{{ $file->created_at->format('l, j  F Y, h:i A') }}</span>
                    </li>
                  @endforeach
                  @empty
                @endforelse

                 @forelse($badge->files as $file)
                  <li>
                      <a target="_blank" href="{{ str_replace('/student', '/admin', $file->link) }}">
                        <img src="{{ $file->icon }}" alt="activity icon" width="24px">
                        {{ $file->title }}
                      </a>
                      <span class="badge badge-primary float-right">{{ $file->created_at->format('l, j  F Y, h:i A') }}</span>
                  </li>
                  @empty
                @endforelse

                @forelse($badge->modules->where('is_overview', 0) as $module)
                  @foreach($module->activities as $activity)
                      <li>
                      <a target="_blank" href="{{ route('activity.view', $activity->id) }}">
                        <img src="{{ $activity->icon }}" alt="activity icon" width="24px">
                        {{ $activity->title }}
                      </a>
                      <span class="badge badge-primary float-right">{{ $activity->created_at->format('l, j  F Y, h:i A') }}</span>
                    </li>
                  @endforeach
                  @empty
                @endforelse

                @forelse($badge->activities as $activity)
                  <li>
                      <a target="_blank" href="{{ route('activity.view', $activity->id) }}">
                        <img src="{{ $activity->icon }}" alt="activity icon" width="24px">
                        {{ $activity->title }}
                      </a>
                      <span class="badge badge-primary float-right">{{ $activity->created_at->format('l, j  F Y, h:i A') }}</span>
                  </li>
                  @empty
                @endforelse
              </ul>

              <div class="float-right">
                <a href="{{ route('badge.course.edit', [$course, $badge]) }}" class="btn btn-success btn-sm">Modify Criteria</a>
              </div>
              <div class="clearfix"></div>
            </div>
          @empty
          <div class="container-fluid">
                  <div class="text-center">
                    <img class="mb-3" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806532/no-courses_rrzfqi.png" alt="">
                    <br>
                    <span class="text-danger">No available badge for {{ $course->name }}</span>
                  </div>
          </div>
          @endforelse
      </div>
  </div>
</div>
@push('page-scripts')
@endpush
@endsection