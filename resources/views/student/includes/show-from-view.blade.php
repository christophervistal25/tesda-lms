<div class="row">
						<div class="col-lg-6" id="view-card-type">
							<div class="card rounded-0 course-card-{{ $record->course->id }}" data-id="{{ $record->course->id }}">
								<a href="/student/course/view/{{$record->course->id}}}">
									<div class="course-header" data-background="{{ str_replace(['c_fit,', 'w_150', 'h_150,'], '', $record->course->image) }}"></div>
								</a>
								<div class="card-body">
									<div class="row">
										<div class="col-lg-10">
											<div class="text-muted">
												<span>{{ $record->course->program->name }}</span>
											</div>
											<span id="course-name-{{ $record->course->id }}">
												<i class="fas fa-star text-primary star-icon-{{ $record->course->id }} {{ $hasStar }}"></i>
												<a  href="/student/course/view/{{ $record->course->id }}">{{ $record->course->name }}</a>
											</span>
										</div>
										<div class="col-lg-2 text-right">
											<button class="btn btn-link btn-icon icon-size-3 coursemenubtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="yui_3_17_2_1_1602503905824_137">
											<i class="icon fa fa-ellipsis-h fa-fw"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right rounded-0 text-dark" style="will-change: transform;">
												<div class="course-{{$record->course->id}}-option-button">
													@if($record->course->status && $record->course->status->count() !== 0 && $record->course->status->star == 1)
														<a class="dropdown-item cursor-pointer remove-star-course"  data-id="{{ $record->course->id }}">
														Unstar this course
													</a>
													@else
														<a class="dropdown-item cursor-pointer add-star-course"  data-id="{{ $record->course->id }}">
														Star this course
														</a>	
													@endif	
												</div>
												
												<a class="dropdown-item cursor-pointer remove-from-view" data-id="{{ $record->course->id }}">
													Remove from view
												</a>
											</div>
										</div>
									</div>
									
									<div class="pt-3">
										<div class="progress rounded-0" style="height : .8vh">
											<div class="progress-bar" id="course-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%;"></div>
										</div>
									</div>
									<div class="mt-3">
										<span><small><b>{{ $progress }}</b>% complete</small></span>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 d-none" id="view-list-type">
							<div class="card rounded-0 course-card-{{ $record->course->id }}" data-id="{{ $record->course->id }}">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-5">
											{{ $currentCourse->program->name }}
											<br>
											<span id="course-name-{{ $record->course->id }}">
												<i  class="fas fa-star text-primary star-icon-{{ $record->course->id }} {{ $hasStar }}"></i>
												<a  href="/student/course/view/{{ $record->course->id }}">{{ $record->course->name }}</a>
											</span>
										</div>
										<div class="col-lg-5">
											<div class="progress rounded-0" style="height : .8vh">
												<div class="progress-bar" id="course-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%;"></div>
											</div>
											<div class="py-2 mt-1 small">
												<span><b>{{ $progress }}</b>% complete</span>
											</div>
										</div>
										<div class="col-lg-2 text-right">
											<button class="btn btn-link btn-icon icon-size-3 coursemenubtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="yui_3_17_2_1_1602503905824_137">
											<i class="icon fa fa-ellipsis-h fa-fw " aria-hidden="true" id="yui_3_17_2_1_1602503905824_136"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right rounded-0 text-dark" style="will-change: transform;">
												<div class="course-{{$record->course->id}}-option-button">
													@if($record->course->status && $record->course->status->count() !== 0 && $record->course->status->star == 1)
														<a class="dropdown-item cursor-pointer remove-star-course" data-id="{{ $record->course->id }}">
														Unstar this course
													</a>
													@else
														<a class="dropdown-item cursor-pointer add-star-course"  data-id="{{ $record->course->id }}">
														Star this course
														</a>	
													@endif	
												</div>
												
												<a class="dropdown-item cursor-pointer remove-from-view" data-id="{{ $record->course->id }}">
													Remove from view
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12 d-none" id="view-summary-type">
							<div class="card rounded-0 course-card-{{ $record->course->id }}" data-id="{{ $record->course->id }}" style="background :#eef5f9">
								<div class="card-body">
									<div class="row">
										<div class="col-lg-1">
											<img class="img-thumbnail img-fluid rounded-circle" src="{{ $currentCourse->image }}" alt="">
										</div>
										<div class="col-lg-5">
											<span class="text-muted">{{ $currentCourse->program->name }}</span>
											<br>
											<span id="course-name-{{ $record->course->id }}">
												<i class="fas fa-star text-primary star-icon-{{ $record->course->id }} {{ $hasStar }}"></i>
												<a  href="/student/course/view/{{ $record->course->id }}">{{ $record->course->name }}</a>
											</span>
										</div>
										<div class="col-lg-4">
											<br>
											<br>
											<div class="progress rounded-0" style="height : .8vh">
												<div class="progress-bar" id="course-progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" style="width:{{ $progress }}%;"></div>
											</div>
											<div class="py-2 mt-1 small">
												<span><b>{{ $progress }}</b>% complete</span>
											</div>
										</div>
										<div class="col-lg-2 text-right">
											<button class="btn btn-link btn-icon icon-size-3 coursemenubtn" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" id="yui_3_17_2_1_1602503905824_137">
											<i class="icon fa fa-ellipsis-h fa-fw"></i>
											</button>
											<div class="dropdown-menu dropdown-menu-right rounded-0" style="will-change: transform;">
												<div class="course-{{$record->course->id}}-option-button">
													@if($record->course->status && $record->course->status->count() !== 0 && $record->course->status->star == 1)
														<a class="dropdown-item cursor-pointer remove-star-course" data-id="{{ $record->course->id }}">
														Unstar this course
													</a>
													@else
														<a class="dropdown-item cursor-pointer add-star-course"  data-id="{{ $record->course->id }}">
														Star this course
														</a>	
													@endif	
												</div>
												<a class="dropdown-item cursor-pointer remove-from-view" data-id="{{ $record->course->id }}">
													Remove from view
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>