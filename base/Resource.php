<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BASE_Upper_singularResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request The request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
