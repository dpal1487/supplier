<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceResource extends JsonResource
{
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
            'client' => $this->client,
            'from_address' => $this->from_address,
            'to_address' => $this->to_address,
            'invoice_number' => $this->invoice_number,
            'type' => $this->type,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'selected_days' => $this->add_days,
            'total_amount' => $this->total_amount,
            'tax_rate' => $this->tax_rate,
            'conversion_rate' => $this->conversion_rate,
            'currency' => $this->currency,
            'notes' => $this->notes,
            'status' => $this->status,
            'items' => $this->items,
            'date' => date("m/d/Y", strtotime($this->created_at)),
        ];
    }
}
