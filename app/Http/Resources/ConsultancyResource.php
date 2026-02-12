<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConsultancyResource extends JsonResource
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
            'consultancy_name' => $this->consultancy_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'country' => $this->country,
            'service_fee' => $this->service_fee,
            'currency' => $this->currency,
            'students' => $this->students,
            'status' => $this->status,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
