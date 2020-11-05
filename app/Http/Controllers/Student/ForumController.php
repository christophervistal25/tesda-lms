<?php

namespace App\Http\Controllers\Student;

use App\Comment;
use App\Http\Controllers\Controller;
use App\Post;
use App\Repositories\StudentRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $student = Auth::user();
        $discussions = $this->studentRepository->getCourse()->discussions;
        return view('student.forum.index', compact('discussions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $studentCourse = $this->studentRepository->getCourse();
        $post = Post::find($id);

        if ($studentCourse->id !== $post->course_id) {
            // The user can't access this kind of course.
            return redirect()->back();
        }
        return view('student.forum.show', compact('post'));
    }

    public function addComment(Request $request, $postId)
    {
        $this->validate($request, [
            'body'       => 'required',
        ]);

        $post = Post::find($postId);
        
        $comment = new Comment([
            'body'       => $request->body,
            'comment_by' => Auth::user()->name
        ]);
        $post->comments()->save($comment);

        return response()->json(['success' => true, 'body' => $request->body, 'comment_by' => Auth::user()->name]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
