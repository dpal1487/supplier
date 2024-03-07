<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletHistoryResource extends JsonResource
{
   public function toArray($request)
   {
        return [
            'wallet_id'=>$this->wallet_id,
            'date'=>$this->date,
            'points'=>$this->points,
            'status'=>$this->status,
            'comments'=>$this->comments,
            'current_points'=>$this->current_points,
            'type'=>$this->payType['type'],
      ];
   }
}