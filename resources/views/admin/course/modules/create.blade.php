@extends('layouts.admin.app')
@section('title', 'Add module for ' . $course->name)
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.css" integrity="sha512-bbUR1MeyQAnEuvdmss7V2LclMzO+R9BzRntEE57WIKInFVQjvX7l7QZSxjNDt8bg41Ww05oHSh0ycKFijqD7dA==" crossorigin="anonymous" /> --}}
{{-- <link rel="stylesheet" href="/dropzone/basic.min.css"> --}}
<link rel="stylesheet" href="/dropzone/dropzone.min.css">
<style>
  .pointer-cursor {
    cursor : pointer;
  }
</style>
@endprepend
@if(Session::has('success'))
<div class="card bg-primary text-white shadow mb-2">
  <div class="card-body">
    {{ Session::get('success') }} <a class="font-weight-bold text-white" href=" {{ route('course.index') }}"> / <u>View records</u></a>
  </div>
</div>
@endif
<div class="card  mb-4">
  <!-- Card Header - Dropdown -->
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
    <h6 class="m-0 font-weight-bold text-primary">Module</h6>
    <div class="dropdown no-arrow">
      <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="fas fa-cog"></i>
      </a>
      <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink" style="">
        <div class="dropdown-header">Activities</div>
        <button id="btnAddActivity" class="dropdown-item text-capitalize text-gray-700"><i class="fas fa-plus"></i> Add activity</button>
        <button id="btnAaddActivityDownloadable" class="dropdown-item text-capitalize text-gray-700"><i class="fas fa-plus"></i> Add activity downloadable</button>
      </div>
    </div>
  </div>
  <!-- Card Body -->
  <div class="card-body">
    <form method="POST" action="{{ route('course.submit.module', $course) }}">
      <div class="card-body">
        @csrf

        <div class="form-group row">
          <label for="email" class="col-md-auto  text-md-right">{{ __('Module Title') }}</label>
          <div class="col-md-12">
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
            @error('title')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label>Module body</label>
          <textarea name="body" id="module_body" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
          @error('body')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div id="dynamic-activity-container"></div>


        <div class="clearfix"></div>
        <div class="form-group mb-0 text-right">
          <div class="col-md-auto">
            <button type="submit" class="btn btn-primary">{{ __('Create') }}</button>
          </div>
        </div>
      </div>
      
    </form>
  </div>
</div>

<div class="modal fade" id="addFileInActivityModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Upload file</h4>
      </div>
      <div class="modal-body">
        <form id="dropzone" action="/" class="dropzone" method="post" enctype="multipart/form-data">
                    <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div>
                </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
@push('page-scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>CKEDITOR.replace( 'module_body' );</script>
<script src="/dropzone/dropzone.min.js"></script>

{{-- CUSTOM CS FOR DYNAMIC ADD ACTIVITY --}}
<script>
  let activityModuleNo = "{{ $moduleNo }}";
  let activityIndex = 0;

  

  function deleteActivity(index) {
    $(`#activity-${index}`).remove();
    activityIndex--;

    let confirmation = confirm('Are you sure to delete this activity?');
    if (confirmation) {
        $('#dynamic-activity-container').children().each(function (index, element) {
          // Change the ID activity - index
          // $(element).attr('id', `activity-${i + 1}`);
          // change the parameters in onClick
          // $(element).attr('onclick', `deleteActivity(${i + 1})`);
          // console.log(i + 1, element);

          // Change the title of card header
          $(this).children().each(function (i, e) {
            if ($(this).attr('class').includes('card-header')) {
                // Extract the string of the current element text 
                activityType = $(e).find('h6').text().replace(/[0-9|.]/g, '');
                // Replace the current text
                $(e).find('h6').text(`${activityType} ${activityModuleNo}.${index + 1}`)
            }
          });
      });
    }
  }

  $('#btnAddActivity').click(function () {
    activityIndex++;
    $('#dynamic-activity-container').append(`
        <div class="card shadow mb-2" id="activity-${activityIndex}">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Activity ${activityModuleNo}.${activityIndex}</h6>
            <div class="dropdown no-arrow">
              <a class="text-danger pointer-cursor" role="button" onclick="deleteActivity(${activityIndex})">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>

          <div class="card-body">
            <input type="text" class="form-control" name="activity_no" hidden  required  autofocus>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Name</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="name" value="" required  autofocus>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Instruction</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="name" value="" required  autofocus>
              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Content</label>
              <div class="col-md-12">
                <textarea name="activity_content" id="activity_content-${activityIndex}" cols="30" rows="10"></textarea>
              </div>
            </div>

          </div>
        </div>
    `);
    editor = CKEDITOR.replace( `activity_content-${activityIndex}` );
    editor.addCommand("addFile", {
        exec: function(edt) {
            $('#addFileInActivityModal').modal('toggle');
        }
    });
    editor.ui.addButton('SuperButton', {
        label: "Add downloable",
        command: 'addFile',
        toolbar: 'insert',
        icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
    });
  });

  $('#btnAaddActivityDownloadable').click(function () {
    activityIndex++;
    $('#dynamic-activity-container').append(`
        <div class="card shadow mb-2" id="activity-${activityIndex}">
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Downloadable Activity ${activityModuleNo}.${activityIndex}</h6>
            <div class="dropdown no-arrow">
              <a class="text-danger pointer-cursor" role="button" onclick="deleteActivity(${activityIndex})">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>

          <div class="card-body">
          </div>
        </div>
    `);
  });

</script>

@endpush
@endsection