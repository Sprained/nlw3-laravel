<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Orphanages extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'about' => $this->about,
            'instructions' => $this->instructions,
            'open_on_weekends' => $this->open_on_weekends,
            'opening_hours' => $this->opening_hours,
            'image' => [
                'id' => $this->idImage,
                'url' => "http://localhost:8000/storage/imgs/$this->path"
            ]
        ];
    }
}
