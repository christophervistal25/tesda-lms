@extends('layouts.student.app')
@section('title', '')
@section('content')
@prepend('page-css')
@endprepend
<div class="card rounded-0">
	<div class="card-body">
		<h4 class="card-title text-dark font-weight-bold">{{ $post->title }}</h4>
		<p class="text-dark">{{ $post->postBy->name }}</p>
		<p class="text-dark">{{ $post->created_at->format('l, j  F Y, h:i A') }}</p>
		<hr>
		<div class="p-3 text-dark">
				{!! $post->body !!}			
		</div>
	</div>
</div>

<div class="card rounded-0 mt-2">
	<div class="card-body">
		<h4 class="text-dark">Comments :</h4>

		<div id="post__comment__section" class="mb-2">
			@forelse($post->comments as $comment)
				<div class="card text-dark mb-2 rounded-0">
					<div class="card-body">
						<h6 class="card-title font-weight-bold"><img width="25px" class="img-profile rounded-circle" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806398/user_nqlyg3.png"> {{ $comment->comment_by }}</h6>
						<p class="card-text ml-5">{{ $comment->body }}</p>
					</div>
				</div>
				@empty
				<p class="text-center text-danger">No available comment to this post</p>
			@endforelse	
		</div>
		<hr>
		<textarea class="form-control mb-2 rounded-0 text-dark" id="user__comment" cols="10" rows="4" placeholder="Write a comment . . . "></textarea>
		<div class="float-right mr-4">
			<button class="btn btn-primary btn-sm" id="btnAddComment">Add comment</button>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
@push('page-scripts')
<script>
	$.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }	});
</script>
	<script>
		let postCommentsLength = "{{ $post->comments->count() }}";
						
		$('#btnAddComment').click(function () {
			let postId = "{{ $post->id }}";
			$.post({
				url : `/student/${postId}/user/add/comment`,
				data : { body : $('#user__comment').val() },
				success : function (response) {
					if (response.success) {
						$('#user__comment').val('');

						if (postCommentsLength == 0) {
							$('#post__comment__section').html('');
						}

						postCommentsLength++;

						$('#post__comment__section').append(`
							<div class="card text-dark mb-2 rounded-0">
							<div class="card-body">
								<h6 class="card-title font-weight-bold"><img width="25px" class="img-profile rounded-circle" src="https://res.cloudinary.com/dfm6cr1l9/image/upload/v1601806398/user_nqlyg3.png"> ${response.comment_by}</h6>
								<p class="card-text ml-5">${response.body}</p>
							</div>
						</div>
						`);	
					}
				}
			});
		});
	</script>	
@endpush
@endsection