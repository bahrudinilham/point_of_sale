<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\PaymentMethod;
use App\Models\User;

class SettingsController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10, ['*'], 'categories_page');
        $paymentMethods = PaymentMethod::latest()->paginate(10, ['*'], 'payment_methods_page');
        $users = User::latest()->paginate(10, ['*'], 'users_page');

        return view('settings.index', compact('categories', 'paymentMethods', 'users'));
    }
}
