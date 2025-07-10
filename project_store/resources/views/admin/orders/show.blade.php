<x-admin-layout>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 text-gray-900">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold">Chi tiết đơn hàng</h2>
                <a href="{{ route('admin.orders.index') }}" class="text-blue-600 hover:text-blue-900">
                    ← Quay lại danh sách đơn hàng
                </a>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Order Information -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin đơn hàng</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-black">Mã đơn hàng:</p>
                        <p class="font-medium text-black">{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-black">Ngày đặt:</p>
                        <p class="font-medium text-black">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-black">Tổng tiền:</p>
                        <p class="font-medium text-lg text-black">{{ number_format($order->total_amount) }} VNĐ</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-600">Trạng thái:</p>
                        <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="processing" {{ $order->status == 'processing' ? 'selected' : '' }}>Đang xử lý</option>
                                <option value="shipped" {{ $order->status == 'shipped' ? 'selected' : '' }}>Đang giao</option>
                                <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Đã giao</option>
                                <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Customer Information -->
            <div class="bg-gray-50 p-6 rounded-lg mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Thông tin khách hàng</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-black">Họ và tên:</p>
                        <p class="font-medium text-black">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-black">Số điện thoại:</p>
                        <p class="font-medium text-black">{{ $order->customer_phone }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-sm text-black">Địa chỉ:</p>
                        <p class="font-medium text-black">{{ $order->customer_address }}</p>
                    </div>
                    @if($order->notes)
                        <div class="md:col-span-2">
                            <p class="text-sm text-black">Ghi chú:</p>
                            <p class="font-medium text-black">{{ $order->notes }}</p>
                        </div>
                    @endif
                    <div class="md:col-span-2">
                        <p class="text-sm text-black">Tài khoản:</p>
                        <p class="font-medium text-black">{{ $order->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Chi tiết sản phẩm</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Số lượng</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($order->items as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <div class="h-12 w-12 rounded-lg bg-gray-200 flex items-center justify-center">
                                                    <span class="text-gray-500 text-sm">{{ substr($item->product_name, 0, 2) }}</span>
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-black">
                                                    {{ $item->product_name }}
                                                </div>
                                                @if($item->product)
                                                    <div class="text-sm text-black">
                                                        {{ $item->product->category->name }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ number_format($item->price) }} VNĐ
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-black">
                                        {{ $item->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-black">
                                        {{ number_format($item->subtotal) }} VNĐ
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-sm font-medium text-gray-900">
                                    Tổng cộng:
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                    {{ number_format($order->total_amount) }} VNĐ
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 