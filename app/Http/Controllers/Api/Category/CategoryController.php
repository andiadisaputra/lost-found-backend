<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\Category\CategoryService;
use App\Traits\ApiResponse;

class CategoryController extends Controller
{
    use ApiResponse;

    public function __construct(
        protected CategoryService $categoryService
    ){}

    public function index()
    {
        $categories = $this->categoryService->all();

        return $this->success(
            'Daftar kategori.',
            CategoryResource::collection($categories)
        );
    }
}