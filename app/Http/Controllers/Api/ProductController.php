<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Store;
use App\Services\ArticleService;
use Exception;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private $_model;
    private $storeModel;
    private $articleService;

    public function __construct(
        Product $productModel,
        ArticleService $articleService,
        Store $storeModel
        )
    {
        $this->_model = $productModel;
        $this->articleService = $articleService;
        $this->storeModel = $storeModel;
    }

    public function index($limit = 10) {
        $listPaginated = $this->_model->paginate($limit);

        return response()->json($listPaginated,200);
    }

    public function store(Request $request) {
        try {
            DB::beginTransaction();
            $data = $request->all();
            if (isset($request->image)) {
                $imagePath =
                    $this->articleService->handleUploadedImage(
                        $request->image,
                        $request->name,
                        'products'
                    );
                unset($data['image']);
                $data['image'] = $imagePath;
            }
            $createdProduct = $this->_model->create($data);
            DB::commit();

            return response()->json(['product' => $createdProduct], 200);
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json([
                'message' => $err->getMessage()
            ], 500);
        }
    }

    public function show($id) {
        try {
            $product = $this->_model->where('id', $id)->first();
            if ($product === null) {
                return response()->json(['message' => "Not found product by id " . $id], 400);
            }
            return response()->json(['product' => $product], 200);
        } catch (Exception $err) {
            return response()->json(['message' => $err], 500);
        }
    }

    public function update($id, ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $product = $this->_model->where('id', $id)->first();

            if ($product === null) {
                throw new Exception('Not found product Id');
            }

            $checkedHasStore = $this->storeModel->where('id', $request->store_id)->first();
            if($checkedHasStore === null) {
                throw new Exception('Not has Store by Id');
            }

            $product->name = $request->name;
            $product->status = $request->status;
            $product->description = $request->description;
            $product->product_code = $request->product_code;
            $product->product_type = $request->product_type;
            $product->import_price = $request->import_price;
            $product->price = $request->price;


            if (isset($request->image)) {
                $imagePath =
                    $this->articleService->handleUploadedImage(
                        $request->image,
                        $request->name,
                        'products'
                    );
                $product->image = $imagePath;
            }
            if (isset($request->sold)) {
                $product->sold = $request->sold;
            }
            if (isset($request->total)) {
                $product->total = $request->total;
            }

            $product->save();
            DB::commit();

            return response()->json(['product' => $product], 200);
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['message' => $err->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $product = $this->_model->where('id', $id)->first();
            if ($product === null) {
                throw new Exception('Not found product Id');
            }

            $product->delete();
            DB::commit();

            return response()->json(["message" => "Product deleted successful"], 200);
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['message' => $err->getMessage()], 500);
        }
    }

    public function search($keyword, $limit = 10)
    {
        try {
            DB::beginTransaction();
            $productSearch = $this->_model
                ->where('name', 'like', '%' . $keyword . '%')
                ->orWhere('description', 'like', '%' . $keyword . '%')
                ->orWhere('product_code', 'like', '%' . $keyword . '%')
                ->paginate($limit);
            DB::commit();

            return response()->json(['result' => $productSearch], 200);
        } catch (Exception $err) {
            DB::rollBack();
            return response()->json(['message' => $err], 500);
        }
    }
}
