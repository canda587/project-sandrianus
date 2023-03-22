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
            'subject' => "you are actually beautiful",
            'description' => "However, for women, we are not good at taking advantage of 
                            the beauty potential that we are born with, therefore this 
                            fashion is perfect for enhancing your beauty."
        ],
        [
            'image' => 'assets/images/img_situs/carousel-2.jpg',
            'subject' => "free-spirited woman",
            'description' => "women should be free to look like they want from simple to 
                            luxurious appearance, unlike in the past which had conditions 
                            to dress according to their status"
        ],
        [
            'image' => 'assets/images/img_situs/carousel-3.jpg',
            'subject' => "appearance is important for women",
            'description' => "As it should be for women, appearance is very important because 
                            appearance reflects the dignity and character of a person"
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
