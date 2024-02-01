<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class InvoiceListResource extends JsonResource
{

    public function toArray($request)
    {
        $dateDifferenceInDays = '';
        $beforeOrAfter = '';
        if (!empty($this->interval_date)) {
            $dueDate = Carbon::parse($this->due_date);
            $intervalDate = Carbon::parse($this->interval_date);
            if ($dueDate->lt($intervalDate)) {
                // $intervalDate is before $dueDate
                $beforeOrAfter = 'before';
            } elseif ($dueDate->gt($intervalDate)) {
                // $intervalDate is after $dueDate
                $beforeOrAfter = 'after';
            } else {
                // The dates are equal
                $beforeOrAfter = 'equal';
            }
            $dateDifferenceInDays = $dueDate->diffInDays($intervalDate);
        }
        return [
            'id' => $this->id,
            'client' => $this->client,
            'invoice_number' => $this->invoice_number,
            'type' => $this->type,
            'issue_date' => $this->issue_date,
            'due_date' => $this->due_date,
            'interval_date' => $dateDifferenceInDays ?  $dateDifferenceInDays . ' Days' : '',
            'diffrence_date' => $beforeOrAfter,
            'total_amount' => round($this->total_amount, 2),
            'tax_rate' => $this->tax_rate,
            'conversion_rate' => $this->conversion_rate,
            'currency' => $this->currency,
            'notes' => $this->notes,
            'status' => $this->status,
            'is_gst_paid' => $this->is_gst_paid,
        ];
    }
}
