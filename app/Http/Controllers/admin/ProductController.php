<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\admin\Concerns\ManagesArtistContent;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ManagesArtistContent;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $products = $this->scoped(Product::query())
            ->with('artist')
            ->orderBy('artist_id')->orderBy('sort_order')
            ->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', ['product' => new Product(), 'artists' => $this->artistOptions()]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['artist_id'] = $this->resolveArtistId($request, nullable: true); // null = label merch
        $data['slug'] = $this->uniqueSlugFor(Product::class, $data['name']);

        if ($image = $this->resolveImageInput($request, 'image', 'products')) {
            $data['images'] = [$image];
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product added.');
    }

    public function edit(Product $product)
    {
        $this->authorizeOwnership($product);
        return view('admin.products.form', ['product' => $product, 'artists' => $this->artistOptions()]);
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeOwnership($product);

        $data = $this->validated($request);
        if ($this->isAdmin()) {
            $data['artist_id'] = $this->resolveArtistId($request, nullable: true);
        }
        if ($data['name'] !== $product->name) {
            $data['slug'] = $this->uniqueSlugFor(Product::class, $data['name'], $product->id);
        }
        if ($image = $this->resolveImageInput($request, 'image', 'products')) {
            $data['images'] = [$image];
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $this->authorizeOwnership($product);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'stock' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]) + [
            'is_published' => $request->boolean('is_published'),
            'sort_order' => (int) $request->input('sort_order', 0),
        ];
    }
}
