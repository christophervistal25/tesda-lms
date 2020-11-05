<?php

namespace App\Http\Controllers\Admin;

use App\Comment;
use App\Course;
use App\Http\Controllers\Controller;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['course', 'postBy', 'comments'])->orderBy('created_at', 'DESC')->get();
        return view('admin.forum.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $courses = Course::get();
        return view('admin.forum.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = Post::create([
            'title' => $request->title,
            'body' => $request->body,
            'course_id' => $request->course,
            'posted_by' => Auth::user()->id,
        ]);

        if (!is_null($request->course)) {
            $course = $post->course->name;    
            return back()->with('success', 'Successfully add new post for ' . $course);
        } 

        return back()->with('success', 'Successfully add new post');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        return view('admin.forum.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $courses = Course::get();
        $post = Post::find($id);
        return view('admin.forum.edit', compact('post', 'courses'));
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
        $this->validate($request, [
            'title'  => 'required',
            'body'   => 'required',
            'course' => 'required',
        ]);

        $post = Post::find($id);
        $post->title     = $request->title;
        $post->body      = $request->body;
        $post->course_id = $request->course;
        $post->save();
        return back()->with('success', 'Successfully update '. $post->title);
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
