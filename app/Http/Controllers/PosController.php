<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        // Initial load: get first page of products with category
        $products = \App\Models\Product::with('category')
            ->where('stock', '>', 0)
            ->where('is_active', true)
            ->where('name', '!=', 'Digital Product')
            ->paginate(12);
            
        $paymentMethods = \App\Models\PaymentMethod::where('is_active', true)->get();
        $categories = \App\Models\Category::all();
            
        return view('pos.index', compact('products', 'paymentMethods', 'categories'));
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('query');
        $categoryId = $request->get('category_id');
        
        $productsQuery = \App\Models\Product::with('category')
            ->where('stock', '>', 0)
            ->where('is_active', true)
            ->where('name', '!=', 'Digital Product');
            
        if ($query) {
            $productsQuery->where(function($q) use ($query) {
                $q->where('name', 'like', "%{$query}%");
            });
        }
        
        if ($categoryId && $categoryId !== 'all') {
            $productsQuery->where('category_id', $categoryId);
        }
        
        $products = $productsQuery->paginate(12);
            
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id' => 'required_without:items.*.is_digital|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.is_digital' => 'boolean',
            'items.*.custom_price' => 'required_if:items.*.is_digital,true|numeric|min:0',
            'items.*.note' => 'nullable|string',
            'payment_method_id' => 'required|exists:payment_methods,id',
        ]);

        DB::beginTransaction();

        try {
            $totalAmount = 0;
            $itemsData = [];

            foreach ($request->items as $item) {
                if (isset($item['is_digital']) && $item['is_digital']) {
                    // Handle Digital Product
                    $subtotal = $item['custom_price'] * $item['quantity'];
                    $totalAmount += $subtotal;

                    // Find or create Digital category first
                    $digitalCategory = \App\Models\Category::firstOrCreate(
                        ['slug' => 'digital'],
                        ['name' => 'Digital', 'description' => 'Produk digital seperti pulsa dan paket data']
                    );

                    // Find or create Digital Product placeholder
                    $digitalProduct = \App\Models\Product::firstOrCreate(
                        ['name' => 'Digital Product'],
                        [
                            'selling_price' => 0,
                            'purchase_price' => 0,
                            'stock' => 999999,
                            'category_id' => $digitalCategory->id
                        ] 
                    );

                    $itemsData[] = [
                        'product_id' => $digitalProduct->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $item['custom_price'],
                        'subtotal' => $subtotal,
                        'note' => $item['note'] ?? null,
                    ];
                } else {
                    // Handle Physical Product
                    $product = \App\Models\Product::lockForUpdate()->find($item['id']);
                    
                    if (!$product) {
                        throw new \Exception("Product with ID {$item['id']} not found");
                    }
                    
                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Insufficient stock for product: {$product->name}");
                    }

                    $subtotal = $product->selling_price * $item['quantity'];
                    $totalAmount += $subtotal;

                    $itemsData[] = [
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'unit_price' => $product->selling_price,
                        'subtotal' => $subtotal,
                    ];

                    // Deduct stock
                    $product->decrement('stock', $item['quantity']);
                }
            }

            $finalAmount = $totalAmount; // Apply discount logic here if needed
            
            // Auto-set cash received to final amount since we removed the input
            $cashReceived = $finalAmount;
            $changeAmount = 0;

            $transaction = \App\Models\Transaction::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(uniqid()),
                'user_id' => auth()->id(),
                'total_amount' => $totalAmount,
                'final_amount' => $finalAmount,
                'cash_received' => $cashReceived,
                'change_amount' => $changeAmount,
                'payment_method_id' => $request->payment_method_id,
                'transaction_date' => now(),
            ]);

            $lowStockItems = [];

            foreach ($itemsData as $data) {
                $transaction->items()->create($data);
            }

            // Check for low stock items from the processed items
            foreach ($request->items as $item) {
                if (!isset($item['is_digital']) || !$item['is_digital']) {
                    $product = \App\Models\Product::find($item['id']);
                    if ($product && $product->stock <= 10) {
                        $lowStockItems[] = [
                            'name' => $product->name,
                            'stock' => $product->stock
                        ];
                    }
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'transaction_id' => $transaction->id,
                'redirect_url' => route('transactions.show', $transaction),
                'low_stock_items' => $lowStockItems
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('POS Transaction Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
