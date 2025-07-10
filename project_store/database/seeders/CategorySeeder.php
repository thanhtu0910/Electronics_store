<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Điện thoại',
            'Laptop',
            'Máy tính bảng',
            'Phụ kiện',
            'Đồng hồ thông minh',
            'Tai nghe',
            'Loa',
            'Camera',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
} 