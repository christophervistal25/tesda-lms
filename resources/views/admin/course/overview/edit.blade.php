@extends('layouts.admin.app')
@section('title', 'Edit course overview for ' . $course->name)
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
<div class="card bg-success text-white shadow mb-2">
  <div class="card-body">
    {{ Session::get('success') }}
  </div>
</div>
@endif


<div class="card mb-4">
  <!-- Card Header - Dropdown -->
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
  </div>
  <!-- Card Body -->
  <div class="card-body">
    <form method="POST" action="{{ route('update.course.overview', $course->overview->id) }}">
      <div class="card-body">
        @csrf
        @method('PUT')

        <div class="form-group">
          <label>Content</label>
          <textarea name="body" id="module_body" class="form-control @error('body') is-invalid @enderror">{{ old('body') ?? $course->overview->body }}</textarea>
          @error('body')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>


        <div class="clearfix"></div>
        <div class="form-group mb-0 text-right">
          <div class="col-md-auto">
            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
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
       
        <form id="dropzoneForm" action="{{ route('activity.add.file') }}" class="dropzone" method="post" enctype="multipart/form-data">
            @csrf
            <div class="fallback">
                <input name="file" type="file" multiple />
            </div>
        </form>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnAddFileClose">Close</button>
        <button type="button" class="btn btn-primary" id="btnApplyFile" disabled="true">Apply in Activity Content</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


@push('page-scripts')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
  let moduleBodyEditor = CKEDITOR.replace( 'module_body' );
    moduleBodyEditor.addCommand("addFile", {
        exec: function(edt) {
          selectedActivityContent = edt;
          $('#addFileInActivityModal').modal('toggle');
        }
    });


    moduleBodyEditor.ui.addButton('AddFileButton', {
        label: "Add Downloable file",
        command: 'addFile',
        toolbar: 'insert',
        icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
    });


    moduleBodyEditor.addCommand("courseDesign", {
       exec: function(edt) {
           edt.insertHtml(`<a href="/admin/course/design/${courseId}">Course Design</a>`);
       }
    });

    moduleBodyEditor.ui.addButton('CourseDesignButton', {
       label: "Add Course Design",
       command: 'courseDesign',
       toolbar: 'insert',
       icon: 'http://lms.mnpvi-tesda.com/theme/image.php/moove/theme/1598161402/favicon'
    });


</script>
<script src="/dropzone/dropzone.min.js"></script>
<script>
  let filesData = [];
  let tempFilesData = [];

  Dropzone.options.dropzoneForm = {
    dictDefaultMessage: 'Drop file or Click to upload',
    addRemoveLinks: true, 
    init: function () {
      this.on('success', function(file, response) { 
          filesData.push({
            name : file.name,
            size : file.size,
            link : response.link,
            type : response.extension,
          });

        $('#btnApplyFile').prop('disabled', false);
      });

      this.on('removedfile', function (file) {
         filesData = filesData.filter((fileData, index) => {
              return fileData.name != file.name;
          });

        tempFilesData = tempFilesData.filter((f) => {
             return f != file.name;
        });
      });

      this.on('addedfile', function(file) { 
        $('#btnApplyFile').prop('disabled', true);
        if (!tempFilesData.includes(file.name)) {
          tempFilesData.push(file.name);  
        } else {
            alert('You already add this file if you want to add it again click the remove file first or hit the cancel upload');
            this.removeFile(file);
        }


      });

    }
  };

  $('#btnAddFileClose').click(function (e) {
    let confirmation = confirm('Are you sure to close this modal did you already apply the file that you\'ve upload?');
    if (confirmation) {
      $('#addFileInActivityModal').modal('toggle');
    }
  });

  $('#addFileInActivityModal').on('show.bs.modal', function () {
      $('#btnApplyFile').prop('disabled', true);
  });

</script>

{{-- CUSTOM CS FOR DYNAMIC ADD ACTIVITY --}}
<script>
  let selectedActivityContent = "";
  let courseId = "{{ $course->id }}";



  $('#btnApplyFile').click(function () {
      let content = "";
      previousData = selectedActivityContent.getData();

      filesData.forEach((file) => {
        content += `<a href="${file.link}">${file.name}</a> <br>`;
      });
      selectedActivityContent.setData(`${previousData} ${content}`);
  });

</script>

@endpush
@endsection