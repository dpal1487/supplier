<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class FeedbackResource extends JsonResource
{
   public function toArray($request)
   {
        return [
            'id'=>$this->id,
            'user'=>$this->user['first_name'].' '.$this->user['last_name'],
            'image'=>$this->user['image']['file_path_small'],
            'category'=>$this->feedbackCategory['name'],
            'rating'=>$this->rating,
            'feedback'=>$this->feedback,
            'date'=>date('d M,y',strtotime($this->created_at))
      ];
   }
}