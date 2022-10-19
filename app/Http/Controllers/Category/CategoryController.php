<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Requests\Category\CategoryRequest;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return CategoryResource::collection(Category::all());
       // return CategoryResource::collection(Category::paginate(2));
      // return  CategoryCollection::collection(Category::all());
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
    public function store(CategoryRequest $request)
    {
        //

        $data = $request->validated();

        $category = new Category;
        $category->category_name = $data['category_name'];



        if ($request->hasfile('image'))
        {
           $destination = 'uploads/category/'.$category->image;
           if(File::exists($destination)){
               File::delete($destination);
           }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file ->move('uploads/post/', $filename);
            $category->image = $filename;
        }

        $category->save();
/*
        return response([
            'data' => new CategoryRequest([$category])
        ], 201);
*/
        return response()->json([
            "success" => true,
            "message" => "File successfully uploaded",
            "image" => $file
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
      // return $category;

        return new CategoryResource($category);


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
    public function update(CategoryRequest $request, $id)
    {
        //
        $data = $request->validated();
        $category = Category::find($id);
        $category->category_name = $data['category_name'];

        if ($request->hasfile('image'))
        {
           $destination = 'uploads/category/'.$category->image;
           if(File::exists($destination)){
               File::delete($destination);
           }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file ->move('uploads/post/', $filename);
            $category->image = $filename;
        }

        $category->update();

        return response()->json([
            "success" => true,
            "message" => "File successfully updated",

        ], 201);



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($category_id)
    {
        //

        $category = Category::find($category_id);

        $destination = 'uploads/post/'.$category->image;

        if(File::exists($destination)){
            File::delete($destination);
        }

        $category -> delete();

        return response(null, 204);
    }
}
