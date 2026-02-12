<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UniversityResource extends JsonResource
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
            'logo' => $this->logo
                ? asset('storage/' . $this->logo)
                : null,
            'university_name' => $this->university_name,
            'country' => $this->country,
            'city' => $this->city,
            'partner_type' => $this->partner_type,
            'programs' => $this->programs,
            'application_fee' => $this->application_fee,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
