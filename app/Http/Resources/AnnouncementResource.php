<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AnnouncementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'productName' => $this->product_name,
            'head' => $this->head,
            'body' => $this->body,
            'createdAt' => date('d-m-Y h:i', strtotime($this->created_at)),
            'isActive' => $this->isActive,
        ];
    }
}
