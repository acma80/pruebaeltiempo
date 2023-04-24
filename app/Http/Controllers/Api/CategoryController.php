<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    
    public function index()
    {
        try {
            $categorys = Category::all();
            return response()->json([
                "results" => $categorys
            ], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => 'Dato no encontrado'
            ], 404);
        }
    }
        
    public function store(Request $request)
    {
        try {
            //validamos los datos
            $rules = array(
                "description" => "required|string"
            );
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }
            //damos de alta en la DB
            $category = Category::create([
                "description" => $request->description
            ]);
            //devolvemos una rpta
            return response()->json([
                "result" => $category
            ], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => 'Dato no encontrado'
            ], 404);
        }
    }
    
    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
            return $category;
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => 'Dato no encontrado'
            ], 404);
        }
    }
    
    public function update(Request $request, $id)
    {
        try {
            //validamos los datos
            $rules = array(
                "description" => "required|string"
            );
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }
            //actualizamos en la DB
            $category = Category::find($id);
            $category->description = $request->description;
            $category->save();
            //devolvemos una rpta
            return response()->json([
                "result" => $category
            ], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => 'Dato no encontrado'
            ], 404);
        }
    }

    public function destroy($id)
    {
        try {
            Category::findOrFail($id)->delete();
            //devolvemos una rpta
            return response()->json([
                "result" => "Category deleted"
            ], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => 'Dato no encontrado'
            ], 404);
        }
    }
}