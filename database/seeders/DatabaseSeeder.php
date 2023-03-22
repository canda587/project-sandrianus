<?php

namespace Database\Seeders;
use Illuminate\Support\Str;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\StatusOrder;
use App\Models\Region;
use App\Models\Category;
use App\Models\Item;
use App\Models\Expedition;
use App\Models\ListOrder;
use App\Models\Order;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        

        User::create([
            'region_code' => "ADR-1-CIAC",
            'name' => 'admin',
            'email' => "admin@gmail.com",
            'phone_number' => "08987687890",
            'password' => bcrypt("123456"),
            'is_admin' => true
        ]);

        User::create([
            'region_code' => 'ADR-2-T5UP',
            'name' => 'user',
            'email' => "user@gmail.com",
            'phone_number' => "08987687890",
            'password' => bcrypt("123456"),
            'is_admin' => false
        ]);

        Region::create([
            'code' => "ADR-1-CIAC",
            'province_code' => 12,
            'city_code' => 364,
            'province_name' => "Kalimantan Barat",
            'city_name' => "Pontianak",
            'address_detail' => "Jl. Merdeka"
        ]);

        Region::create([
            'code' => "ADR-2-T5UP",
            'province_code' => 12,
            'city_code' => 391,
            'province_name' => "Kalimantan Barat",
            'city_name' => "Sanggau",
            'address_detail' => "BTN Sanggau Permai"
        ]);

        StatusOrder::create([
            'status_name' => "Payment",
            'slug' => "payment"
        ]);

        StatusOrder::create([
            'status_name' => "Payment Complete",
            'slug' => "payment-complete"
        ]);

        StatusOrder::create([
            'status_name' => "Order Process",
            'slug' => "order-process"
        ]);

        StatusOrder::create([
            'status_name' => "Order Complete",
            'slug' => "order-complete"
        ]);

        StatusOrder::create([
            'status_name' => "Order Cancelled",
            'slug' => "order-cancelled"
        ]);


        // Category::create([
        //     'category_name' => "baju",
        //     'slug' => "baju"
        // ]);

        // Item::create([
        //     'category_id' => 1,
        //     'item_name' => 'item 1',
        //     'item_description' => "item murah",
        //     'item_weight' => 100,
        //     'item_price' => 1000000,
        //     'item_stock' => 100,
        //     'item_image' => "assets/images/img_situs/img3.jpg",
        //     'slug' => "item-1",
        // ]);

        // Item::create([
        //     'category_id' => 1,
        //     'item_name' => 'item 2',
        //     'item_description' => "item murah",
        //     'item_weight' => 100,
        //     'item_price' => 1000000,
        //     'item_stock' => 100,
        //     'item_image' => "assets/images/img_situs/img3.jpg",
        //     'slug' => "item-2",
        // ]);

        // Order::create([
        //     'code' => "ODR-2-64CT6DD",
        //     'user_id' => 2,
        //     'status_id' => 1,
        //     'order_total' => 410000
        // ]);

        // Expedition::create([
        //     'order_code' => "ODR-2-64CT6DD",
        //     'expedition_type' => "jne",
        //     'expedition_service' => "Ongkos Kirim Ekonomis (OKE)",
        //     'estimation' => "4-5",
        //     'weight' => 1200,
        //     'cost' => 6100,
        //     'origin' => "Kalimantan Barat,Pontianak",
        //     'destination' => "Bangka Belitung,Bangka Selatan"
        // ]);

        // ListOrder::create([
        //     'order_code' => "ODR-2-64CT6DD",
        //     'item_id' => 1,
        //     'order_count' => 1,
        //     'order_price' => 1000000,
        //     'order_sub_total' => 1000000
        // ]);
        // ListOrder::create([
        //     'order_code' => "ODR-2-64CT6DD",
        //     'item_id' => 2,
        //     'order_count' => 1,
        //     'order_price' => 1000000,
        //     'order_sub_total' => 1000000
        // ]);


    }
}
