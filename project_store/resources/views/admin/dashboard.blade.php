<x-admin-layout>
    <div class="bg-gray-50 min-h-screen py-10">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Tiêu đề -->
            <h1 class="text-4xl font-bold text-gray-800 mb-8">📊 Bảng điều khiển</h1>
<br>
            <!-- Thống kê -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
                <!-- Tổng sản phẩm -->
                <div class="bg-white border-l-4 border-blue-500 rounded-xl shadow p-5">
                    <div class="flex items-center">
                        <div class="p-3 bg-blue-500 text-white rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                            </svg>
                        </div>
                        
                        <div>
                        <br>
                            <p class="text-sm text-gray-600">Tổng sản phẩm</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_products'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tổng danh mục -->
                <div class="bg-white border-l-4 border-green-500 rounded-xl shadow p-5">
                    <div class="flex items-center">
                        <div class="p-3 bg-green-500 text-white rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                            </svg>
                        </div>
                        <div>
                        <br>
                            <p class="text-sm text-gray-600">Tổng danh mục</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_categories'] }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tổng người dùng -->
                <div class="bg-white border-l-4 border-purple-500 rounded-xl shadow p-5">
                    <div class="flex items-center">
                        <div class="p-3 bg-purple-500 text-white rounded-full mr-4">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"/>
                            </svg>
                        </div>
                        <div>
                        <br>
                            <p class="text-sm text-gray-600">Tổng người dùng</p>
                            <p class="text-2xl font-bold text-gray-800">{{ $stats['total_users'] }}</p>
                            <br>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sản phẩm gần đây -->
            <div class="bg-white rounded-xl shadow overflow-hidden mb-12">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">🛒 Sản phẩm gần đây</h3>
                </div>
                <br>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-100 text-sm text-gray-600 uppercase">
                            <tr>
                                <th class="px-6 py-3 text-left">Tên sản phẩm</th>
                                <th class="px-6 py-3 text-left">Danh mục</th>
                                <th class="px-6 py-3 text-left">Giá</th>
                                <th class="px-6 py-3 text-left">Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white text-sm text-gray-700 divide-y divide-gray-100">
                            @forelse($stats['recent_products'] as $product)
                                <tr class="hover:bg-blue-50 transition">
                                    <td class="px-6 py-4 font-medium">{{ $product->name }}</td>
                                    <td class="px-6 py-4">{{ $product->category->name }}</td>
                                    <td class="px-6 py-4">{{ number_format($product->price) }} VNĐ</td>
                                    <td class="px-6 py-4">{{ $product->created_at->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center px-6 py-4 text-gray-500">Không có sản phẩm nào</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Hành động nhanh -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Thao tác nhanh -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">⚡ Thao tác nhanh</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.products.create') }}"
                           class="block w-full bg-blue-600 hover:bg-blue-700 text-dark text-center py-2 px-4 rounded-md font-semibold transition">
                            ➕ Thêm sản phẩm mới
                        </a>
                        <a href="{{ route('admin.categories.create') }}"
                           class="block w-full bg-green-600 hover:bg-green-700 text-dark text-center py-2 px-4 rounded-md font-semibold transition">
                            ➕ Thêm danh mục mới
                        </a>
                    </div>
                </div>

                <!-- Liên kết nhanh -->
                <div class="bg-white shadow rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">🔗 Liên kết nhanh</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.products.index') }}"
                        class="block w-full bg-gray-700 hover:bg-black text-gray-200 hover:text-white text-center py-2 px-4 rounded-md font-semibold transition"
                        >
                            📦 Quản lý sản phẩm
                        </a>
                        <a href="{{ route('admin.categories.index') }}"
                           class="block w-full bg-gray-700 hover:bg-black text-gray-200 hover:text-white text-center py-2 px-4 rounded-md font-semibold transition"
>
                            📂 Quản lý danh mục
                        </a>
                        <a href="{{ route('admin.orders.index') }}"
                        class="block w-full bg-gray-700 hover:bg-black text-gray-200 hover:text-white text-center py-2 px-4 rounded-md font-semibold transition"
>
                            📬 Quản lý đơn hàng
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-admin-layout>


