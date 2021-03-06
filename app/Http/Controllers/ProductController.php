<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(3);
        //dd($products);
        return view('products',compact('products'));
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
        $product = new Product();
        $product->name = $request->has('name')?$request->name:"";
        $product->price = $request->has('price')?$request->price:"";
        $product->amount = $request->has('amount')?$request->amount:"";
        $product->is_Active = 1;
        if($request->hasFile('images')){
            $files = $request->file('images');
            $imageLocation = array();
            $i=0;
            foreach ($files as $file){
                $extension = $file->getClientOriginalExtension();
                $fileName = '/product_'.time().++$i.'.'.$extension;
                $location = '/images/uploads';
                $file->move(public_path().$location,$fileName);
                $imageLocation[] = $location.$fileName;
            }
            $product->image=implode('|',$imageLocation);
            $product->save();
            return back()->with('success','Product Successfully Saved!');
        }else{
            return back()->with('success','Product was not saved Successfully!');
        }


        /*$product->save();
        return back()->with('success','Product Successfully Saved!');*/
        //return $request->all();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
    public function addProduct(){
        $products = Product::all();
        $returnProducts = array();
        foreach ($products as $product)
        {
            $images = explode('|',$product->image);
            $returnProducts[]=[
                'name'=> $product->name,
                'price' => $product->price,
                'amount' => $product->amount,
                'image' => $images[0]
            ];

        }
        return view('add_product',compact('returnProducts'));
    }
}
