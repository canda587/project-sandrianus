<?php

namespace App\Models;


class ItemTest
{
    private static $item = [
        [
            'item_code' => '1231',
            'item_name' => 'sabun',
            'item_price' => 500000,
            'item_image' => 'assets/images/img_situs/img3.jpg',
            'item_description' => 'aaaaaaaaasdasdasda asdasdasdasdasd asdasdasd'
        ],
         [
            'item_code' => '12331',
            'item_name' => 'handuk',
            'item_price' => 800000,
            'item_image' => 'assets/images/img_situs/img3.jpg',
            'item_description' => 'aaaaaaaaasdasdasda asdasdasdasdasd asdasdasd'
        ],
         [
            'item_code' => '121',
            'item_name' => 'wipol',
            'item_price' => 850000,
            'item_image' => 'assets/images/img_situs/img3.jpg',
            'item_description' => 'aaaaaaaaasdasdasda asdasdasdasdasd asdasdasd'
        ],
         [
            'item_code' => '12131',
            'item_name' => 'sikat',
            'item_price' => 890000,
            'item_image' => 'assets/images/img_situs/img3.jpg',
            'item_description' => 'aaaaaaaaasdasdasda asdasdasdasdasd asdasdasd'
        ],

        [
            'item_code' => '12131',
            'item_name' => 'sampo',
            'item_price' => 890000,
            'item_image' => 'assets/images/img_situs/img3.jpg',
            'item_description' => 'aaaaaaaaasdasdasda asdasdasdasdasd asdasdasd'
        ],

         [
            'item_code' => '12131',
            'item_name' => 'odol',
            'item_price' => 890000,
            'item_image' => 'assets/images/img_situs/img3.jpg',
            'item_description' => 'aaaaaaaaasdasdasda asdasdasdasdasd asdasdasd'
        ],

    ];


    private static $carousel = [
        [
            'image' => 'assets/images/img_situs/carousel-1.jpg',
            'subject' => "Make my beloved wife happy",
            'description' => "Of course, by buying necessities such as electronics for your loved ones, 
                                it will make it easier for them, so when are you going to buy our products."
        ],
        [
            'image' => 'assets/images/img_situs/carousel-2.jpg',
            'subject' => "Make your home atmosphere comfortable",
            'description' => "With electronic needs that are met in your home, will give the impression of an elegant and comfortable. 
                                make a stunning impression on your home and your guests"
        ],
        [
            'image' => 'assets/images/img_situs/carousel-3.png',
            'subject' => "Trying new things at home is fun",
            'description' => "Of course your children or relatives who visit, will definitely like to play and do various things that they find fun. 
                            well, electronics also provide products that can satisfy their desires"
        ],
        
    ];

    public static function all(){
        return self::$item;
    }

    public static function find($param){
        $item = collect(static::all());

        return $item->firstWhere('item_name',$param);
    }

    public static function all_carousel(){

        return collect(self::$carousel);
    }
}
