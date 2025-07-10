<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'name' => 'iPhone 15 Pro',
                'description' => 'iPhone 15 Pro với chip A17 Pro mạnh mẽ, camera 48MP',
                'price' => 29990000,
                'category_name' => 'Điện thoại'
            ],
            [
                'name' => 'Samsung Galaxy S24',
                'description' => 'Samsung Galaxy S24 với màn hình AMOLED 6.2 inch',
                'price' => 21990000,
                'category_name' => 'Điện thoại'
            ],
            [
                'name' => 'MacBook Air M2',
                'description' => 'MacBook Air với chip M2, màn hình 13.6 inch',
                'price' => 29990000,
                'category_name' => 'Laptop'
            ],
            [
                'name' => 'Dell XPS 13',
                'description' => 'Laptop Dell XPS 13 với thiết kế mỏng nhẹ',
                'price' => 25990000,
                'category_name' => 'Laptop'
            ],
            [
                'name' => 'iPad Pro 12.9',
                'description' => 'iPad Pro 12.9 inch với chip M2',
                'price' => 29990000,
                'category_name' => 'Máy tính bảng'
            ],
            [
                'name' => 'AirPods Pro',
                'description' => 'Tai nghe không dây với chống ồn chủ động',
                'price' => 5990000,
                'category_name' => 'Tai nghe'
            ],
            [
                'name' => 'Apple Watch Series 9',
                'description' => 'Đồng hồ thông minh với nhiều tính năng sức khỏe',
                'price' => 8990000,
                'category_name' => 'Đồng hồ thông minh'
            ],
            [
                'name' => 'Sony WH-1000XM5',
                'description' => 'Tai nghe chống ồn cao cấp',
                'price' => 7990000,
                'category_name' => 'Tai nghe'
            ],
        ];

        foreach ($products as $productData) {
            $category = Category::where('name', $productData['category_name'])->first();
            if ($category) {
                Product::create([
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'price' => $productData['price'],
                    'category_id' => $category->id,
                ]);
            }
        }
    }
} 