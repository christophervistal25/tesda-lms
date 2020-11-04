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
  height: 300px;
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

.op5 {
  background-color: orange;
  cursor:pointer;
}

.op6 {
  background-color: pink;
  cursor:pointer;
}



</style>
@endprepend


{{ Breadcrumbs::render('course-edit-module', $module) }}

@if(Session::has('success'))
<div class="card bg-primary text-white shadow mb-2">
  <div class="card-body">
    {{ Session::get('success') }} <a class="text-white" href="{{ route('course.view.module', $module->course) }}"> / <u>View Module</u></a>
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


{{-- @if(!$canAddCompletion)
<div class="card bg-danger text-white shadow mb-2">
  <div class="card-body">
    You can't add activity completion without adding first a final exam.
  </div>
</div>
@endif --}}


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
        @if(!$hasExam)
          <button id="btnAddFinalExam" class="dropdown-item text-capitalize text-gray-700"><i class="fas fa-plus"></i> Add Final Exam</button>
        @endif
        <button id="btnAddCompletionActivity" class="dropdown-item text-capitalize text-gray-700"><i class="fas fa-plus"></i> Add Completion Activity</button>
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

        @php $hasOld = false; @endphp

        <div id="dynamic-activity-container">
                <div id="dynamic-activity-container">
                @if(old('activity_no') || old('downloadable_activity_no') || old('completion_activity_no'))
                   @php
                      $allOldValues = array_merge(old('activity_no') ?? [], old('downloadable_activity_no') ?? []);
                      sort($allOldValues);
                      $noOfOldValues = count($allOldValues);
                      $hasOld = true;
                   @endphp
                   @include('layouts.admin.validation.modules.generate-activity')
                @else
                   @php
                    $noOfOldValues = 0;
                   @endphp
                @endif

              @if(!$hasOld)
                @foreach($module->activities->sortBy('activity_no') as $index => $activity)
                  @if($activity->downloadable == 0 && !$activity->completion)
                  {{-- NORMAL ACTIVITY --}}
                      <div class="card shadow mb-2" id="activity-{{ $activity->activity_no }}">
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
                            <label class="col-md-auto  text-md-right">Select Activity Icon</label>
                            <input type="hidden" id="activity-icon-{{ $index }}" name="activity_icon[]" value="{{ $activity->icon }}">
                            <div class="col-md-12" id="activity-icon-container-{{ $index }}">
                              @foreach($fileIcons as $icon)
                                @if($activity->icon == $icon)
                                  <img style="background : #4e73df;" class="p-2 select-activity-icon pointer-cursor" data-index="{{ $index }}" src="{{ $icon }}" alt="">
                                  @else
                                  <img class="p-2 select-activity-icon pointer-cursor" data-index="{{ $index }}" src="{{ $icon }}" alt="">
                                @endif
                                
                              @endforeach              
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
                      
                    @elseif($activity->downloadable == 1 && !$activity->completion)
                    {{-- DOWNLOADABLE ACTIVITY --}}
                        <div class="card shadow mb-2" id="activity-{{ $activity->activity_no }}">
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
                              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
                                <input type="hidden" id="activity-icon-{{ $index }}" name="downloadable_activity_icon[]" value="{{ $activity->icon }}">
                                <div class="col-md-12" id="activity-icon-container-{{ $index }}">
                                  @foreach($fileIcons as $icon)
                                    @if($activity->icon == $icon)
                                      <img style="background : #4e73df;" class="p-2 select-activity-icon pointer-cursor" data-index="{{ $index }}" src="{{ $icon }}" alt="">
                                      @else
                                      <img class="p-2 select-activity-icon pointer-cursor" data-index="{{ $index }}" src="{{ $icon }}" alt="">
                                    @endif
                                    
                                  @endforeach              
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
                      @else
                       <div class="card shadow mb-2" id="activity-{{ $activity->activity_no }}">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                          <h6 class="m-0 font-weight-bold text-primary">Completion Activity {{ $activity->activity_no }}</h6>
                          <div class="dropdown no-arrow">
                            <a class="text-danger pointer-cursor"  role="button" onclick="deleteActivity({{Str::after($activity->activity_no, '.')}})">
                              <i class="fas fa-trash"></i>
                            </a>
                          </div>
                        </div>
                        <div class="card-body">
                          <div class="form-group row">
                            <div class="col-md-12">
                              <input type="hidden" class="form-control activity-index" readonly name="completion_activity_no[]" value="{{ $activity->activity_no }}" required>
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-md-auto  text-md-right">Activity Name</label>
                            <div class="col-md-12">
                              <input type="text" class="form-control" name="completion_activity_name[]" value="{{ $activity->title }}" required  >
                            </div>
                          </div>

                          <div class="form-group row">
                              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
                                <input type="hidden" id="activity-icon-{{ $index }}" name="completion_activity_icon[]" value="{{ $activity->icon }}">
                                <div class="col-md-12" id="activity-icon-container-{{ $index }}">
                                  @foreach($fileIcons as $icon)
                                    @if($activity->icon == $icon)
                                      <img style="background : #4e73df;" class="p-2 select-activity-icon pointer-cursor" data-index="{{ $index }}" src="{{ $icon }}" alt="">
                                      @else
                                      <img class="p-2 select-activity-icon pointer-cursor" data-index="{{ $index }}" src="{{ $icon }}" alt="">
                                    @endif
                                    
                                  @endforeach              
                                </div>
                            </div>

                          <div class="form-group row">
                            <label class="col-md-auto  text-md-right">Activity Content</label>
                            <div class="col-md-12">
                              <textarea name="completion_activity_content[]" class="current-activity-content" id="activity_content-{{Str::after($activity->activity_no, '.')}}" cols="30" rows="10">{{ $activity->body }}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                  @endif

                @endforeach

              @endif
        </div>


       
      </div>

       <div class="clearfix"></div>
        <div class="form-group mb-0 text-right">
          <div class="col-md-auto">
            <button type="submit" class="btn btn-success">{{ __('Update') }}</button>
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

  @if(!$hasExam)
    <div id="drawings" class="minifab op4" onclick="generateFinalExam()" data-toggle="tooltip" data-placement="left" title="Add Final Exam">
      <img class="minifabIcon" src="https://vectr.com/doodleblu/b2DCtQvEHF.svg?width=64&height=64&select=b2DCtQvEHFpage0">
    </div>
    @else
    <div id="drawings" class="minifab op4" onclick="updateExam({{ $module->exam }})" data-toggle="tooltip" data-placement="left" title="Update Final Exam">
      <img class="minifabIcon" src="https://vectr.com/doodleblu/b2DCtQvEHF.svg?width=64&height=64&select=b2DCtQvEHFpage0">
    </div>
  @endif

  <div id="sheets" class="minifab op2" onclick="generateDownloadableActivity()" data-toggle="tooltip" data-placement="left" title="Add Downlable activity">
    <img class="minifabIcon" src="https://vectr.com/doodleblu/eoOhnACDe.svg?width=64&height=64&select=eoOhnACDepage0">
  </div>

   <div id="docs" class="minifab op3" onclick="generateCompletionActivity();" data-toggle="tooltip" data-placement="left" title="Add Completion Activity">
    <img class="minifabIcon" src="https://vectr.com/doodleblu/bo4WGZSAK.svg?width=64&height=64&select=bo4WGZSAKpage0">
  </div>

  <div id="docs" class="minifab op1" onclick="generateActivity();" data-toggle="tooltip" data-placement="left" title="Add Activity">
    <img class="minifabIcon" src="https://vectr.com/doodleblu/bo4WGZSAK.svg?width=64&height=64&select=bo4WGZSAKpage0">
  </div>
</div>

@push('page-scripts')
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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

  function generateFinalExam() {
    $('#btnAddFinalExam').trigger('click');
  }

  function updateExam(exam) {
    location.href = `/admin/module/${exam.id}/final/exam/edit`;
  }

  function generateCompletionActivity() {
    let canAddCompletion = "{{ $canAddCompletion }}";
    if (canAddCompletion) {
        $('#btnAddCompletionActivity').trigger('click');
    } else {
      swal({
        title: 'Important Message',
        text: `Please add final exam first.`,
        icon: 'warning',
        buttons: true,
        dangerMode: true,
        closeOnClickOutside: false
      });
    }
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

    moduleBodyEditor.addCommand("courseDesign", {
       exec: function(edt) {
           edt.insertHtml(`<a href="/admin/course/design/${courseId}">Course Design</a>`);
       }
    });

    moduleBodyEditor.ui.addButton('AddFileButton', {
        label: "Add Downloable file",
        command: 'addFile',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890164/icons/folder_pk0fos.png'
    });

    moduleBodyEditor.ui.addButton('CourseDesignButton', {
       label: "Add Course Design",
       command: 'courseDesign',
       toolbar: 'insert',
       icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890160/icons/mortarboard_frosqa.png'
    });


    $(".current-activity-content").each(function (index, element) {
      let elementId = $(element).attr('id')

      let moduleBodyEditor = CKEDITOR.replace( elementId, { tabSpaces: 4 } );
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


       moduleBodyEditor.addCommand("pdfIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png" />`);
           }
        });

       moduleBodyEditor.addCommand("activityIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/course_design_icon_jfq35v.png" />`);
           }
        });

       moduleBodyEditor.addCommand("pptIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png" />`);
           }
        });

       moduleBodyEditor.addCommand("finalExamIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png" />`);
           }
        });

       moduleBodyEditor.addCommand("cerficateIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png" />`);
           }
        });


        moduleBodyEditor.ui.addButton('AddPDFicon', {
            label: "Add PDF Icon",
            command: 'pdfIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png'
        });

        moduleBodyEditor.ui.addButton('addActivityIcon', {
            label: "Add Activity Icon",
            command: 'activityIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601888589/icons/course_design_icon_ljqk9r.png'
        });


        moduleBodyEditor.ui.addButton('addPPTicon', {
            label: "Add Powerpoint icon",
            command: 'pptIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png'
        });

        moduleBodyEditor.ui.addButton('addFinalExam', {
            label: "Add Final Exam icon",
            command: 'finalExamIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png'
        });

        moduleBodyEditor.ui.addButton('addCertificateIcon', {
            label: "Add Certificate icon",
            command: 'cerficateIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png'
        });
     
        moduleBodyEditor.ui.addButton('CourseDesignButton', {
           label: "Add Course Design",
           command: 'courseDesign',
           toolbar: 'insert',
           icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890160/icons/mortarboard_frosqa.png'
        });

        moduleBodyEditor.ui.addButton('AddFileButton', {
            label: "Add Downloable file",
            command: 'addFile',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890164/icons/folder_pk0fos.png'
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
              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
              <input type="hidden" id="activity-icon-${activityIndex}" name="activity_icon[]">
              <div class="col-md-12" id="activity-icon-container-${activityIndex}">
                @foreach($fileIcons as $icon)
                  <img class="p-2 select-activity-icon pointer-cursor" data-index="${activityIndex}" src="{{ $icon }}" alt="">
                @endforeach              
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

  $('#btnAddCompletionActivity').click(function () {
    activityIndex++;
    $('#dynamic-activity-container').append(`
        <div class="card shadow mb-2" id="activity-${activityIndex}">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Completion Activity ${activityModuleNo}.${activityIndex}</h6>
            <div class="dropdown no-arrow">
              <a class="text-danger pointer-cursor" role="button" onclick="deleteActivity(${activityIndex})">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>

          <div class="card-body">

          <div class="form-group row">
              <div class="col-md-12">
                <input type="hidden" class="form-control  activity-index" readonly name="completion_activity_no[]" value="${activityModuleNo}.${activityIndex}" required>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Name</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="completion_activity_name[]" value="" required  >
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
              <input type="hidden" id="activity-icon-${activityIndex}" name="completion_activity_icon[]">
              <div class="col-md-12" id="activity-icon-container-${activityIndex}">
                @foreach($fileIcons as $icon)
                  <img class="p-2 select-activity-icon pointer-cursor" data-index="${activityIndex}" src="{{ $icon }}" alt="">
                @endforeach              
              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Content</label>
              <div class="col-md-12">
                <textarea name="completion_activity_content[]" class="" id="activity_content-${activityIndex}" cols="30" rows="10"></textarea>
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
              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
              <input type="hidden" id="activity-icon-${activityIndex}" name="downloadable_activity_icon[]">
              <div class="col-md-12" id="activity-icon-container-${activityIndex}">
                @foreach($fileIcons as $icon)
                  <img class="p-2 select-activity-icon pointer-cursor" data-index="${activityIndex}" src="{{ $icon }}" alt="">
                @endforeach              
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

  $('#btnAddFinalExam').click(function () {
    let routeId = {{ $module->id }};
    location.href = `/admin/module/${routeId}/final/exam`;
  });

  function applyCKEditorDynamically() {
    editor = CKEDITOR.replace( `activity_content-${activityIndex}`, { tabSpaces: 4 } );
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

    editor.addCommand("courseDesign", {
       exec: function(edt) {
           edt.insertHtml(`<a href="/admin/course/design/${courseId}">Course Design</a>`);
       }
    });

   editor.addCommand("pdfIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png" />`);
       }
    });

   editor.addCommand("activityIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/course_design_icon_jfq35v.png" />`);
       }
    });

   editor.addCommand("pptIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png" />`);
       }
    });

   editor.addCommand("finalExamIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png" />`);
       }
    });

   editor.addCommand("cerficateIcon", {
       exec: function(edt) {
           edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png" />`);
       }
    });


    editor.ui.addButton('AddPDFicon', {
        label: "Add PDF Icon",
        command: 'pdfIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png'
    });

    editor.ui.addButton('addActivityIcon', {
        label: "Add Activity Icon",
        command: 'activityIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601888589/icons/course_design_icon_ljqk9r.png'
    });


    editor.ui.addButton('addPPTicon', {
        label: "Add Powerpoint icon",
        command: 'pptIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png'
    });

    editor.ui.addButton('addFinalExam', {
        label: "Add Final Exam icon",
        command: 'finalExamIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png'
    });

    editor.ui.addButton('addCertificateIcon', {
        label: "Add Certificate icon",
        command: 'cerficateIcon',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png'
    });
 
    editor.ui.addButton('CourseDesignButton', {
       label: "Add Course Design",
       command: 'courseDesign',
       toolbar: 'insert',
       icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890160/icons/mortarboard_frosqa.png'
    });

    editor.ui.addButton('AddFileButton', {
        label: "Add Downloable file",
        command: 'addFile',
        toolbar: 'insert',
        icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890164/icons/folder_pk0fos.png'
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

   $(document).on('click', 'img.select-activity-icon', function (e) {
        let index = $(this).attr('data-index');
        let iconSource = $(this).attr('src');
        
        // if the user select another let's change all the background of icons.
        if ($(`#activity-icon-${index}`).val().length != 0) {
          $(`#activity-icon-container-${index}`).children().each(function (index, element) {
            $(element).css('background', '#ffffff');
          });  
        }
        // Then apply the style to the selected icon.
        $(this).css('background', '#4e73df');
        
        $(`#activity-icon-${index}`).val(iconSource);
  });

</script>

<script>
  // For form validation check if there's ckeditor error content.
   $('textarea').each(function(index, element) {
      
      if (typeof $(element).attr('id') != 'undefined' && $(element).attr('id').includes('from_error_')) {

         var validateEditor = CKEDITOR.replace($(element).attr('id'), { tabSpaces: 4 } );
           validateEditor.addCommand("addFile", {
            exec: function(edt) {
              selectedActivityContent = edt;
              $('#addFileInActivityModal').modal('toggle');
            }
        });

        validateEditor.ui.addButton('SuperButton', {
            label: "Add downloable",
            command: 'addFile',
            toolbar: 'insert',
            icon: 'https://avatars1.githubusercontent.com/u/5500999?v=2&s=16'
        });


       validateEditor.addCommand("courseDesign", {
           exec: function(edt) {
               edt.insertHtml(`<a href="/admin/course/design/${courseId}">Course Design</a>`);
           }
        });

       validateEditor.addCommand("pdfIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png" />`);
           }
        });

       validateEditor.addCommand("activityIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/course_design_icon_jfq35v.png" />`);
           }
        });

       validateEditor.addCommand("pptIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png" />`);
           }
        });

       validateEditor.addCommand("finalExamIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png" />`);
           }
        });

       validateEditor.addCommand("cerficateIcon", {
           exec: function(edt) {
               edt.insertHtml(`<img src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png" />`);
           }
        });


        validateEditor.ui.addButton('AddPDFicon', {
            label: "Add PDF Icon",
            command: 'pdfIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/pdf_icon_nfqvrw.png'
        });

        validateEditor.ui.addButton('addActivityIcon', {
            label: "Add Activity Icon",
            command: 'activityIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601888589/icons/course_design_icon_ljqk9r.png'
        });


        validateEditor.ui.addButton('addPPTicon', {
            label: "Add Powerpoint icon",
            command: 'pptIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/powerpoint-24_moxfoh.png'
        });

        validateEditor.ui.addButton('addFinalExam', {
            label: "Add Final Exam icon",
            command: 'finalExamIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889372/icons/final-exam_mdj9vl.png'
        });

        validateEditor.ui.addButton('addCertificateIcon', {
            label: "Add Certificate icon",
            command: 'cerficateIcon',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601889768/icons/cerificate_hvcpx5.png'
        });
     
        validateEditor.ui.addButton('CourseDesignButton', {
           label: "Add Course Design",
           command: 'courseDesign',
           toolbar: 'insert',
           icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890160/icons/mortarboard_frosqa.png'
        });

        validateEditor.ui.addButton('AddFileButton', {
            label: "Add Downloable file",
            command: 'addFile',
            toolbar: 'insert',
            icon: 'https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601890164/icons/folder_pk0fos.png'
        });
      }
   });
</script>

@endpush
@endsection