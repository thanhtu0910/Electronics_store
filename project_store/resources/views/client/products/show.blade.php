@extends('layouts.client')

@section('content')
<br>
<div class="py-10 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto bg-white rounded-lg shadow-lg p-8">
        <div class="flex flex-col md:flex-row gap-8">
            <!-- Hình ảnh sản phẩm -->
            <br>
            <div class="md:w-1/2 flex flex-col items-center">
                <div class="w-full flex justify-center mb-4">
                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/400x300?text=No+Image' }}"
                    style="max-height:180px; width: 200px;"
                    alt="{{ $product->name }}" class="rounded-lg w-full max-w-xs object-cover shadow-md">
                </div>
                <div class="text-sm text-gray-500 mt-2">Danh mục: <span class="font-semibold text-indigo-600">{{ $product->category->name ?? 'Chưa phân loại' }}</span></div>
            </div>

            <!-- Thông tin sản phẩm -->
            <div class="md:w-1/2 flex flex-col">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Tên: {{ $product->name }}</h1>
                <div class="mb-3">
                    <span class="text-2xl font-bold text-red-600">Giá: {{ number_format($product->price) }} ₫</span>
                </div>
                <div class="mb-3">
                    <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Còn hàng: {{ $product->quantity }}</span>
                </div>
                <div class="mb-3">
                    <h2 class="font-semibold text-gray-700 mb-1">Mô tả sản phẩm:</h2>
                    <div class="text-gray-700 leading-relaxed">{!! nl2br(e($product->description)) !!}</div>
                </div>
                @auth
                    <div class="mb-3">
                        <form action="{{ route('cart.add') }}" method="POST" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="number" name="quantity" value="1" min="1" class="w-20 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" class="px-6 py-2 bg-blue-600 text-dark rounded font-semibold hover:bg-blue-700 transition">
                                Thêm vào giỏ
                            </button>
                        </form>
                    </div>
                @else
                    <div class="mb-3">
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-blue-600 text-white rounded font-semibold hover:bg-blue-700 transition">
                            Đăng nhập để mua
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Sản phẩm liên quan -->
        @if($relatedProducts->count() > 0)
        <div class="mt-12">
            <h2 class="text-xl font-bold mb-4 text-gray-900">Sản phẩm liên quan</h2>
            <div class="row">
                @foreach($relatedProducts as $item)
                    <div class="col-12 col-sm-6 col-md-3 mb-3">
                        <div class="card h-100 shadow-sm border-0">
                            <a href="{{ route('products.show', $item) }}">
                                <img src="{{ $item->image ? asset('storage/' . $item->image) : 'https://via.placeholder.com/200x200?text=No+Image' }}" alt="{{ $item->name }}" class="card-img-top" style="height: 140px; object-fit: cover;">
                            </a>
                            <div class="card-body p-2 d-flex flex-column align-items-center">
                                <a href="{{ route('products.show', $item) }}" class="font-semibold text-dark text-center mb-1" style="font-size: 1rem; text-decoration: none;">
                                    {{ $item->name }}
                                </a>
                                <div class="text-primary fw-bold" style="font-size: 1rem;">{{ number_format($item->price) }} ₫</div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection 