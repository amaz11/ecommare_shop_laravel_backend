<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{
    // JWT Middleware
    public function __construct()
    {
        $this->middleware(['JWTCheck', "JWTAdmin"]);
    }

    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        try {
            $data =  Product::with('subcategory.categorys')->get();
            return response()->json([
                'data' => $data,
                'status' => "ok"
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'message' => "error",
                'error' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $data = Product::create($request->all());
            return response()->json($data = [
                'message' => "Insert Succesfully",
                'data' => $data,

            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => "error",
                'error' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        try {
            $data = Product::with('subcategory.categorys')->find($product->id);
            if ($data->exists) {
                return response()->json(['status' => 'ok', 'data' => $data], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Resource not found'], 404);
            }
        } catch (\Exception $error) {
            return response()->json([
                'message' => "error",
                'error' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        try {
            $data =  Product::find($product->id);
            if ($data->exists) {
                $data->update($request->all());
                return response()->json(['status' => 'ok', 'data' => $data], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Resource not found'], 404);
            }
        } catch (\Exception $error) {
            return response()->json([
                'message' => "error",
                'error' => $error->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $data =  Product::find($product->id);
        if ($data->exists) {
            $data = Product::destroy($product->id);
            return  response()->json(['status' => 'Ok', 'message' => 'Deleted Sucessfully'], 204);
        } else {

            return response()->json(['status' => 'error', 'message' => 'Resource not found'], 404);
        }
    }
}
