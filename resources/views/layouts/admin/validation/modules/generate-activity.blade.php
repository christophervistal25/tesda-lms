@php
  $downloadableKeyIndex = 0;
  $activityKeyIndex = 0;
@endphp
  
  @foreach($allOldValues as $key => $activity_no)
    @if(!is_null(old('downloadable_activity_no')) && in_array($activity_no, old('downloadable_activity_no')))
      <div class="card shadow mb-2" id="activity-{{ explode('.', $activity_no)[1] }}">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Downloadable Activity {{ $activity_no }}</h6>
            <div class="dropdown no-arrow">
              <a class="text-danger pointer-cursor" role="button" onclick="deleteActivity({{ explode('.', $activity_no)[1] }})">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>
          <div class="card-body">
            @if($errors->has('downloadable_activity_no.' .$downloadableKeyIndex) || $errors->has('downloadable_activity_name.' .$downloadableKeyIndex) || $errors->has('downloadable_activity_instructions.' .$downloadableKeyIndex) || $errors->has('downloadable_activity_content.' .$downloadableKeyIndex) || $errors->has('downloadable_activity_icon.'.$downloadableKeyIndex))
              <div class="alert alert-danger rounded-0" role="alert">
                @foreach($errors->get('downloadable_activity_icon.' .$downloadableKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('downloadable_activity_no.' .$downloadableKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('downloadable_activity_name.' .$downloadableKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('downloadable_activity_instructions.' .$downloadableKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('downloadable_activity_content.' .$downloadableKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </div>
            @endif

          <div class="form-group row">
              <label class="col-md-auto  text-md-right">Downloadable Activity No.</label>
              <div class="col-md-12">
                <input type="text" class="form-control  activity-index" readonly name="downloadable_activity_no[]" value="{{ $activity_no }}" required>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Name</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="downloadable_activity_name[]" value="{{ old('downloadable_activity_name')[$downloadableKeyIndex] }}" required  >
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Instruction</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="downloadable_activity_instructions[]" value="{{ old('downloadable_activity_instructions')[$downloadableKeyIndex] }}" required>
              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
              <input type="hidden" id="activity-icon-{{ explode('.', $activity_no)[1] }}" name="downloadable_activity_icon[]" value="{{ old('downloadable_activity_icon')[$downloadableKeyIndex] }}">
              <div class="col-md-12" id="activity-icon-container-{{ explode('.', $activity_no)[1] }}">
                @foreach($fileIcons as $icon)
                  @if(old('downloadable_activity_icon')[$downloadableKeyIndex] == $icon)
                    <img style="background : #4e73df;" class="p-2 select-activity-icon pointer-cursor" data-index="{{ explode('.', $activity_no)[1] }}" src="{{ $icon }}" alt="">
                    @else
                    <img class="p-2 select-activity-icon pointer-cursor" data-index="{{ explode('.', $activity_no)[1] }}" src="{{ $icon }}" alt="">
                  @endif
                @endforeach              
              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Content</label>
              <div class="col-md-12">
                <textarea name="downloadable_activity_content[]" id="from_error_downloadable_activity_content-{{$downloadableKeyIndex}}" cols="30" rows="10">{{ old('downloadable_activity_content')[$downloadableKeyIndex] }}</textarea>
              </div>
            </div>

          </div>
        </div>
        @php $downloadableKeyIndex++ @endphp
    @endif

    @if(!is_null(old('activity_no'))  && in_array($activity_no, old('activity_no')))
        <div class="card shadow mb-2" id="activity-{{ explode('.', $activity_no)[1] }}">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Activity {{ $activity_no }}</h6>
            <div class="dropdown no-arrow">
              <a class="text-danger pointer-cursor" role="button" onclick="deleteActivity({{ explode('.', $activity_no)[1] }})">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>

          <div class="card-body">
             @if($errors->has('activity_no.' .$activityKeyIndex) || $errors->has('activity_name.' .$activityKeyIndex) || $errors->has('activity_instructions.' .$activityKeyIndex) || $errors->has('activity_content.' .$activityKeyIndex) || $errors->has('activity_icon.' .$activityKeyIndex))
              <div class="alert alert-danger rounded-0" role="alert">
                @foreach($errors->get('activity_icon.' .$activityKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('activity_no.' .$activityKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('activity_name.' .$activityKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('activity_instructions.' .$activityKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('activity_content.' .$activityKeyIndex) as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </div>
            @endif

          <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity No.</label>
              <div class="col-md-12">
                <input type="text" class="form-control  activity-index" readonly name="activity_no[]" value="{{ $activity_no }}" required>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Name</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="activity_name[]" value="{{ old('activity_name')[$activityKeyIndex] }}" required  >
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Instruction</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="activity_instructions[]" value="{{ old('activity_instructions')[$activityKeyIndex] }}" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
              <input type="hidden" id="activity-icon-{{ explode('.', $activity_no)[1] }}" name="activity_icon[]" value="{{ old('activity_icon')[$activityKeyIndex] }}">
              <div class="col-md-12" id="activity-icon-container-{{ explode('.', $activity_no)[1] }}">
                @foreach($fileIcons as $icon)
                  @if(old('activity_icon')[$activityKeyIndex] == $icon)
                    <img style="background : #4e73df;" class="p-2 select-activity-icon pointer-cursor" data-index="{{ explode('.', $activity_no)[1] }}" src="{{ $icon }}" alt="">
                    @else
                    <img class="p-2 select-activity-icon pointer-cursor" data-index="{{ explode('.', $activity_no)[1] }}" src="{{ $icon }}" alt="">
                  @endif
                  
                @endforeach              
              </div>
            </div>

             <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Content</label>
              <div class="col-md-12">
                <textarea name="activity_content[]" id="from_error_activity_content-{{$activityKeyIndex}}" cols="30" rows="10">{{ old('activity_content')[$activityKeyIndex] }}</textarea>
              </div>
            </div>

          </div>
        </div>
        @php $activityKeyIndex++ @endphp
    @endif
    
  @endforeach

