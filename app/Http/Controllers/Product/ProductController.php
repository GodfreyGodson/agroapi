<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Models\Category;
use App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   // public function index(Category $category)
   // {
        //
    //    return ProductResource::collection($category->products);
   // }
   public function index(){
    return ProductResource::collection(Product::all());
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
    public function store(ProductRequest $request, Category $category)
    {
        /*
        $data = $request->validated();
        $product = new Product;
        $product->category_id = $data['category_id'];
        $product->product_name = $data['product_name'];
        $product->rate = $data ['rate'];
        if ($request->hasfile('image'))
        {
           $destination = 'uploads/product/'.$product->image;
           if(File::exists($destination)){
               File::delete($destination);
           }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file ->move('uploads/product/', $filename);
            $product->image = $filename;
        }

        $product->save();

        return response()->json([
            "success" => true,
            "message" => "File successfully updated",

        ], 201);*/
        $data = $request->validated();
        $product = new Product();
        $product->product_name = $data['product_name'];
        $product->rate = $data ['rate'];
        if ($request->hasfile('image'))
        {
           $destination = 'uploads/product/'.$product->image;
           if(File::exists($destination)){
               File::delete($destination);
           }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file ->move('uploads/product/', $filename);
            $product->image = $filename;
        }

        $category -> products()->save($product);
        return response([

            'data' => new ProductResource($product)


        ], 201);




    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
    public function update(ProductRequest $request, Category $category, Product $product, $id)
    {
        $data = $request->validated();
        $product = Product::find($id);
        $product->product_name = $data['product_name'];
        $product->rate = $data ['rate'];
        if ($request->hasfile('image'))
        {
           $destination = 'uploads/product/'.$product->image;
           if(File::exists($destination)){
               File::delete($destination);
           }

            $file = $request->file('image');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file ->move('uploads/product/', $filename);
            $product->image = $filename;
        }

        $category -> products()->save($product);
        return response([

            'data' => new ProductResource($product)


        ], 201);



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
