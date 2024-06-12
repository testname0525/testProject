<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $input = $request->all();
        $companies = Company::all();
        $products = (new Product())->getList($input);

        return view('products.index', compact('products', 'companies'));
    }



public function search(Request $request)
{
    $input = $request->all();
    $model = new Product();
    $products = $model->getList($input);

    return response()->json([
        'products' => $products,
    ]);
}

    

    public function create() {
        //$companies = Company::all();
        $companies = (new Company())->getAllCompanies();

        return view('products.create', compact('companies'));
    }


    public function store(Request $request)
{
    try {
        $request->validate([
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable', 
            'img_path' => 'nullable|image|max:2048',
        ]);

        $product = new Product([
            'product_name' => $request->get('product_name'),
            'company_id' => $request->get('company_id'),
            'price' => $request->get('price'),
            'stock' => $request->get('stock'),
            'comment' => $request->get('comment'),
        ]);
    
        if($request->hasFile('img_path')){ 
            $filename = $request->img_path->getClientOriginalName();
            $filePath = $request->img_path->storeAs('products', $filename, 'public');
            $product->img_path = '/storage/' . $filePath;
        }
    
        $product->save();

        return redirect('products');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => '商品の追加中にエラーが発生しました: ' . $e->getMessage()]);
    }
}


    public function show(Product $product)
    {
        return view('products.show', ['product' => $product]);
    }

    public function edit(Product $product)
    {
        $companies = Company::all();

        return view('products.edit', compact('product', 'companies'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_name' => 'required',
            'price' => 'required',
            'stock' => 'required',
        ]);
        $product->product_name = $request->product_name;
        $product->price = $request->price;
        $product->stock = $request->stock;

        $product->save();
        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    public function destroy($id)
{
    $product = Product::findOrFail($id);
    
    // 関連する sales レコードを削除
    $product->sales()->delete();
    
    // 商品を削除
    $product->delete();
    
    // リダイレクト先のURLを返す
    return response()->json(['redirect' => route('products.index')]);
}

    
}
