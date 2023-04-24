<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Validator;

class ProductController extends Controller
{ 
    public function index()
    {
        try {
            $products = Product::all();        
            return response()->json([
                "results" => $products
            ], Response::HTTP_OK);
            // return view('welcome', compact('products'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => '404 not found'
            ], 404);
        }
    }    
    
    public function store(Request $request)
    {
        try {
            // validamos los datos
            $rules = array(
                "description" => "required|string",
                "stock" => "required|numeric|min:0",
                "category_id" => "required"
            );
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }
            $category = Category::findOrFail($request->category_id);
            $product = $category->products()->create([
                'description' => $request->description,
                'stock' => $request->stock,
            ]);
            //devolvemos una rpta
            return response()->json([
                "result" => $product
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
       $product = Product::find($id);
        return response()->json([
            "result" => $product
        ], Response::HTTP_OK);
    }

    public function update(Request $request, $product_id)
    {
        try {
            $rules = array(
                "description" => "required|string",
                "stock" => "required|numeric|min:0",
                "category_id" => "required|numeric"
            );
            $validator=Validator::make($request->all(),$rules);
            if($validator->fails())
            {
                return $validator->errors();
            }
            $category = Category::findOrFail($request->category_id);
            $product = $category->products()->where('id', $product_id)->update([
                'description' => $request->description,
                'stock' => $request->stock,
            ]);
            return response()->json([
                "message" => "¡Producto actualizado!",
                "result" => $product
            ], Response::HTTP_OK);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response([
                'status' => 'ERROR',
                'error' => '404 not found'
            ], 404);
        }
    }

    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return response()->json([
            "message" => "¡Product deleted!"            
        ], Response::HTTP_OK);
        
    }
}