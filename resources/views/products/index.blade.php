@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">商品情報一覧</h1>

    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">商品新規登録</a>

    <div class="search mt-5">
        <h2>検索条件で絞り込み</h2>
        <form id="search-form" class="row g-3">
            <div class="col-sm-12 col-md-3">
                <input type="text" name="search" class="form-control" placeholder="商品名" value="{{ request('search') }}">
            </div>

            <div class="col-sm-12 col-md-3">
                <select name="companyId" class="form-control" id="company">
                    <option value="">未選択</option>
                    @foreach ($companies as $company)
                    <option value="{{ $company->id }}">{{ $company->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-12 col-md-2">
                <input type="number" name="min_price" class="form-control" id="minPrice" placeholder="最低価格">
            </div>
            <div class="col-sm-12 col-md-2">
                <input type="number" name="max_price" class="form-control" id="maxPrice" placeholder="最高価格">
            </div>
            <div class="col-sm-12 col-md-2">
                <input type="number" name="min_stock" class="form-control" id="minStock" placeholder="最低在庫数">
            </div>
            <div class="col-sm-12 col-md-2">
                <input type="number" name="max_stock" class="form-control" id="maxStock" placeholder="最高在庫数">
            </div>
            <div class="col-sm-12 col-md-1">
                <button type="submit" class="btn btn-outline-secondary">絞り込み</button>
            </div>
        </form>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-success mt-3">検索条件を元に戻す</a>

    <div class="products mt-5">
        <h2>商品情報</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">@sortablelink('product_name', '商品名')</th>
                    <th scope="col">@sortablelink('company_name', 'メーカー')</th>
                    <th scope="col">@sortablelink('price', '価格')</th>
                    <th scope="col">@sortablelink('stock', '在庫数')</th>
                    <th scope="col">@sortablelink('comment', 'コメント')</th>
                    <th scope="col">@sortablelink('img_path', '商品画像')</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody id="product-list">
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->product_name }}</td>
            <td>{{ $product->company->company_name }}</td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->comment }}</td>
            <td><img src="{{ asset($product->img_path) }}" alt="商品画像" width="100"></td>
            <td>
                <a href="{{ route('products.show', $product) }}" class="btn btn-info btn-sm mx-1">詳細表示</a>
                <a href="{{ route('products.edit', $product) }}" class="btn btn-primary btn-sm mx-1">編集</a>
                <form method="POST" action="{{ route('products.destroy', $product) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm mx-1 delete-btn" data-product_id="{{ $product->id }}">削除</button>
                </form>
            </td>
        </tr>
    @endforeach
</tbody>

        </table>
    </div>
</div>
@endsection
