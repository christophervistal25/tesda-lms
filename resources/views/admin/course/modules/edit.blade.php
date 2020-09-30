@extends('layouts.admin.app')
@section('title', 'Edit module ' . $module->title)
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


.fab {
  background-color: transparent;
  height: 64px;
  width: 64px;
  border-radius: 32px;
  transition: height 300ms;
  transition-timing-function: ease;
  /*position: absolute;*/
  right: 50px;
  bottom: 50px;
  text-align: center;
  overflow: hidden;
  position: fixed;
}

.fab:hover {
  height: 290px;
}

.fab:hover .mainop {
  transform: rotate(180deg);
}

.mainop {
  margin: auto;
  width: 64px;
  height: 64px;
  position: absolute;
  bottom: 0;
  right: 0;
  transition: transform 300ms;
  background-color: #f44336;
  border-radius: 32px;
  z-index: 6;
  cursor: pointer;
}

.mainopShadow {
  width: 64px;
  height: 64px;
  border-radius: 32px;
  position: absolute;
  right: 50px;
  bottom: 50px;
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);  
  position: fixed;
}

.mainop i {
  margin-top: 16px;
  font-size: 32px;
  color: #fff;
}

.minifab {
  position: relative;
  width: 48px;
  height: 48px;
  border-radius: 24px;
  z-index: 5;
  float: left;
  margin-bottom: 8px;
  margin-left: 8px;
  margin-right: 8px;
  background-color: blue;
  transition: box-shadow 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
}

.minifab:hover {
  box-shadow: 0 3px 6px rgba(0, 0, 0, 0.16), 0 3px 6px rgba(0, 0, 0, 0.23);
}

.minifabIcon {
  height: 24px;
  width: 24px;
  margin-top: 12px;
}

.op1 {
  background-color: #2f82fc;
  cursor:pointer;
}

.op2 {
  background-color: #0f9d58;
  cursor:pointer;
}

.op3 {
  background-color: #fb0;
  cursor:pointer;
}

.op4 {
  background-color: #dd5145;
  cursor:pointer;
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
        <button id="btnAddCourseOverview" class="dropdown-item text-capitalize text-gray-700"><i class="fas fa-plus"></i> Add Course Overview</button>
      </div>
    </div>
  </div>
  <!-- Card Body -->
  <div class="card-body">
    <form method="POST" action="{{ route('course.update.module', $module) }}">
      <div class="card-body">
        @csrf
        @method("PUT")
        <div class="form-group row">
          <label for="email" class="col-md-auto  text-md-right">{{ __('Module Title') }}</label>
          <div class="col-md-12">
            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') ?? $module->title }}" required autocomplete="title" autofocus>
            @error('title')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </div>
        </div>

        <div class="form-group">
          <label>Module body</label>
          <textarea name="body" id="module_body" class="form-control @error('body') is-invalid @enderror">{{ old('body') ?? $module->body }}</textarea>
          @error('body')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>

        <div id="dynamic-activity-container">
              @foreach($module->activities as $activity)
                @if($activity->downloadable == 0)
                {{-- NORMAL ACTIVITY --}}
                    <div class="card shadow mb-2" id="activity-${activityIndex}">
                      <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Activity {{ $activity->activity_no }}</h6>
                        <div class="dropdown no-arrow">
                          <a class="text-danger pointer-cursor"  role="button" onclick="deleteActivity({{Str::after($activity->activity_no, '.')}})">
                            <i class="fas fa-trash"></i>
                          </a>
                        </div>
                      </div>
                      <div class="card-body">
                        <div class="form-group row">
                          <label class="col-md-auto  text-md-right">Activity No.</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control activity-index" readonly name="activity_no[]" value="{{ $activity->activity_no }}" required>
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-auto  text-md-right">Activity Name</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" name="activity_name[]" value="{{ $activity->title }}" required  >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-auto  text-md-right">Activity Instruction</label>
                          <div class="col-md-12">
                            <input type="text" class="form-control" name="activity_instructions[]" value="{{ $activity->instructions }}" required  >
                          </div>
                        </div>
                        <div class="form-group row">
                          <label class="col-md-auto  text-md-right">Activity Content</label>
                          <div class="col-md-12">
                            <textarea name="activity_content[]" class="current-activity-content" id="activity_content-{{Str::after($activity->activity_no, '.')}}" cols="30" rows="10">{{ $activity->body }}</textarea>
                          </div>
                        </div>
                      </div>
                    </div>
                  @else
                  {{-- DOWNLOADABLE ACTIVITY --}}
                      <div class="card shadow mb-2" id="activity-${activityIndex}">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Downloadable Activity {{$activity->activity_no }}</h6>
                          <div class="dropdown no-arrow">
                            <a class="text-danger pointer-cursor" role="button" onclick="deleteActivity({{Str::after($activity->activity_no, '.')}})">
                              <i class="fas fa-trash"></i>
                            </a>
                          </div>
                        </div>

                        <div class="card-body">

                            <div class="form-group row">
                            <label class="col-md-auto  text-md-right">Activity No.</label>
                            <div class="col-md-12">
                              <input type="text" class="form-control activity-index" readonly name="downloadable_activity_no[]" value="{{ $activity->activity_no }}" required>
                            </div>
                          </div>


                          <div class="form-group row">
                            <label class="col-md-auto  text-md-right">Activity Name</label>
                            <div class="col-md-12">
                              <input type="text" class="form-control" name="downloadable_activity_name[]" value="{{ $activity->title }}" required  >
                            </div>
                          </div>

                          <div class="form-group row">
                            <label class="col-md-auto  text-md-right">Activity Instruction</label>
                            <div class="col-md-12">
                              <input type="text" class="form-control" name="downloadable_activity_instructions[]" value="{{ $activity->instructions }}" required  >
                            </div>
                          </div>

                           <div class="form-group row">
                            <label class="col-md-auto  text-md-right">Activity Content</label>
                            <div class="col-md-12">
                              <textarea name="downloadable_activity_content[]" class="current-activity-content" id="activity_content-{{Str::after($activity->activity_no, '.')}}" cols="30" rows="10">{!! $activity->body !!}</textarea>
                            </div>
                          </div>

                        </div>
                      </div>
                @endif
              @endforeach
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

<div class="mainopShadow"></div>
<div class="fab">
  <div class="mainop">
    <i id="addIcon" class="fas fa-plus"></i>
  </div>

  <div id="drawings" class="minifab op4" data-toggle="tooltip" data-placement="left" title="Add Quiz">
    <img class="minifabIcon" src="https://vectr.com/doodleblu/b2DCtQvEHF.svg?width=64&height=64&select=b2DCtQvEHFpage0">
  </div>

  <div id="slides" class="minifab op3" onclick="generateCourseOverview()" data-toggle="tooltip" data-placement="left" title="Add Course Overview">
    <img class="minifabIcon" src="https://vectr.com/doodleblu/a12WZHDh0z.svg?width=64&height=64&select=a12WZHDh0zpage0">
  </div>
  <div id="sheets" class="minifab op2" onclick="generateDownloadableActivity()" data-toggle="tooltip" data-placement="left" title="Add Downlable activity">
    <img class="minifabIcon" src="https://vectr.com/doodleblu/eoOhnACDe.svg?width=64&height=64&select=eoOhnACDepage0">
  </div>
  <div id="docs" class="minifab op1" onclick="generateActivity();" data-toggle="tooltip" data-placement="left" title="Add Activity">
    <img class="minifabIcon" src="https://vectr.com/doodleblu/bo4WGZSAK.svg?width=64&height=64&select=bo4WGZSAKpage0">
  </div>
</div>

@push('page-scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script>
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
  })

  function generateActivity() {
    $('#btnAddActivity').trigger('click');
  }

  function generateDownloadableActivity() {
    $('#btnAaddActivityDownloadable').trigger('click');
  }


</script>

{{-- FOR EDIT ACTIVITY FORM --}}
<script>
    
</script>


{{-- FOR ADDING NEW ACTIVITY FORM --}}
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

    $(".current-activity-content").each(function (index, element) {
      let elementId = $(element).attr('id')

      let moduleBodyEditor = CKEDITOR.replace( elementId );
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
  let activityModuleNo = "{{ $moduleNo }}";
  let activityIndex = {{ $subCount }};
  let selectedActivityContent = "";
  let courseId = 0;



  

  function deleteActivity(index) {
    $(`#activity-${index}`).remove();
    activityIndex--;

    let confirmation = confirm('Are you sure to delete this activity?');
    if (confirmation) {
        $('#dynamic-activity-container').children().each(function (index, element) {
          // Change the title of card header
          $(this).children().each(function (i, e) {
            if ($(this).attr('class').includes('card-header')) {
                // Extract the string of the current element text 
                activityType = $(e).find('h6').text().replace(/[0-9|.]/g, '');
                // Replace the current text
                $(e).find('h6').text(`${activityType} ${activityModuleNo}.${index + 1}`)
            }

            if ($(this).attr('class').includes('card-body')) {
                // Replace the current text
                $(e).find('input.activity-index').val(`${activityModuleNo}.${index + 1}`);
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

          <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity No.</label>
              <div class="col-md-12">
                <input type="text" class="form-control  activity-index" readonly name="activity_no[]" value="${activityModuleNo}.${activityIndex}" required>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Name</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="activity_name[]" value="" required  >
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Instruction</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="activity_instructions[]" value="" required  >
              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Content</label>
              <div class="col-md-12">
                <textarea name="activity_content[]" class="" id="activity_content-${activityIndex}" cols="30" rows="10"></textarea>
              </div>
            </div>

          </div>
        </div>
    `);
    applyCKEditorDynamically();
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

              <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity No.</label>
              <div class="col-md-12">
                <input type="text" class="form-control activity-index" readonly name="downloadable_activity_no[]" value="${activityModuleNo}.${activityIndex}" required>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Name</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="downloadable_activity_name[]" value="" required  >
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Instruction</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="downloadable_activity_instructions[]" value="" required  >
              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Content</label>
              <div class="col-md-12">
                <textarea name="downloadable_activity_content[]" id="activity_content-${activityIndex}" cols="30" rows="10"></textarea>
              </div>
            </div>

          </div>
        </div>
    `);
    applyCKEditorDynamically();
  });



  function applyCKEditorDynamically() {
    editor = CKEDITOR.replace( `activity_content-${activityIndex}` );
    editor.addCommand("addFile", {
        exec: function(edt) {
          selectedActivityContent = edt;
          $('#addFileInActivityModal').modal('toggle');
        }
    });

    editor.ui.addButton('SuperButton', {
        label: "Add downloable",
        command: 'addFile',
        toolbar: 'insert',
        icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
    });
  }

 
    

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