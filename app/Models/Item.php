<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory,Sluggable;

    protected $guarded = ['id_item'];

    protected $primaryKey = 'id_item';

    protected $with = ['category'];

    public function category(){
        return $this->belongsTo(Category::class,"category_id");
    }

    public function cart(){
        return $this->HasOne(Cart::class,"item_id");
    }

    public function scopeFilter($query, array $filters){
        
        $query->when($filters['category'] ?? false, fn ($query,$category) =>

            $query->whereHas('category', fn ($query) => 
                $query->where('slug',$category)
            )
        
    );

        $query->when($filters['item'] ?? false, function ($query,$item) {
            if($item == "out-of-stock"){
                return $query->whereBetween("item_stock",[0,10]);
            }

            
        }); 
       

        
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'item_name'
            ]
        ];
    }
}
