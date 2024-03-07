<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
   /**
    * Transform the resource collection into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
   public function toArray($request)
   {
      return [
         'id' => $this->id,
         'imageUrl' => $this['image']['file_path'],
         'content' => $request->segment(3) == 'blogs' ? substr($this->content, 0, 100) : $this->content,
         'published' => $this->published,
         'title' => $this->title,
         'slug' => $this->slug,
         'date' => date('d M,y', strtotime($this->created_at))
      ];
   }
}
