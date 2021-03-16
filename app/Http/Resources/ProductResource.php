<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;
use Auth;

class ProductResource extends JsonResource{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request){
        // user name
        $user_name = User::find($this->user_id);
        $user_name = $user_name->first_name . " " . $user_name->last_name;

        
        return[
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'price' => $this->price,
            'image' => $this->image,
            'user_id' => $this->user_id,
            'user_name' => $user_name
        ];
    }
}
