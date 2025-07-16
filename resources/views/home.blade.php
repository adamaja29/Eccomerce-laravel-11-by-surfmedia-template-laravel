@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Hero Banner -->
    <div class="hero-banner mb-5" style="background-image: url('{{ asset('images/banner.jpg') }}'); background-size: cover; background-position: center; height: 300px; border-radius: 8px;">
        <div class="hero-text text-white d-flex flex-column justify-content-center align-items-center h-100">
            <h1 class="display-4 fw-bold">Welcome to Our Store</h1>
            <p class="lead">Find the best products for your needs</p>
            <a href="{{ route('shop.index') }}" class="btn btn-primary btn-lg mt-3">Shop Now</a>
        </div>
    </div>

    <!-- Featured Categories -->
    <section class="featured-categories mb-5">
        <h2 class="mb-4">Featured Categories</h2>
        <div class="row">
            @foreach($categories as $category)
            <div class="col-md-3 mb-3">
                <div class="card h-100">
                    <img src="{{ asset('uploads/kategori/' . $category->image) }}" class="card-img-top" alt="{{ $category->nama }}" style="height: 150px; object-fit: cover;">
                    <div class="card-body text-center">
                        <h5 class="card-title">{{ $category->nama }}</h5>
                        <a href="{{ route('shop.index') }}?category={{ $category->id }}" class="btn btn-outline-primary btn-sm">View Products</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-products mb-5">
        <h2 class="mb-4">Featured Products</h2>
        <div class="row">
            @foreach($featuredProducts as $product)
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('uploads/produk/thumbnails/' . $product->image) }}" class="card-img-top" alt="{{ $product->nama }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->nama }}</h5>
                        <p class="card-text text-truncate">{{ $product->deskripsi }}</p>
                        <div class="mt-auto">
                            <p class="fw-bold">Rp {{ number_format($product->harga_jual, 0, ',', '.') }}</p>
                            <a href="{{ route('shop.detail', $product->id) }}" class="btn btn-primary btn-sm">View Details</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
