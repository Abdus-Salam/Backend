<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\JsonResponseFunction as jsonResponse;

class ProductController extends Controller{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return ProductResource::collection(Product::all());
    }

    
    // For server side pagination
    public function getAll($page, $limit){
        $page = $page - 1;
        $limit = $limit;
        $skip = $page * $limit;

        $result = Product::skip($skip)->limit($limit)->get();

        return Response()->json(["data" => ProductResource::collection($result), "totalRecords" => count(Product::all())]);
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request){
        $data = $request->all();
        $data["image"] = $this->upload($request);
        $tag = Product::create($data);
        $data = new ProductResource($tag);
        return jsonResponse::createdSuccessReponse($data);
    }


    private function upload(Request $request){
        if($request->image){
            // validation
           // $validatedData = $request->validate([
           //      "image" => "required|mimes:jpeg,jpg,png|max:2048"
           //  ]);


            $photo = $request->image;
            // take the image
            $image = Image::make($photo);
            // resize as you wish
            $image->fit(600,600);

            // upload the image in your server location
            $thumbnail_filename = time()."_". rand(100000, 999999).".".$photo->getClientOriginalExtension();
            $image->save('storage/productImage/'. $thumbnail_filename);
         
            return $thumbnail_filename;
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tag = Product::find($id);
        
        $data = new ProductResource($tag);
        return jsonResponse::successResponse($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    // public function update(ProductRequest $request, $id){
    //     $data = $request->all();
    //     if($request->image){  
    //        // get previous images. we need to delete from db and file manager
    //         $old_photo = Product::find($request->id)->image;
    //         $data["image"] = $this->upload($request);
    //         // upload first user images
    //         if($data["image"]){
    //             // nowe delete this patient's previous image
    //             unlink(storage_path('app/public/productImage/'.$old_photo));    
    //         }
           
    //     }

    //     $tag = Product::find($id);
    //     $tag->update($data);

    //     $data = new ProductResource($tag);

    //     return jsonResponse::successUpdatedResponse($data);
    // }


    public function productUpdate(Request $request){
        $data = $request->all();
        if($request->id > 0){
            // new image need upload
            if($request->image != null){  
               // get previous images. we need to delete from db and file manager
                $old_photo = Product::find($request->id)->image;
                if($old_photo != $request->image){
                    $data["image"] = $this->upload($request);
                    // upload first user images
                    if($data["image"]){
                        // nowe delete this patient's previous image
                        unlink(storage_path('app/public/productImage/'.$old_photo));    
                    }
                }
               
            }else{ 
                // no image stuff
                // no update image
            }
        }else{
            $data["image"] = $this->upload($request);
        }
        

        $product = Product::find($request->id);
        $product->update($data);

        $result = new ProductResource($product);

        return jsonResponse::successUpdatedResponse($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Animals  $animals
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        $isDeleted = Product::find($id)->delete();
        return ($isDeleted == 0) ? jsonResponse::errorDeleteResponse() : jsonResponse::successDeleteResponse();
    }
}
