<?php

namespace App\Http\Resources\Panel;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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

            'id'=>$this->id,
            'transaction_id'=>$this->transaction_id,
            'account_number'=>$this->bank->account_number,
            'user_id'=>$this->user_id,
            'type'=>$this->transactionType->type,
            'amount'=>$this->amount,
            'description'=>$this->description,
            'debit'=>$this->debit,
            'credit'=>$this->credit,
            'balance'=>$this->balance,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
      ];
   }
}