@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <!-- Welcome Section -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
            <div class="p-6 text-gray-900">
                <h1 class="text-2xl font-bold text-gray-900 mb-2">
                    Chào mừng bạn, {{ $user->name }}!
                </h1>
                <!-- <p class="text-gray-600">
                    Đây là trang quản lý tài khoản của bạn. Bạn có thể xem các sản phẩm mới nhất bên dưới.
                </p> -->
            </div>
        </div>

        <!-- Recent Products -->
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Sản phẩm mới nhất</h2>
                    <a href="{{ route('products.index') }}" 
                       class="text-sm text-indigo-600 hover:text-indigo-500">
                        Xem tất cả →
                    </a>
                </div>
                @if($recentProducts->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($recentProducts as $product)
                            <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                <div class="aspect-w-1 aspect-h-1 w-full mb-3">
                                    <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/200x200?text=No+Image' }}" 
                                         alt="{{ $product->name }}"
                                         class="w-full max-h-32 h-32 object-cover rounded-md"
                                         style="max-height:120px">
                                </div>
                                <h3 class="text-sm font-semibold text-gray-900 mb-1 line-clamp-2">
                                    {{ $product->name }}
                                </h3>
                                <div class="flex items-center justify-between mb-2">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $product->category->name }}
                                    </span>
                                    <span class="text-sm font-bold text-indigo-600">
                                        {{ number_format($product->price) }} VNĐ
                                    </span>
                                </div>
                                <a href="{{ route('products.show', $product) }}" 
                                   class="w-full inline-flex justify-center items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Xem chi tiết
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Chưa có sản phẩm</h3>
                        <p class="mt-1 text-sm text-gray-500">
                            Hiện tại chưa có sản phẩm nào trong hệ thống.
                        </p>
                    </div>
                @endif
            </div>
        </div>
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