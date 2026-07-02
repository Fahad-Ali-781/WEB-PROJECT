<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    // Categories
    public function indexCategories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function createCategory()
    {
        return view('admin.categories.create');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories',
            'slug' => 'required|string|unique:categories',
            'description' => 'nullable|string'
        ]);

        Category::create($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category created successfully!');
    }

    public function editCategory(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $category->id,
            'slug' => 'required|string|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update($validated);
        return redirect()->route('admin.categories.index')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Category deleted successfully!');
    }

    // Products
    public function indexProducts()
    {
        $products = Product::with('category')->paginate(15);
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|unique:products',
            'slug' => 'required|string|unique:products',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'city' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean'
        ]);

        Product::create($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
    }

    public function editProduct(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|unique:products,name,' . $product->id,
            'slug' => 'required|string|unique:products,slug,' . $product->id,
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'city' => 'nullable|string|max:100',
            'is_featured' => 'nullable|boolean'
        ]);

        $product->update($validated);
        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully!');
    }
}
