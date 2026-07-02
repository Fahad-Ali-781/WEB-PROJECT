<?php

namespace Database\Seeders;

use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Review;
use App\Models\CartItem;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Reset transactional and engagement data before loading the new catalog.
        OrderItem::query()->delete();
        Order::query()->delete();
        CartItem::query()->delete();
        Cart::query()->delete();
        Favorite::query()->delete();
        Review::query()->delete();

        // Replace existing catalog with a fresh gaming-only catalog.
        Product::query()->delete();
        Category::query()->delete();

        // Create a test user
        User::updateOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        // Create an admin user
        $this->call(\Database\Seeders\AdminUserSeeder::class);

        // Gaming demo products
        $this->call(GamingSeeder::class);
    }
}
