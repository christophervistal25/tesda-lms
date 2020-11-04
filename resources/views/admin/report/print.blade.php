<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Document</title>
		<style>
			@font-face {
				font-family: 'Poppins';
				src: {{ storage_path('/fonts/Poppins-Regular.ttf') }}
			}
			body {
				font-family: "Poppins", sans-serif;
			}
			.page-break {
			    page-break-after: always;
			}
		</style>
	</head>
	<body>
		Registered Students <span style="margin-right : 70px;">&nbsp;</span>: {{ $data['registeredStudents']->count() }}
		<br>
		No. of enrolled Students <span style="margin-right : 44px;">&nbsp;</span>: {{ $data['registeredWithCourse']->count() }}
		<br>
		No. of students take final exam : {{ $data['registeredWithFinalExam']->count() }}
		<br>
		<br>
		<h3>Registered Students</h3>
		<table border="1" width="100%" style="border-collapse : collapse;">
			<thead>
				<tr>
					<th>Fullname</th>
					<th>Email</th>
					<th>City/Town</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['registeredStudents'] as $student)
				<tr>
					<td><center>{{ $student->name }}</center></td>
					<td>{{ $student->email }}</center></td>
					<td><center>{{ $student->city_town }}</center></td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<div class="page-break"></div>	
		<h3>Registered Student With Enrolled Service</h3>
		<table border="1" width="100%" style="border-collapse : collapse;">
			<thead>
				<tr>
					<th>Fullname</th>
					<th>Email</th>
					<th>City/Town</th>
					<th>Enrolled</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['registeredWithCourse'] as $student)
				<tr>
					<td>{{ $student->name }}</td>
					<td>{{ $student->email }}</td>
					<td>{{ $student->city_town }}</td>
					<td>{{ $student->courses->last()->course->acronym }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		<br>
		<div class="page-break"></div>	
		<h3>Registered Student with Final Exam Passed</h3>
		<table border="1" width="100%" style="border-collapse : collapse;">
			<thead>
				<tr>
					<th>Fullname</th>
					<th>Email</th>
					<th>City/Town</th>
					<th>Enrolled</th>
				</tr>
			</thead>
			<tbody>
				@foreach($data['registeredWithFinalExam'] as $student)
				<tr>
					<td>{{ $student->name }}</td>
					<td>{{ $student->email }}</td>
					<td>{{ $student->city_town }}</td>
					<td>{{ $student->courses->last()->course->acronym }}</td>
				</tr>
				@endforeach
			</tbody>
		</table>
	</body>
</html>