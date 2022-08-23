<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return
            [
                'productId'=>$this->product_id,
                'productCode' => $this->product_code,
                'productName' => $this->product_name,
                'productImage' => 'public/'.$this->product_image,
                'isActive'=>$this->isActive,
            ];
    }
}
