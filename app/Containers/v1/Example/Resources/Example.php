<?php

namespace App\Containers\v1\Example\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Example extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
