@extends('layouts.client')

@section('content')
<div class="py-12 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Tiêu đề -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                @if(request('search'))
                    Kết quả tìm kiếm: "{{ request('search') }}"
                @else
                    Danh sách sản phẩm
                @endif
            </h1>
            @if(request('search'))
                <p class="mt-2 text-gray-600">
                    Tìm thấy {{ $products->total() }} sản phẩm
                    <a href="{{ route('products.index') }}" class="text-indigo-600 hover:underline ml-2">
                        Xem tất cả sản phẩm
                    </a>
                </p>
            @endif
        </div>

        <!-- Danh sách sản phẩm -->
        @if($products->count())
        <div class="row">
            @foreach($products as $product)
            <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 shadow-sm">
                    <a href="{{ route('products.show', $product) }}">
                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300x300?text=No+Image' }}"
                             alt="{{ $product->name }}"
                             class="card-img-top" style="height: 200px; object-fit: cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <span class="text-muted small mb-1">{{ $product->category->name }}</span>
                        <h5 class="card-title mb-1" style="font-size: 1rem;">
                            <a href="{{ route('products.show', $product) }}" class="text-dark text-decoration-none">{{ $product->name }}</a>
                        </h5>
                        <p class="card-text mb-2" style="font-size: 0.95rem;">{{ Str::limit($product->description, 80) }}</p>
                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <span class="text-primary fw-bold">{{ number_format($product->price) }} VNĐ</span>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-primary">Xem chi tiết</a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Phân trang -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
        @else
        <!-- Trạng thái rỗng -->
        <div class="text-center py-12">
            <h3 class="text-xl font-semibold text-gray-700 mb-2">Không tìm thấy sản phẩm</h3>
            <p class="text-gray-500">
                @if(request('search'))
                    Không có sản phẩm nào phù hợp với từ khóa "{{ request('search') }}"
                @else
                    Hiện tại chưa có sản phẩm nào
                @endif
            </p>
            @if(request('search'))
            <div class="mt-4">
                <a href="{{ route('products.index') }}"
                   class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                    Xem tất cả sản phẩm
                </a>
            </div>
            @endif
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
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
