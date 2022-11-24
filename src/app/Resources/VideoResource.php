<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class VideoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        
        /*  return parent::toArray($request);  */

     return [
        'id' => $this->id,
        'title' => $this->title,
        'image' => Storage::disk('s3')->temporaryUrl(
            $this->image , now()->addHours(24)
        ),
        'category' => $this->category,
        'score' => $this->score,
        'link' => $this->link,
        'description' => $this->description,
        'created_at' => $this->created_at,
        'count' => $this->count,
        'id_game'=> $this->id_game,
    ]; 

    }
}
