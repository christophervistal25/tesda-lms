@if(!$student->courses->isEmpty())
	<a href="{{ route('student.show.progress', $student->id) }}" class="btn btn-primary btn-sm">Module</a>
@endif