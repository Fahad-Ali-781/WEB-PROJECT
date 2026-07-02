<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::visible()->get();
        $productsQuery = Product::visible()->with('category');

        if ($request->boolean('clear_city')) {
            session()->forget(['selected_city', 'gps_coordinates']);
        }

        if ($request->has('city')) {
            $cityInput = trim((string) $request->get('city', ''));

            if ($cityInput !== '') {
                session(['selected_city' => $cityInput]);
            } else {
                session()->forget(['selected_city', 'gps_coordinates']);
            }
        }

        $selectedCity = $request->filled('city')
            ? $request->get('city')
            : session('selected_city');

        // Apply free-text search only when not explicitly requesting featured-only view.
        if ($request->filled('q') && $request->get('featured') !== '1') {
            $query = $request->get('q');
            $productsQuery->where(function ($builder) use ($query) {
                $builder->where('name', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('city', 'like', "%{$query}%");
            });
        }

        if ($request->filled('category')) {
            $productsQuery->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->get('category'));
            });
        }

        if ($selectedCity) {
            $productsQuery->where('city', $selectedCity);
        }

        if ($request->filled('min_price')) {
            $productsQuery->where('price', '>=', $request->integer('min_price'));
        }

        if ($request->filled('max_price')) {
            $productsQuery->where('price', '<=', $request->integer('max_price'));
        }

        if ($request->get('featured') === '1') {
            $productsQuery->where('is_featured', true);
        }

        if ($request->get('view') === 'trending') {
            $productsQuery->withCount('orderItems')->orderByDesc('order_items_count');
        } else {
            $productsQuery->latest();
        }

        $products = $productsQuery->paginate(12)->withQueryString();
        // Helpful counts to explain empty featured results
        $featuredTotalCount = Product::visible()->where('is_featured', true)->count();
        $featuredCityCount = null;
        if ($selectedCity) {
            $featuredCityCount = Product::visible()->where('is_featured', true)->where('city', $selectedCity)->count();
        }
        $cities = Product::visible()->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $featuredProducts = Product::visible()->with('category')->where('is_featured', true)->latest()->take(6)->get();
        $trendingProducts = Product::visible()->with('category')->withCount('orderItems')->orderByDesc('order_items_count')->take(6)->get();

        return view('products.index', compact('products', 'categories', 'cities', 'featuredProducts', 'trendingProducts', 'selectedCity', 'featuredTotalCount', 'featuredCityCount'));
    }

    public function show($id)
    {
        $product = Product::visible()->with(['category', 'reviews.user'])->findOrFail($id);
        $relatedProducts = Product::visible()->where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(4)
            ->get();
        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function showBySlug($slug)
    {
        $product = Product::visible()->with(['category', 'reviews.user'])->where('slug', $slug)->firstOrFail();
        $relatedProducts = Product::visible()->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }

    public function byCategory($slug)
    {
        $category = Category::visible()->where('slug', $slug)->firstOrFail();
        $categories = Category::visible()->get();
        $cities = Product::visible()->whereNotNull('city')->distinct()->orderBy('city')->pluck('city');
        $featuredProducts = Product::visible()->with('category')->where('is_featured', true)->latest()->take(6)->get();
        $trendingProducts = Product::visible()->with('category')->withCount('orderItems')->orderByDesc('order_items_count')->take(6)->get();
        $products = $category->products()->visible()->with('category')->paginate(12)->withQueryString();
        return view('products.index', compact('products', 'categories', 'category', 'cities', 'featuredProducts', 'trendingProducts'));
    }

    public function search(Request $request)
    {
        return $this->index($request);
    }
}
