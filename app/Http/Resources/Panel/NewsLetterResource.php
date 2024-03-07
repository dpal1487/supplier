<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class NewsLetterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
        'id'=>$this->id,
        'title'=>$this->title,
        'content'=>$this->content,
        'status'=>$this->status,
        'created_at'=>date('d-m-Y', strtotime($this->created_at)),
        'date'=>date('d', strtotime($this->created_at)),
        'month'=>date('M', strtotime($this->created_at)),
        'year'=>date('Y', strtotime($this->created_at)),
        ];
    }
}