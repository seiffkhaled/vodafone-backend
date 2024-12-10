<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'type' => $this->type,
            'data' => $this->formatData(),
            'read_at' => $this->read_at,
            'created_at' => $this->created_at->toDateString(),
            'updated_at' => $this->updated_at->toDateString(),
            'notifiable_id' => $this->notifiable_id,
            'notifiable_type' => $this->notifiable_type,
        ];
    }
    protected function formatData()
    {
        return json_decode($this->data, true);
    }
}
