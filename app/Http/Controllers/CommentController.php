<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Auth;
use Validator;
use DB;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function index(Request $request,)
    {
        $master = DB::table('masters')
        ->join('salons', 'masters.salon_id', '=', 'salons.id')
        ->select('salons.name as salon_name', 'masters.id as id', 'masters.name as name','masters.created_at as created_at', 'salons.id as salon_id', 'masters.*')
        ->where('masters.id', $request->id)
        ->first();

        $salon = DB::table('salons')
        ->where('salons.id', $master->salon_id)
        ->get();

        $comments = DB::table('comments')
        ->join('masters', 'comments.master_id', '=', 'masters.id')
        ->join('users', 'comments.user_id', '=', 'users.id')
        ->select('users.id as user_id', 'users.name as user_name', 'masters.name as master_name', 'comments.created_at as comment_created_at','comments.*')
        ->where('comments.master_id', $master->id)
        ->orderBy('comments.created_at', 'asc')
        ->get();

        return view('front.comments.index', ['comments'=> $comments, 'master' => $master, 'salon'=> $salon]);
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
     * @param  \App\Http\Requests\StoreCommentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, )
    {
        $validator = Validator::make($request->all(),
        [
            'comment'=> ['required', 'min:5', 'max:100']
        ],[
            'comment.required' => 'Comment is required!',
            'comment.min' => 'Comment should be at least 5 symbols length!',
            'comment.max' => 'Comment should not exceed 1000 symbols!'
        ]);
        if ($validator->fails()) {
            $request->flash();
            return redirect()->back()->withErrors($validator);
        }
        $comment = New Comment;
        $comment->user_id = Auth::user()->id;
        $comment->comment = $request->comment;
        $comment->master_id = $request->master_id;
        $comment->save();

        return redirect()->route('front-comments-list', [$request->master_id])->with('message', 'Comment is added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCommentRequest  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
