<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Products;
use Illuminate\Http\Request;
use App\Http\Requests\StoreProductsRequest;
use App\Serializers\Serializer;

class ProductsController extends Controller
{
    use Serializer;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Products::all();
    }
    public function sort($data)
    {
        return Products::orderby('price', $data)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(StoreProductsRequest $request)
    {
        $validated = $request->validated();
        $final_data = $this->process($validated);
        Products::create($final_data);
        $response = ['status' => "200", 'msg' => "product created"];
        return response($response, 200);
    }
    public function CountProduct()
    {
        $data = Products::count();
        return response()->json(array("status" => 200, "data" => $data));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Products::where('id', $id)->first();
    }

    /**
     * Search the specified resource.
     *
     * @param  $name
     * @return \Illuminate\Http\Response
     */
    public function search($name)
    {
        return Products::where('name', 'like', '%' . $name . '%')->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return Products::where('id', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProductsRequest $request, $id)
    {
        $validated = $request->validated();
        $products = $this->process($validated);
        Products::where('id', $id)->update($products);
        $response = ['status' => "200", 'msg' => "product updated"];
        return response($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $products
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Products::where('id', $id)->delete();
        return response('Product Deleted Successfully', 200);
    }
}
