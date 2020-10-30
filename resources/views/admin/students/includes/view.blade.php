@if(!$student->courses->isEmpty())
	<a href="{{ route('student.show.progress', $student->id) }}" class="btn btn-primary btn-sm">Module</a>
@endif
	<a href="{{ route('student.edit', $student->id) }}" class="btn btn-success btn-sm">Edit</a>