<?php

namespace IBekzod\Uploader\Http\Responses;

use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    public static $wrap = false;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'path' => $this->path,
            'name' => $this->name,
            'size' => $this->size,
            'extension' => $this->extension,
        ];
    }
}
