<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use App\Models\Product;
use App\Models\ProductItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductItemController extends Controller
{
    /**
     * get data.
     */
    public function index(string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ResponseFormatter::error(null, 'Checklist Id Not Found', 401);
        }

        $param = (object) [
            'product_id' => $id,
        ];

        $productItems = ProductItem::filter($param)
            ->get();

        return ResponseFormatter::success($productItems, 'Succesfull Get Data', 200);
    }

    /**
     * store data.
     */
    public function store(Request $request, string $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return ResponseFormatter::error(null, 'Checklist Id Not Found', 401);
        }

        $validate = Validator::make(
            $request->all(),
            [
                'name' => 'required|string',
            ]
        );

        if ($validate->fails()) {
            return ResponseFormatter::error(null, $validate->errors(), 401);
        }

        ProductItem::create([
            'product_id' => $id,
            'name' => $request->name,
        ]);

        return ResponseFormatter::success(null, 'Succesfull Create Data', 200);
    }

    /**
     * get show data.
     */
    public function show(string $id, string $itemId)
    {
        $product = Product::find($id);

        if (!$product) {
            return ResponseFormatter::error(null, 'Checklist Id Not Found', 401);
        }

        $param = (object) [
            'product_id' => $id,
            'id' => $itemId
        ];

        $productItem = ProductItem::filter($param)
            ->first();

        if (!$productItem) {
            return ResponseFormatter::error(null, 'Checklist Item Id Not Found', 401);
        }

        return ResponseFormatter::success($productItem, 'Succesfull Get Data', 200);
    }

    /**
     * get show data.
     */
    public function destroy(string $id, string $itemId)
    {
        $product = Product::find($id);

        if (!$product) {
            return ResponseFormatter::error(null, 'Checklist Id Not Found', 401);
        }

        $param = (object) [
            'product_id' => $id,
            'id' => $itemId
        ];

        $productItem = ProductItem::filter($param)
            ->first();

        if (!$productItem) {
            return ResponseFormatter::error(null, 'Checklist Item Id Not Found', 401);
        }

        $productItem->delete();

        return ResponseFormatter::success(null, 'Succesfull Delete Data', 200);
    }
}
