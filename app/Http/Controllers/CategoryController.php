<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller

{
    /**
     * Display a listing of the resource.
     */

    //  public function __construct(){
    //     $this->middleware('JWTCheck');
    //  }
    public function index()
    {
        try {
            $data =  Category::all();
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
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $data = Category::create($request->all());
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
    public function show(Category $category)
    {
        try {
            $data =  Category::find($category->id);
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
    public function edit(Category $category)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            $data =  Category::find($category->id);
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
    public function destroy(Category $category)
    {
        $data =  Category::find($category->id);
        if ($data->exists) {
            $data = category::destroy($category->id);
            return  response()->json(['status' => 'Ok', 'message' => 'Deleted Sucessfully'], 204);
        } else {

            return response()->json(['status' => 'error', 'message' => 'Resource not found'], 404);
        }
    }
}
