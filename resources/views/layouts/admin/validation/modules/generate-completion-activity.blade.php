@foreach(old('completion_activity_no') as $key => $activity_no)
	<div class="card shadow mb-2" id="activity-{{ $index }}">
         <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Completion Activity {{ $activity_no }}</h6>
            <div class="dropdown no-arrow">
              <a class="text-danger pointer-cursor" role="button" onclick="deleteActivity({{ $index }})">
                <i class="fas fa-trash"></i>
              </a>
            </div>
          </div>

          <div class="card-body">
          	 @if($errors->has('completion_activity_no.' .$key) || $errors->has('completion_activity_name.' .$key) || $errors->has('completion_activity_instructions.' .$key) || $errors->has('completion_activity_content.' .$key) || $errors->has('completion_activity_icon.' .$key))
              <div class="alert alert-danger rounded-0" role="alert">
                @foreach($errors->get('completion_activity_icon.' .$key) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('completion_activity_no.' .$key) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('completion_activity_name.' .$key) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('completion_activity_instructions.' .$key) as $error)
                  <li>{{ $error }}</li>
                @endforeach
                @foreach($errors->get('completion_activity_content.' .$key) as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </div>
            @endif

          <div class="form-group row">
              <label class="col-md-auto  text-md-right">Downloadable Activity No.</label>
              <div class="col-md-12">
                <input type="text" class="form-control  activity-index" readonly name="completion_activity_no[]" value="{{ $activity_no }}" required>
              </div>
            </div>


            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Activity Name</label>
              <div class="col-md-12">
                <input type="text" class="form-control" name="completion_activity_name[]" value="{{ old('completion_activity_name')[$key] }}" required  >
              </div>
            </div>

            <div class="form-group row">
              <label class="col-md-auto  text-md-right">Select Activity Icon</label>
              <input type="hidden" id="activity-icon-{{ $index }}" name="completion_activity_icon[]" value="{{ old('completion_activity_icon')[$key] }}">
              <div class="col-md-12" id="activity-icon-container-{{ $index }}">
                @foreach($fileIcons as $icon)
                  @if(old('completion_activity_icon')[$key] == $icon)
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
                <textarea name="completion_activity_content[]" id="from_error_completion_activity_content-{{$key}}" cols="30" rows="10">{{ old('completion_activity_content')[$key] }}</textarea>
              </div>
            </div>

          </div>
        </div>
@php $index++ @endphp
@endforeach