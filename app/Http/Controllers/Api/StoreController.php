<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\StoreRequest;
use App\Models\Store;
use App\Services\ArticleService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{

    private $_model;
    private $articleService;

    public function __construct(Store $storeModel, ArticleService $articleService)
    {
        $this->_model = $storeModel;
        $this->articleService = $articleService;
    }

    public function index($limit = 10)
    {
        $listPaginated = $this->_model->paginate($limit);

        return response()->json($listPaginated, 200);
    }

    public function store(StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['author_id'] = auth()->user()->id;
            if(isset($request->image)) {
                $imagePath =
                    $this->articleService->handleUploadedImage(
                        $request->image,
                        $request->name,
                        'stores'
                    );
                unset($data['image']);
                $data['image'] = $imagePath;
            }
            $createdStore = $this->_model->create($data);
            DB::commit();

            return response()->json(['store' => $createdStore], 200);
        }
        catch(Exception $err) {
            DB::rollBack();
            return response()->json([
                'message' => $err->getMessage()
            ],500);
        }

    }

    public function show($id)
    {
        try {
            $store = $this->_model->where('id', $id)->first();
            if($store === null) {
                return response()->json(['message' => "Not found store by id ".$id], 400);
            }
            return response()->json(['store' => $store], 200);
        }
        catch(Exception $err) {
            return response()->json(['message' => $err], 500);
        }
    }

    public function update($id, StoreRequest $request)
    {
        try {
            DB::beginTransaction();
            $store = $this->_model->where('id',$id)->first();

            if ($store === null) {
                throw new Exception('Not found store Id');
            }

            $store->name = $request->name;
            $store->address = $request->address;
            $store->is_active = $request->is_active;
            $store->store_code = $request->store_code;
            $store->type_of = $request->type_of;

            if (isset($request->image)) {
                $imagePath =
                    $this->articleService->handleUploadedImage(
                        $request->image,
                        $request->name,
                        'stores'
                    );
                $store->image = $imagePath;
            }
            if(isset($request->total_monthly_cost)) {
                $store->total_monthly_cost = $request->total_monthly_cost;
            }
            if (isset($request->total_cost_per_year)) {
                $store->total_cost_per_year = $request->total_cost_per_year;
            }
            if (isset($request->total_monthly_revenue)) {
                $store->total_monthly_revenue = $request->total_monthly_revenue;
            }
            if (isset($request->total_annual_revenue)) {
                $store->total_annual_revenue = $request->total_annual_revenue;
            }
            $store->save();
            DB::commit();

            return response()->json(['store' => $store], 200);
        }
        catch(Exception $err) {
            DB::rollBack();
            return response()->json(['message' => $err->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $store = $this->_model->where('id', $id)->first();
            if($store === null) {
                throw new Exception('Not found store Id');
            }

            $store->delete();
            DB::commit();

            return response()->json(["message" => "store deleted successful"],200);
        }
        catch(Exception $err) {
            DB::rollBack();
            return response()->json(['message' => $err->getMessage()], 500);
        }
    }

    public function search($keyword, $limit = 10)
    {
        try {
            DB::beginTransaction();
            $storeFilter = $this->_model
                ->where('name', 'like', '%'.$keyword.'%')
                ->orWhere('store_code', 'like', '%' . $keyword . '%')
                ->paginate($limit);
            DB::commit();

            return response()->json(['result' => $storeFilter], 200);
        }
        catch(Exception $err) {
            DB::rollBack();
            return response()->json(['message'=>$err], 500);
        }
    }
}
