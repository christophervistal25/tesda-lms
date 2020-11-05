<?php

// Home
Breadcrumbs::for('dashboard', function ($trail) {
    $trail->push('Dashboard', route('admin.dashboard'));
});

// Batch
Breadcrumbs::for('batch', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Batch');
});

// Program
Breadcrumbs::for('programs', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Program');
});

// Instructors
Breadcrumbs::for('instructors', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Instructors', route('instructor.index'));
});

// Instructors - Add
Breadcrumbs::for('instructor-add', function ($trail) {
	$trail->parent('instructors');
    $trail->push('Instructor Add');
});

// Instructors - Edit
Breadcrumbs::for('instructor-edit', function ($trail) {
	$trail->parent('instructors');
    $trail->push('Instructor Edit');
});

// Student
Breadcrumbs::for('students', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Students', route('student.index'));
});

// Events
Breadcrumbs::for('events', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Events');
});

// Announcements
Breadcrumbs::for('announcements', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Announcements & Forums', route('forums.index'));
});

// Announcements - create
Breadcrumbs::for('announcements-create', function ($trail) {
	$trail->parent('announcements');
    $trail->push('Create new announcement');
});

// Announcements - edit
Breadcrumbs::for('announcements-edit', function ($trail, $post) {
    $trail->parent('announcements');
    $trail->push("Edit {$post->title}");
});

// Reports
Breadcrumbs::for('reports', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Reports');
});

// Course
Breadcrumbs::for('course', function ($trail) {
	$trail->parent('dashboard');
    $trail->push('Course', route('course.index'));
});

// Course Edit
Breadcrumbs::for('course-add', function ($trail) {
	$trail->parent('course');
    $trail->push('Create new course');
});

// Course Edit
Breadcrumbs::for('course-edit', function ($trail, $course) {
	$trail->parent('course');
    $trail->push('Course Edit - ' . $course->acronym);
});

// Course Design
Breadcrumbs::for('course-design', function ($trail, $course) {
	$trail->parent('course');
    $trail->push('Course Design', route('course.design', $course->id));
});

// Course Overview add
Breadcrumbs::for('course-add-overview', function ($trail) {
	$trail->parent('course');
    $trail->push('Course overview add');
});

// Course Overview edit
Breadcrumbs::for('course-edit-overview', function ($trail) {
	$trail->parent('course');
    $trail->push('Course overview edit');
});

// Course Badges
Breadcrumbs::for('course-badges', function ($trail, $course) {
	$trail->parent('course', $course);
    $trail->push($course->acronym . ' - Badges', route('badge.course.show', $course->id));
});


// Course Add Badge
Breadcrumbs::for('course-add-badge', function ($trail, $course) {
	$trail->parent('course', $course);
    $trail->push('Create Badge for ' . $course->acronym);
});

// Course Edit Badge
Breadcrumbs::for('course-edit-badge', function ($trail, $course) {
	$trail->parent('course-badges', $course);
    $trail->push('Edit Badge of ' . $course->acronym);
});


// Course Add
Breadcrumbs::for('course-add-module', function ($trail, $course) {
	$trail->parent('course');
    $trail->push('Add Module - ' . $course->acronym);
});

// Course View module
Breadcrumbs::for('course-view-module', function ($trail, $course) {
	$trail->parent('course');
    $trail->push('Course - ' . $course->name, route('course.view.module', $course->id));
});


// Course Edit module
Breadcrumbs::for('course-edit-module', function ($trail, $module) {
	$trail->parent('course-view-module', $module->course);
    $trail->push('Edit Module - ' . $module->title, route('course.edit.module', $module->id));
});

// Create final exam
Breadcrumbs::for('create-final-exam', function ($trail, $module) {
	$trail->parent('course-edit-module', $module);
    $trail->push('Create Final Exam');
});

// Create final exam
Breadcrumbs::for('create-update-exam', function ($trail, $exam) {
	$trail->parent('course-edit-module', $exam->module);
    $trail->push('Update Final Exam');
});



// // Home > Blog
// Breadcrumbs::for('blog', function ($trail) {
//     $trail->parent('home');
//     $trail->push('Blog', route('blog'));
// });

// // Home > Blog > [Category]
// Breadcrumbs::for('category', function ($trail, $category) {
//     $trail->parent('blog');
//     $trail->push($category->title, route('category', $category->id));
// });

// // Home > Blog > [Category] > [Post]
// Breadcrumbs::for('post', function ($trail, $post) {
//     $trail->parent('category', $post->category);
//     $trail->push($post->title, route('post', $post->id));
// });