<?php
/**
 * this is model layer. what so called Data logic layer
 * classes in this layer shall be extended from relevant classes in Table layer
 * classes in this layer  will be called from controller layer
 */
namespace App\Model;

use App\Table\ProductTable;
use Gemvc\Http\JsonResponse;
use Gemvc\Http\Response;

class ProductModel extends ProductTable
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create new Product
     * 
     * @return JsonResponse
     */
    public function createModel(): JsonResponse
    {
        $success = $this->insertSingleQuery();
        if ($this->getError()) {
            return Response::internalError("Failed to create Product: " . $this->getError());
        }
        return Response::created($success, 1, "Product created successfully");
    }

    /**
     * Get Product by ID
     * 
     * @return JsonResponse
     */
    public function readModel(): JsonResponse
    {
        $item = $this->selectById($this->id);
        if (!$item) {
            return Response::notFound("Product not found");
        }
        return Response::success($item, 1, "Product retrieved successfully");
    }

    /**
     * Update existing Product
     * 
     * @return JsonResponse
     */
    public function updateModel(): JsonResponse
    {
        $item = $this->selectById($this->id);
        if (!$item) {
            return Response::notFound("Product not found");
        }
        $success = $this->updateSingleQuery();
        if ($this->getError()) {
            return Response::internalError("Failed to update Product: " . $this->getError());
        }
        return Response::updated($success, 1, "Product updated successfully");
    }

    /**
     * Delete Product
     * 
     * @return JsonResponse
     */
    public function deleteModel(): JsonResponse
    {
        $item = $this->selectById($this->id);
        if (!$item) {
            return Response::notFound("Product not found");
        }
        $success = $this->deleteByIdQuery($this->id);
        if ($this->getError()) {
            return Response::internalError("Failed to delete Product: " . $this->getError());
        }
        return Response::deleted($success, 1, "Product deleted successfully");
    }
} 