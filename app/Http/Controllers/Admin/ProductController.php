<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        $categories = Category::all();
        return view('productlist', compact('products','categories'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('productadd',compact('categories'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $validated = $request->validate([
        'name' => 'required|max:255',
        'sku' => 'required|unique:products',
        'description' => 'nullable',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);
    if ($request->hasFile('image')) {
    $imagePath = $request->file('image')->store('/', 'public_uploads');
    $validated['image_path'] = 'uploads/products/' . $imagePath;
}
    Product::create($validated);
    return redirect()->route('products.index')->with('success', 'Product added successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
{
    $categories = Category::all();
    return view('productedit', compact('product', 'categories'));
}
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
        'name' => 'required|string|max:255',
        'sku' => 'required|string|unique:products,sku,'.$product->id,
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'quantity' => 'required|integer|min:0',
        'category_id' => 'required|exists:categories,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);
    // Handle image update
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($product->image_path && file_exists(public_path($product->image_path))) {
            unlink(public_path($product->image_path));
        }
        // Store new image
        $filename = time().'.'.$request->image->extension();
        $request->image->move(public_path('products'), $filename);
        $validated['image_path'] = 'uploads/products/'.$filename;
    }
    $product->update($validated);
    return redirect()->route('products.index')
           ->with('success', 'Product updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     */
        public function destroy(Product $product)
    {
        // Delete associated image
        if ($product->image_path && file_exists(public_path($product->image_path))) {
            unlink(public_path($product->image_path));
        }
        $product->delete();
        return redirect()->route('products.index')
            ->with('deleted', 'Product deleted successfully.');
    }
    public function search(Request $request)
{
    $search = $request->input('search');
    $categoryId = $request->input('category_id');
    $minPrice = $request->input('min_price');
    $maxPrice = $request->input('max_price');
    $products = Product::query()
        ->when($search, function ($query, $search) {
            return $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        })
        ->when($categoryId, function ($query, $categoryId) {
            return $query->where('category_id', $categoryId);
        })
        ->when($minPrice, function ($query, $minPrice) {
            return $query->where('price', '>=', $minPrice);
        })
        ->when($maxPrice, function ($query, $maxPrice) {
            return $query->where('price', '<=', $maxPrice);
        })
        ->with('category')
        ->orderBy('name')
        ->paginate(10)
        ->withQueryString();
    $categories = Category::all();
    return view('productlist', compact('products', 'categories'));
}
}