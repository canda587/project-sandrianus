<?php

namespace App\Models;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory,Sluggable;

    protected $guarded = ['id_category'];

    protected $primaryKey = 'id_category';

    public function Items(){
        return $this->HasMany(Item::class,"category_id");
    }

    public function scopeFilter($query){
         $query->whereHas('items', fn ($query) => 
                $query->where('item_stock',">",0)
        );   
        

       
       

        
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'category_name'
            ]
        ];
    }
}
