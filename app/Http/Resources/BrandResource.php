<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'image' => $this->image,
            'image_url' => $this->image_url,
            'rating' => $this->rating,
            'rating_percentage' => ($this->rating /4) * 100,
            'geolocation' => $this->geolocation,
            'created_at' => $this->created_at->format(config('app.datetime_format')),
            'created_at_ago' => $this->created_at->diffForHumans(),
            'updated_at' => $this->updated_at->format(config('app.datetime_format')),
            'updated_at_ago' => $this->updated_at->diffForHumans(),
        ];
    }
}
