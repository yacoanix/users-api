<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id'         => $this->id,
            'name'       => $this->name,
            'surname'    => $this->surname,
            'photo'      => $this->photo,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
        ];
    }
}
