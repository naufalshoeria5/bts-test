<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()
            ->get();

        return ResponseFormatter::success($products, 'Succesfull Get Data', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
            ]
        );

        if ($validate->fails()) {
            return ResponseFormatter::error(null, $validate->errors(), 401);
        }

        Product::create([
            'name' => $request->name,
        ]);

        return ResponseFormatter::success(null, 'Succesfull Create Data', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::find($id);

        if (! $product) {
            return ResponseFormatter::error(null, 'Undefined Id', 401);
        }

        $product->delete();

        return ResponseFormatter::success(null, 'Succesfull Delete Data', 200);
    }
}
