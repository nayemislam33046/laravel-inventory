<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
class DashboardController extends Controller
{
    public function index()
{
    $totalProducts = Product::count();
    $totalStock = Product::sum('quantity');
    $recentProducts = Product::with('category')->latest()->take(5)->get();
    return view('dashboard', compact('totalProducts', 'totalStock', 'recentProducts'));
}
}