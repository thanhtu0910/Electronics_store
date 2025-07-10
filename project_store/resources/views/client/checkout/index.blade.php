@extends('layouts.client')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <h2 class="text-2xl font-bold mb-6">Thanh toán</h2>
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Order Summary -->
                <div class="bg-gray-50 p-6 rounded-lg">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin đơn hàng</h3>
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <div class="flex-1">
                                    <div class="text-sm font-medium text-black">{{ $item['product']->name }}</div>
                                    <div class="text-sm text-black">{{ $item['product']->category->name }}</div>
                                    <div class="text-sm text-black">Số lượng: {{ $item['quantity'] }}</div>
                                </div>
                                <div class="text-sm font-medium text-black">
                                    {{ number_format($item['subtotal']) }} VNĐ
                                </div>
                            </div>
                        @endforeach
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-medium text-black">Tổng cộng:</span>
                                <span class="text-lg font-bold text-black">{{ number_format($total) }} VNĐ</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Checkout Form -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin giao hàng</h3>
                    <form action="{{ route('checkout.store') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="customer_name" class="block text-sm font-medium text-black">Họ và tên *</label>
                                <input type="text" name="customer_name" id="customer_name" 
                                       value="{{ old('customer_name', auth()->user()->name) }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('customer_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_phone" class="block text-sm font-medium text-black">Số điện thoại *</label>
                                <input type="text" name="customer_phone" id="customer_phone" 
                                       value="{{ old('customer_phone') }}"
                                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                       required>
                                @error('customer_phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="customer_address" class="block text-sm font-medium text-black">Địa chỉ giao hàng *</label>
                                <textarea name="customer_address" id="customer_address" rows="3"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                          required>{{ old('customer_address') }}</textarea>
                                @error('customer_address')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-black">Ghi chú</label>
                                <textarea name="notes" id="notes" rows="2"
                                          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="flex items-center justify-between pt-4">
                                <a href="{{ route('cart.index') }}" class="text-blue-600 hover:text-blue-900">
                                    ← Quay lại giỏ hàng
                                </a>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-dark font-medium py-2 px-6 rounded">
                                    Đặt hàng
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection 