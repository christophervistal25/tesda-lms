@extends('layouts.admin.app')
@section('title', 'Add course overview for ' . $course->name)
@section('content')
@prepend('page-css')
<link rel="stylesheet" href="/dropzone/dropzone.min.css">
@endprepend

{{ Breadcrumbs::render('course-add-overview') }}

@if(Session::has('success'))
<div class="card bg-primary text-white shadow mb-2">
  <div class="card-body">
    {{ Session::get('success') }}
    <br>
    <ul>
      <li><a class="text-white" href="{{ route('course.view.module', $course) }}">View Course</a></li>
      <li><a class="text-white" href="{{ route('course.add.module', $course) }}">Add module</a>
      </li>
    </ul>
  </div>
</div>
@endif

@if(is_null($overview))
<div class="card bg-danger text-white shadow mb-2">
  <div class="card-body">
    You should add a course overview first
  </div>
</div>
@endif


@if(Session::has('no_activity'))
<div class="card bg-danger text-white shadow mb-2">
  <div class="card-body">
    {{ Session::get('no_activity') }}
  </div>
</div>
@endif


<div class="card mb-4">
  <!-- Card Header - Dropdown -->
  <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
  </div>
  <!-- Card Body -->
  <div class="card-body">
    <form method="POST" action="{{ route('create.store.overview', $course) }}">
      <div class="card-body">
        @csrf

        <div class="form-group">
          <label>Title</label>
          <input type="text" name="title" value="Course Overview" class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"></input>
          @error('title')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div class="form-group">
          <label>Content</label>
          <textarea name="body" id="module_body" class="form-control @error('body') is-invalid @enderror">{{ old('body') }}</textarea>
          @error('body')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>



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
<script src="/dropzone/dropzone.min.js"></script>
<script>
  let moduleBodyEditor = CKEDITOR.replace( 'module_body', {   tabSpaces: 4 } );
  
// START OF THE COMMAND
    moduleBodyEditor.addCommand("insertFile", {
        exec: function(edt) {
          selectedActivityContent = edt;
          $('#addFileInActivityModal').modal('toggle');
        }
    });

   moduleBodyEditor.addCommand("insertCourseDesign", {
       exec: function(edt) {
           edt.insertHtml(`<a href="/student/course/design/${courseId}">Course Design</a> <img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/checkable.webp" >`);
       }
    });

    moduleBodyEditor.addCommand("insertDocx", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602063746/icons/docx.png" />`);
       }
    });

   moduleBodyEditor.addCommand("insertPDFicon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png" />`);
       }
    });

   moduleBodyEditor.addCommand("insertActivityIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/course_design_icon_jfq35v.png" />`);
       }
    });

   moduleBodyEditor.addCommand("insertPPTicon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png" />`);
       }
    });

   moduleBodyEditor.addCommand("insertFinalExamIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png" />`);
       }
    });

   moduleBodyEditor.addCommand("insertCertificateIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png" />`);
       }
    });

   moduleBodyEditor.addCommand("insertCheckableBox", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/checkable.webp" />`);
       }
    });

   moduleBodyEditor.addCommand("insertReadableBox", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp" />`);
       }
    });

   // END OF COMMAND


 // UI BUTTONS
    moduleBodyEditor.ui.addButton('addDocxIcon', {
        label: "Add Docx Icon",
        command: 'insertDocx',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602063746/icons/docx.png'
    });

    moduleBodyEditor.ui.addButton('AddPDFicon', {
        label: "Add PDF Icon",
        command: 'insertPDFicon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png'
    });

    moduleBodyEditor.ui.addButton('addActivityIcon', {
        label: "Add Activity Icon",
        command: 'insertActivityIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601888589/icons/course_design_icon_ljqk9r.png'
    });


    moduleBodyEditor.ui.addButton('addPPTicon', {
        label: "Add Powerpoint icon",
        command: 'insertPPTicon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png'
    });

    moduleBodyEditor.ui.addButton('addFinalExam', {
        label: "Add Final Exam icon",
        command: 'insertFinalExamIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png'
    });

    moduleBodyEditor.ui.addButton('addCertificateIcon', {
        label: "Add Certificate icon",
        command: 'insertCertificateIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png'
    });
 
    moduleBodyEditor.ui.addButton('CourseDesignButton', {
       label: "Add Course Design",
       command: 'insertCourseDesign',
       toolbar: 'insert',
       icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890160/icons/mortarboard_frosqa.png'
    });

    moduleBodyEditor.ui.addButton('AddFileButton', {
        label: "Add Downloable file",
        command: 'insertFile',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890164/icons/folder_pk0fos.png'
    });

    moduleBodyEditor.ui.addButton('addCheckable', {
        label: "Add checkable checkbox",
        command: 'insertCheckableBox',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/checkable.webp'
    });

    moduleBodyEditor.ui.addButton('addReadable', {
        label: "Add checkable checkbox",
        command: 'insertReadableBox',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065138/icons/activity-icon/not-check.webp'
    });


    // END OF UI BUTTONS

</script>
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
        content += `<a href="${file.link}">${file.name}</a> <img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1602065137/icons/activity-icon/checkable.webp"> <br>`;
      });
      selectedActivityContent.setData(`${previousData} ${content}`);
  });

</script>

@endpush
@endsection