<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AddProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'productId'=>$this->id,
                'productCode' => $this->product_code,
                'productName' => $this->product_name,
                'productImage' =>$this->product_image,
                'productPrice'=>$request->product_price

            ];
    }
}
