<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use Illuminate\Http\Request;
use App\Http\Resources\Lesson as LessonResource;

class LessonController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit=$request->input('limit') <=4 ? $request->input('limit'): 2;
        $lesson=LessonResource::collection(Lesson::paginate($limit));
        return response($lesson, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$id)
    {
        $lesson=new LessonResource(Lesson::create($request->all()));
        return response($lesson, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $lesson=new LessonResource(Lesson::findOrFail($id));
        return response($lesson, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $idLesson=Lesson::findOrFail($id);
        $this->authorize('update',$idLesson);
        $lesson = new LessonResource(Lesson::findOrFail($id));
        $lesson->update($request->all());
        return response($lesson, 200);;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idLesson=Lesson::findOrFail($id);
        $this->authorize('delete',$idLesson);

        Lesson::findOrFail($id)->delete();

        return 204;
    }
}
