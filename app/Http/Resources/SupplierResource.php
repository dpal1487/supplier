<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'label' => $this->supplier_name . " ($this->display_name)",
            'supplier_name' => $this->supplier_name,
            'display_name' => $this->display_name,
            'email_address' => $this->email_address,
            'website' => $this->website,
            'skype_profile' => $this->skype_profile,
            'linkedin_profile' => $this->linkedin_profile,
            'contact_number' => $this->contact_number,
            'email_address' => $this->email_address,
            'rfq_email' => $this->rfq_email,
            'final_id_emails' => $this->final_id_emails,
            'website' => $this->website,
            'skype_profile' => $this->skype_profile,
            'aol' => $this->aol,
            'mailing_address' => $this->mailing_address,
            'city' => $this->city,
            'state' => $this->state,
            'zipcode' => $this->zipcode,
            'status' => $this->status,
            'final_id' => $this->final_id,
            'traffic_details' => $this->traffic_details,
            'name_of_contact' => $this->name_of_contact,
            'description' => $this->description,
            'country' => new CountryResource($this->country),
            'created_at' => $this->created_at,
            'supplier_redirect' => $this->supplier_redirect,
        ];
    }
}
