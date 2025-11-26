<?php

namespace App\Controller;

use App\Model\ProductModel;
use Gemvc\Core\Controller;
use Gemvc\Http\Request;
use Gemvc\Http\JsonResponse;

class ProductController extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }

    /**
     * Create new Product
     * 
     * @return JsonResponse
     */
    public function create(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new ProductModel());
        if(!$model instanceof ProductModel) {
            return $this->request->returnResponse();
        }
        return $model->createModel();
    }

    /**
     * Get Product by ID
     * 
     * @return JsonResponse
     */
    public function read(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new ProductModel());
        if(!$model instanceof ProductModel) {
            return $this->request->returnResponse();
        }
        return $model->readModel();
    }

    /**
     * Update existing Product
     * 
     * @return JsonResponse
     */
    public function update(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new ProductModel());
        if(!$model instanceof ProductModel) {
            return $this->request->returnResponse();
        }
        return $model->updateModel();
    }

    /**
     * Delete Product
     * 
     * @return JsonResponse
     */
    public function delete(): JsonResponse
    {
        $model = $this->request->mapPostToObject(new ProductModel());
        if(!$model) {
            return $this->request->returnResponse();
        }
        return $model->deleteModel();
    }

    /**
     * Get list of Products with filtering and sorting
     * 
     * @return JsonResponse
     */
    public function list(): JsonResponse
    {
        $model = new ProductModel();
        return $this->createList($model);
    }
} 