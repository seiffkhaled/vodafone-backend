<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'user' => new UserResource($this->user),
            'title' => $this->title,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'completition_date'=> $this->completion_data,
            'due_date'=> $this->due_date,
            'status'=> $this->status ?? 'Pending',
        ];
    }
}
