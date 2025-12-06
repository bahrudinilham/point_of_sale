<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Product::with('category')->where('name', '!=', 'Digital Product');
        $categories = \App\Models\Category::all();

        // Stats for summary cards
        $totalProducts = \App\Models\Product::where('name', '!=', 'Digital Product')->count();
        $lowStockCount = \App\Models\Product::where('name', '!=', 'Digital Product')->where('stock', '<=', 10)->count();
        $categoryCount = $categories->count();

        // Highest and lowest stock products
        $highestStockProduct = \App\Models\Product::where('name', '!=', 'Digital Product')->orderBy('stock', 'desc')->first();
        $lowestStockProduct = \App\Models\Product::where('name', '!=', 'Digital Product')->orderBy('stock', 'asc')->first();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%");
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'stock_asc':
                    $query->orderBy('stock', 'asc');
                    break;
                case 'stock_desc':
                    $query->orderBy('stock', 'desc');
                    break;
                case 'name_asc':
                    $query->orderBy('name', 'asc');
                    break;
                case 'name_desc':
                    $query->orderBy('name', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
            }
        } else {
            $query->latest();
        }

        $products = $query->paginate(10)->withQueryString();
        return view('products.index', compact('products', 'categories', 'totalProducts', 'lowStockCount', 'categoryCount', 'highestStockProduct', 'lowestStockProduct'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(\Illuminate\Http\Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'purchase_price' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
        ]);

        \App\Models\Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Product $product)
    {
        $categories = \App\Models\Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\Illuminate\Http\Request $request, \App\Models\Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'selling_price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Product $product)
    {
        // Check if product has been sold (exists in transaction_items)
        if ($product->transactionItems()->count() > 0) {
            // Auto-deactivate instead of blocking deletion
            $product->update(['is_active' => false]);
            return redirect()->route('products.index')
                ->with('success', 'Produk tidak bisa dihapus karena sudah ada dalam riwayat transaksi. Produk telah dinonaktifkan.');
        }

        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Toggle the active status of a product.
     */
    public function toggleActive(\App\Models\Product $product)
    {
        $product->update([
            'is_active' => !$product->is_active
        ]);

        $status = $product->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('products.index')
            ->with('success', "Produk berhasil {$status}.");
    }
}
