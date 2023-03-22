<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [
            'title' => "Product Data",
            'items' => Item::filter(request(['category','item']))->paginate(8)->withQueryString(),
            'categories' => Category::all()
        ];
        return view('pages/admin/item/index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => "Add Product Data",
            'categories' => Category::all()
        ];
        return view('pages/admin/item/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(),[
            "category_id" => "required",
            "item_name" => "required|max:100",
            "item_description" => "nullable",
            "item_weight" => "required|numeric|min:1",
            "item_stock" => "required|numeric|min:1",
            "item_price" => "required|numeric|min:1",
            "item_image" => "required|image|max:1024",
            "slug" => "required|unique:items"
        ]);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                "success" => false,
                "response" => $validator->messages(),
                "message" => "Your input is wrong, check the add product form again"
            ];
        }
        else{
            $set_data = $validator->validate();
            if($request->file("item_image")){
                $set_data['item_image'] ="storage/".$request->file("item_image")->store("item-images");
                
            }

            Item::create($set_data);
            $status_code = 200;
            $send_json = [
                "success" => true,
                "response" => "One Product Data has been successfully Added in Product List",
                // "message" => "Your input is wrong, check the add product form again"
            ];
        }





        return response()->json($send_json,$status_code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {
        $data = [
            'title' => "Product Detail",
            'item' => $item,
            'categories' => Category::all()
        ];
        return view('pages/admin/item/detail',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $set_validator = [
            "category_id" => "required",
            "item_name" => "required|max:100",
            "item_description" => "nullable",
            "item_weight" => "required|numeric|min:1",
            "item_stock" => "required|numeric|min:1",
            "item_price" => "required|numeric|min:1",
        ];

        if($item->slug != $request->slug){
            $set_validator['slug'] = "required|unique:items";
        }

        if($request->file("item_image") && $request->item_image != "undefined"){
            $set_validator['item_image'] =  "required|image|max:1024";
        }

        $validator = Validator::make($request->all(),$set_validator);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                'success' => false,
                'response' => $validator->messages(),
                'message' => "Your input is wrong, check the add product form again"
            ];
        }
        else {
            $set_data = $validator->validate();
            if($request->file("item_image")){
                Storage::delete(Str::after($item->item_image,"storage/"));
                $set_data['item_image'] = $request->file("item_image")->store("item-images");
            }

            Item::where("id_item",$item->id_item)
                ->update($set_data);
            $status_code = 200;
            $send_json = [
                'success' => true,
                'response' => "this Data Product has been Updated"
            ];
        }



        return response()->json($send_json,$status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Item  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(Item $item)
    {   
        if ($item->item_image) {
            Storage::delete(Str::after($item->item_image,"storage/"));
        }
        Item::destroy($item->id_item);

        $send_json = [
            'success' => true,
            'response' =>"Product ". $item->item_name. " has been removed from the List Product Data",
            
        ];

        return response()->json($send_json,200);

        
    }

    public function generate_slug(Request $request){
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);

        $send_json = [
            "success" => true,
            "response" => $slug
        ];

        return response()->json($send_json,200);
    }
}
