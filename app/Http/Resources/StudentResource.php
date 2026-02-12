<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'student' => $this->student,
            'email' => $this->email,
            'profile_image' => $this->profile_image
                ? asset('storage/' . $this->profile_image) 
                : null, 
            'course' => $this->course,
            'applied_university' => $this->applied_university,
            'status' => $this->status,
            'application' => $this->application,
            'counselor' => $this->counselor,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
