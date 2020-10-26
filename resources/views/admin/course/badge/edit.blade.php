@extends('layouts.admin.app')
@section('title', 'Edit Badge ' . $course->name)
@section('content')
@prepend('meta-data')
<meta name="criterias" content="{{ $criterias->toJson() }}">
@endprepend
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.css">
@endprepend
@if(Session::has('success'))
<div class="card bg-success text-white shadow mb-2">
  <div class="card-body">
    {{ Session::get('success') }}
  </div>
</div>
@endif
@include('layouts.admin.error')
<div class="card shadow mb-4">
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary">Add badge for {{ $course->name }}</h6>
  </div>
  
  <div class="card-body">
    <form method="POST" action="{{ route('badge.course.update', [$course->id, $badge->id]) }}" enctype="multipart/form-data">
       @csrf
       @method('PUT')
       <div class="form-group row">
        <div class="col-md-6">
        <label for="badge_name" class="text-dark">{{ __('Badge Name') }}</label>
          <input id="badge_name" type="text" class="form-control @error('badge_name') is-invalid @enderror" name="badge_name" value="{{ old('badge_name') ?? $badge->name }}" required autocomplete="course" autofocus >
          @error('badge_name')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
        <div class="col-md-1 text-center">
          <div class="mt-4 ml-5 pl-4">
            <img src="{{ asset('badges/' . $badge->image) }}" width="50px" alt="">
          </div>
        </div>
        <div class="col-md-5">
          <label class="text-dark">Badge Image <span class="text-primary">(Optional)</span></label>
          <div class="custom-file">
              <input type="file" class="custom-file-input" name="badge_image">
              <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
          </div>    
          @error('badge_image')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="col-md-12 mt-3">
          <label for="badge_description" class="text-dark">Badge Description</label>
          <textarea id="badge_description" name="badge_description" cols="30" rows="3" class="form-control">{{ old('badge_description') ?? $badge->description }}</textarea>
        </div>

        <div class="col-md-12 mt-3">
          <label for="selected_criteria" class="text-dark">Selected Criteria</label>
          <div id="selected_criteria" class="border p-2" style="height : 15vh;">
            
            @if(old('selected_criteria'))
              @else
                  @foreach($badge->modules as $module)
                    @if($module->is_overview == 1)
                        <span class="ml-2 badge badge-primary" data-related-to="overview-{{ $module->id }}" id="overview-{{ $module->id }}">{{ $module->title }}</span>
                      @else
                        <span class="ml-2 badge badge-primary" data-related-to="module-{{ $module->id }}" id="module-{{ $module->id }}">{{ $module->title }}</span>
                    @endif
                  @endforeach

                  @foreach($badge->activities as $activity)
                        <span class="ml-2 badge badge-primary" data-child-of="module-{{ $activity->module_id }}" id="activity-{{ $activity->id }}">{{ $activity->title }}</span>
                  @endforeach

                  @foreach($badge->files as $file)
                        <span class="ml-2 badge badge-primary" data-child-of="module-{{ $file->filelable->id }}" id="file-{{ $file->id }}">{{ $file->title }}</span>
                  @endforeach

              @endif
                
   
          </div>
        </div>

        <input type="hidden" value="{{ $criterias->isEmpty() ? null : $criterias->toJson() }}" name="criteria" id="criterias" class="form-control">

      </div>
      <hr>
      <label class="text-dark">Select Criteria</label>
      <nav>
        <div class="nav nav-tabs mb-3" role="tablist">
          <a class="nav-item nav-link active rounded-0" id="activities-tab" data-toggle="tab" href="#nav-activites" role="tab" aria-controls="nav-activites" aria-selected="true">Activities</a>
          <a class="nav-item nav-link rounded-0" id="nav-modules-tab" data-toggle="tab" href="#nav-modules" role="tab" aria-controls="nav-modules" aria-selected="false">Modules</a>
        </div>
      </nav>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="nav-activites" role="tabpanel" aria-labelledby="activities-tab">
          <table class="table table-bordered mt-2" id="activities-table" width="100%">
            <thead>
              <tr class="text-dark font-weight-bold">
                <td>Name</td>
                <td>Module</td>
                <td class="text-center">Action</td>
              </tr>
            </thead>
            <tbody>
              @foreach($course->modules->where('is_overview', 1) as $overview)
                @foreach($overview->files as $file)
                <tr>
                  <td class="text-primary"><a target="_blank" href="{{ str_replace('student', 'admin', $file->link) }}">{{ $file->title }}</a></td>
                  <td class="text-center">{{ $overview->title }}</td>
                  <td class="text-center">

                    @if(in_array($overview->id, $badge_modules))
                    {{-- IF BELONG TO MODULE --}}
                      <button class="btn btn-sm btn-danger add-for-criteria" disabled  data-child-of="overview-{{ $overview->id }}" data-type="file" data-parent="overview-{{ $overview->id }}" data-title="{{ $file->title }}" data-id="{{ $file->id }}">Belongs to {{ $overview->title }}</button>
                      @elseif(in_array($file->id, $badge_files))
                      {{-- IF SELECTED OF USER --}}
                         <button class="btn btn-sm btn-danger remove-for-criteria" data-child-of="overview-{{ $overview->id }}" data-type="file" data-parent="overview-{{ $overview->id }}" data-title="{{ $file->title }}" data-id="{{ $file->id }}">Remove</button>
                      @else
                      {{-- NOT SELECTED --}}
                        <button class="btn btn-sm btn-primary add-for-criteria" data-child-of="overview-{{ $overview->id }}" data-type="file" data-parent="overview-{{ $overview->id }}" data-title="{{ $file->title }}" data-id="{{ $file->id }}">Add for criteria</button>
                    @endif

                  </td>
                </tr>
                @endforeach
              @endforeach
              @foreach($course->modules->where('is_overview', 0) as $module)
                @foreach($module->activities as $activity)
                <tr>
                  <td class="text-primary"><a target="_blank" href="{{ route('activity.view', $activity->id) }}">{{ $activity->title }}</a></td>
                  <td class="text-center">{{ $module->title }}</td>
                  <td class="text-center">
                    @if(in_array($module->id, $badge_modules))
                      {{-- IF BELONG TO MODULE --}}
                        <button class="btn btn-sm btn-danger add-for-criteria" disabled  data-child-of="module-{{ $module->id }}" data-type="activity" data-parent="module-{{ $module->id }}" data-title="{{ $activity->title }}" data-id="{{ $activity->id }}">Belongs to {{ $module->title }}</button>
                        @elseif(in_array($activity->id, $badge_activities))
                        {{-- IF SELECTED OF USER --}}
                           <button class="btn btn-sm btn-danger remove-for-criteria" data-child-of="module-{{ $module->id }}" data-type="activity" data-parent="module-{{ $module->id }}" data-title="{{ $activity->title }}" data-id="{{ $activity->id }}">Remove</button>
                        @else
                        {{-- NOT SELECTED --}}
                          <button class="btn btn-sm btn-primary add-for-criteria" data-child-of="module-{{ $module->id }}" data-type="activity" data-parent="module-{{ $module->id }}" data-title="{{ $activity->title }}" data-id="{{ $activity->id }}">Add for criteria</button>
                      @endif
                  </td>
                </tr>
                @endforeach
              @endforeach
            </tbody>
          </table>
        </div>
        <div class="tab-pane fade" id="nav-modules" role="tabpanel" aria-labelledby="nav-modules-tab">
          <table class="table table-bordered mt-2" id="modules-table" width="100%">
            <thead>
              <tr class="text-dark font-weight-bold">
                <td>Name</td>
                <td>Total activities</td>
                <td class="text-center">Action</td>
              </tr>
            </thead>
            <tbody>
              @foreach($course->modules->where('is_overview', 1) as $overview)
              <tr>
                <td class="text-primary"><a target="_blank" href="{{ route('course.view.module', $overview->course) }}">{{ $overview->title }}</a></td>
                <td class="text-center"><button class="btn btn-sm btn-info btn-view-overview-files" data-src="{{ $overview->files }}">{{ $overview->files->count() }}</button></td>
                <td class="text-center">
                   @if(in_array($overview->id, $badge_modules))
                      {{-- IF SELECTED --}}
                      <button class="btn btn-sm btn-danger remove-for-criteria"  data-type="overview"  data-title="{{ $overview->title }}" data-id="{{ $overview->id }}">Remove</button>
                      @else
                      <button class="btn btn-sm btn-primary add-for-criteria" data-type="overview"  data-title="{{ $overview->title }}" data-id="{{ $overview->id }}">Require for criteria</button>
                    @endif
                </td>
              </tr>
              @endforeach
              @foreach($course->modules->where('is_overview', 0) as $module)
              <tr>
                <td class="text-primary"><a target="_blank" href="{{ route('course.view.module', $module->course) }}">{{ $module->title }}</a></td>
                <td class="text-center"><button class="btn btn-sm btn-info btn-view-activities" data-title="{{ $module->title }}" data-src="{{ $module->activities }}">{{ $module->activities->count() }}</button></td>
                <td class="text-center">
                  @if(in_array($module->id, $badge_modules))
                      {{-- IF SELECTED --}}
                      <button class="btn btn-sm btn-danger remove-for-criteria"  data-type="module"  data-title="{{ $module->title }}" data-id="{{ $module->id }}">Remove</button>
                      @else
                      <button class="btn btn-sm btn-primary add-for-criteria" data-type="module" data-title="{{ $module->title }}" data-id="{{ $module->id }}">Require for criteria</button>
                  @endif

                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <hr>
      <div class="form-group mb-0">
        <div class="float-right">
          <div class="col-md-auto">
            <button type="submit" class="btn btn-success">
            {{ __('Update badge for ' . $course->acronym) }}
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

{{-- MODAL FOR VIEWING ALL ACTIVITIES OF AN MODULE. --}}
<div class="modal fade" id="modalModuleActivities">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-dark">
        <h4 class="modal-title" id="module-title"></h4>
      </div>
      <div class="modal-body" id="module-activities">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('page-scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/startbootstrap-sb-admin-2@4.1.1/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
</script>
<script>
$(document).ready(function () {
  let courseId   = {{ $course->id }};
  let criterias = JSON.parse($('meta[name="criterias"]').attr('content'));

    $('#activities-table').DataTable({
      "language": {
           "emptyTable": `<a href="/admin/course/create/module/${courseId}">Please add module first.</a>`
        }
    });
    $('#modules-table').DataTable({
      "language": {
             "emptyTable": `<a href="/admin/course/create/module/${courseId}">Please add module first.</a>`
        }
    });


    $(document).on('click', 'button.btn-view-activities', function (e) {
        e.preventDefault();
        let elementClicked = $(this);
        let activities     = JSON.parse(elementClicked.attr('data-src'));
        let moduleTitle    = elementClicked.attr('data-title');
        $('#module-title').text(`${moduleTitle}`)
        $('#module-activities').html('');
        $('#modalModuleActivities').modal('toggle');
        activities.forEach((activity) => $('#module-activities').append(`<div class="alert alert-info" role="alert">${activity.activity_no} ${activity.title}</div>`) );
    });

    $(document).on('click', 'button.btn-view-overview-files', function (e) {
        e.preventDefault();
        let elementClicked = $(this);
        let activities     = JSON.parse(elementClicked.attr('data-src'));
        $('#module-title').text('Overview Activities');
        $('#module-activities').html('');
        $('#modalModuleActivities').modal('toggle');
        activities.forEach((activity) => $('#module-activities').append(`<div class="alert alert-info" role="alert">${activity.title}</div>`) );
    });

    function moduleOrOverview(type, callback) {
      if (type == 'overview' || type == 'module') {
          callback();
      }
    }

    $(document).on('click', 'button.remove-for-criteria', function (e) {
        e.preventDefault();
        let elementClicked = $(this);
        let type  = elementClicked.attr('data-type');
        let id    = elementClicked.attr('data-id');
        let title = elementClicked.attr('data-title');
        // Remove the badge in div container
        $(`#${type}-${id}`).remove();
        
        criterias.map((criteria, key) => {
          if (criteria.id == id && criteria.type == type) { delete criterias[key]; }
        });
          
          moduleOrOverview(type, function () {
            $(`button[data-parent=${type}-${id}]`).each(function (index, button) {
              $(button).prop('disabled', false)
                       .removeClass('btn-danger')
                       .addClass('btn-primary')
                       .text(`Add for criteria`);
            });
          });


        $('#criterias').val(JSON.stringify(criterias.filter(Boolean)));

        elementClicked.addClass('btn-primary')
                    .addClass('add-for-criteria')
                    .removeClass('btn-danger')
                    .removeClass('remove-for-criteria')
                    .text('Add for criteria');
    });

    $(document).on('click', 'button.add-for-criteria', function(e) {
      e.preventDefault();
      let elementClicked = $(this);
      let type  = elementClicked.attr('data-type');
      let id    = elementClicked.attr('data-id');
      let title = elementClicked.attr('data-title');
      let childOf = elementClicked.attr('data-child-of');

      moduleOrOverview(type, function () {
        // Removing all the child files or activities by module or overview.
        $(`span[data-related-to=${type}-${id}]`).remove();

        // Remove the data in form 
         criterias.map((criteria, key) => { if (criteria.parent == `${type}-${id}`) {
              delete criterias[key];
            }
        });

        $(`button[data-parent=${type}-${id}]`).each(function (index, button) {
          $(button).prop('disabled', true)
                  .removeClass('btn-primary')
                  .addClass('btn-danger')
                  .text(`Belongs to ${title}`);
        });

      });
      
      $('#selected_criteria').html();

      elementClicked.removeClass('btn-primary')
                    .removeClass('add-for-criteria')
                    .addClass('btn-danger')
                    .addClass('remove-for-criteria')
                    .text('Remove');

                    
        criterias.push({id, title, type, parent : childOf});
        $('#criterias').val(JSON.stringify(criterias.filter(Boolean)));
        // Selected button is belongs to activities-tab
        if (typeof childOf != 'undefined') { 
          $('#selected_criteria').append(`<span class="ml-2 badge badge-primary" data-related-to="${childOf}" id="${type}-${id}">${title}</span>`);  
        } else { 
          $('#selected_criteria').append(`<span class="ml-2 badge badge-primary" id="${type}-${id}">${title}</span>`);  
        }
        
    });

});
</script>
@endpush
@endsection