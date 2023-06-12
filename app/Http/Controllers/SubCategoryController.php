<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Http\Requests\StoreSubCategoryRequest;
use App\Http\Requests\UpdateSubCategoryRequest;

class SubCategoryController extends Controller
{
    // JWT Middleware
    //  public function __construct(){
    //     $this->middleware('JWTCheck');
    //  }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $data =  SubCategory::all();
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
    public function store(StoreSubCategoryRequest $request)
    {
        try {
            $data = SubCategory::create($request->all());
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
    public function show(SubCategory $subCategory)
    {
        try {
            $data = SubCategory::find($subCategory->id);
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
    public function edit(SubCategory $subCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubCategoryRequest $request, SubCategory $subCategory)
    {
        try {
            $data =  SubCategory::find($subCategory->id);
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
    public function destroy(SubCategory $subCategory)
    {
        $data =  SubCategory::find($subCategory->id);
        if ($data->exists) {
            $data = SubCategory::destroy($subCategory->id);
            return  response()->json(['status' => 'Ok', 'message' => 'Deleted Sucessfully'], 204);
        } else {

            return response()->json(['status' => 'error', 'message' => 'Resource not found'], 404);
        }
    }
}
