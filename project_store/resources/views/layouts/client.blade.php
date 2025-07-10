<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show position-fixed top-0 start-50 translate-middle-x mt-3" role="alert" style="z-index:9999; min-width:300px;">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        <nav class="bg-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <!-- Logo -->
                        <div class="flex-shrink-0 flex items-center">
                            <a href="{{ route('home') }}" class="fw-bold fs-3 text-primary" style="letter-spacing:2px;">
                                Three T
                            </a>
                        </div>

                        <!-- Navigation Links -->
                        <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                            <a href="{{ route('home') }}" class="ml-4 text-black inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium hover:border-gray-300">
                                Trang chủ
                            </a>
                            <a href="{{ route('products.index') }}" class="text-black inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium hover:border-gray-300">
                                Sản phẩm
                            </a>
                            @isset($categories)
                            <div class="dropdown ml-4">
                                <button class="btn btn-outline-secondary dropdown-toggle py-1 px-3 text-sm" type="button" id="dropdownCategory" data-bs-toggle="dropdown" aria-expanded="false">
                                    Danh mục
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdownCategory">
                                    @foreach($categories as $cat)
                                        <li><a class="dropdown-item" href="{{ route('products.index', ['category' => $cat->id]) }}">{{ $cat->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                            @endisset
                        </div>
                    </div>

                    <!-- Search Bar -->
                    <div class="flex items-center">
                        <form action="{{ route('products.index') }}" method="GET" class="flex">
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   placeholder="Tìm kiếm sản phẩm..." 
                                   class="rounded-l-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <button type="submit" 
                                    class="inline-flex items-center px-3 py-2 border border-l-0 border-gray-300 rounded-r-md bg-gray-50 text-sm font-medium text-gray-700 hover:bg-gray-100">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </form>
                    </div>

                    <!-- User Menu -->
                    <div class="flex items-center">
                        @auth
                            <div class="ml-3 relative">
                                <div class="flex items-center space-x-4">
                                    <a href="{{ route('cart.index') }}" class="text-black hover:text-gray-700 text-sm font-medium flex items-center">
                                        <!-- <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-2.5 5M7 13l2.5 5m6-5v6a2 2 0 01-2 2H9a2 2 0 01-2-2v-6m6 0V9a2 2 0 00-2-2H9a2 2 0 00-2 2v4.01"></path>
                                        </svg> -->
                                        Giỏ hàng
                                    </a>
                                    <a href="{{ route('orders.index') }}" class="ml-4 text-black hover:text-gray-700 text-sm font-medium">
                                        Đơn hàng
                                    </a>
                                    {{-- <a href="{{ route('dashboard') }}" class="ml-4 text-black hover:text-gray-700 text-sm font-medium">Dashboard</a> --}}
                                    <form method="POST" action="{{ route('logout') }}" class="inline">
                                        @csrf
                                        <button type="submit" class="ml-4 text-black hover:text-gray-700 text-sm font-medium">
                                            Đăng xuất
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @else
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('login') }}" class="text-black hover:text-gray-700 text-sm font-medium">
                                    Đăng nhập
                                </a>
                                <a href="{{ route('register') }}" class=" ml-4 text-black hover:text-gray-700 text-sm font-medium">
                                    Đăng ký
                                </a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="bg-white border-t border-gray-200 mt-12">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                <div class="text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} three T. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 