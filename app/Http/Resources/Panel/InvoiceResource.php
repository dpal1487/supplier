<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class InvoiceResource extends JsonResource
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
        'before_gst_amount'=>$this->before_gst_amount,
        'conversion_rate'=>$this->conversion_rate,
        'created_at'=>$this->created_at,
        'due_date'=>$this->due_date,
        'days'=>$this->days,
        'gst_amount'=>$this->gst_amount,
        'id'=>$this->id,
        'invoice_status'=>$this->invoice_status ,
        'is_gst'=>$this->is_gst,
        'is_gst_paid'=>$this->is_gst_paid,
        'issue_date'=>$this->issue_date,
        'items'=>$this->items,
        'notes'=>$this->notes,
        'partner'=>$this->partner,
        'total_amount'=>$this->total_amount,
        'total_amount_usd'=>$this->total_amount_usd,
        'updated_at'=>$this->updated_at,
        ];
    }
}