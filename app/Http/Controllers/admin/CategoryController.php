<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Support\Str;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
       $data = [
            'title' => "Categories Data",
            'categories' => Category::all()
        ];
        return view('pages/admin/category/index',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'title' => "Add Category Data",
            // 'item' => Item::find($param)
        ];
        return view('pages/admin/category/add',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $set_validator = [
            "category_name" => "required",
            "slug" => "required|unique:categories"
        ];

        if($request->file("category_image")){
            $set_validator["category_image"] = "image|file|max:1024";
        }

        $validator = Validator::make($request->all(),$set_validator);

        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                "success" => false,
                "response" => $validator->messages(),
                "message" => "There is something wrong with your input, check again the form Add Category"
            ];

        }
        else{
            $set_data = $validator->validate();
            if($request->file("category_image")){
                $set_data['category_image'] = "storage/".$request->file("category_image")->store("category-images");
            }

            Category::create($set_data);

            $status_code = 200;
            $send_json = [
                "success" => true,
                "response" => "One Data Category has been added"
            ];
        }

        return response()->json($send_json,$status_code);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $data = [
            'title' => "Category Detail",
            'category' => $category
        ];
        return view('pages/admin/category/detail',$data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $data = [
            'title' => "Category Detail",
            'category' => $category
        ];
        return view('pages/admin/category/detail',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $set_validator = [
             "category_name" => "required",
        ];

        if($request->slug != $category->slug){
            $set_validator['slug'] = "required|unique:categories";
        }

        if($request->file("category_image")){
            $set_validator["category_image"] = "image|file|max:1024";
        }

        $validator = Validator::make($request->all(),$set_validator);
        if($validator->fails()){
            $status_code = 422;
            $send_json = [
                "success" => false,
                "response" => $validator->messages(),
                "message" => "There is something wrong with your input, check again the form Update Category"
            ];

        }
        else{
            $set_data = $validator->validate();
             if($request->file("category_image")){
                if ($request->old_image) {
                    Storage::delete(Str::after($request->old_image, 'storage/'));
                }
                $set_data["category_image"] ="storage/".$request->file("category_image")->store("category-images");
            }

            Category::where("id_category",$category->id_category)
                        ->update($set_data);  

            $get_category = Category::firstWhere("id_category",$category->id_category);
            $status_code = 200;
            $send_json = [
                "success" => true,
                "response" => "this Data Category has been Updated",
                
            ];
        }

        return response()->json($send_json,$status_code);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {   
        if ($category->category_image) {
            Storage::delete(Str::after($category->category_image,'storage/'));
        }
        Category::destroy($category->id_category);


        $send_json = [
            'success' => true,
            'response' =>"Category ". $category->category_name. " has been removed from the List Category Data",
            
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
