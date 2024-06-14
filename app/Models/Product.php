<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Company;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    use Sortable;

    protected $fillable = [
        'product_name',
        'price',
        'stock',
        'company_id',
        'comment',
        'img_path',
    ];

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function getList($input)
    {
        $query = Product::query()->with('company'); 

        $search = $input['search'] ?? null;
        $companyId = $input['companyId'] ?? null;
        $minPrice = $input['min_price'] ?? null;
        $maxPrice = $input['max_price'] ?? null;
        $minStock = $input['min_stock'] ?? null;
        $maxStock = $input['max_stock'] ?? null;

        if (!empty($search)) {
            $query->where('product_name', 'LIKE', "%{$search}%");
        }

        if (!empty($companyId)) {
            $query->where('company_id', $companyId);
        }

        if (isset($minPrice) && isset($maxPrice)) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif (isset($minPrice)) {
            $query->where('price', '>=', $minPrice);
        } elseif (isset($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        if (isset($minStock) && isset($maxStock)) {
            $query->whereBetween('stock', [$minStock, $maxStock]);
        } elseif (isset($minStock)) {
            $query->where('stock', '>=', $minStock);
        } elseif (isset($maxStock)) {
            $query->where('stock', '<=', $maxStock);
        }

        return $query->sortable()->get();
    }

    public function createNewProduct($request) {
        if ($request->hasFile('image_path')) {
            $filename = $request->image_path->getClientOriginalName();
            $img = $request->image_path->storeAs('public', $filename);
        } else {
            $img = '';
        }

        $product = new Product();
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->comment = $request->input('comment');
        $product->image_path = $img;
        $product->company_id = $request->input('company_id');
        $product->save();

        return $product;
    }

    public function updateProduct($data) {

        $product = Product::findOrFail($data['id']);
        $product->name = $data['name'];
        $product->price = $data['price'];
        $product->stock = $data['stock'];
        $product->comment =$data['comment'];
        $product->company_id = $data['company_id'];

        if(isset($data['image_path'])) {
            Storage::delete('public', $product->image_path);
            $filename = $data['image_path']->getClientOriginalName();
            $img = $data['image_path']->storeAs('public', $filename);
            $product->image_path = $img;
        }

        $product->save();
        return $product;
    }
}
