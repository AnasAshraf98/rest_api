<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Resources\Tag as TagResource;

class TagController extends Controller
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
        $tag=TagResource::collection(Tag::paginate($limit));
        return response($tag, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create',Tag::class);
        $tag=new TagResource(Tag::create($request->all()));
        return response($tag, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag=new TagResource(Tag::findOrFail($id));
        return response($tag, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //$idTag=Tag::findOrFail($id);
        $this->authorize('update'/* ,$idTag */);
        $tag = new TagResource(Tag::findOrFail($id));
        $tag->update($request->all());
        return response($tag, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $idTag=Tag::findOrFail($id);
        $this->authorize('delete',$idTag);

        Tag::findOrFail($id)->delete();

        return 204;
    }
}
