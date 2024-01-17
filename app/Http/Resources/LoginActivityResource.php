<?php

namespace App\Http\Resources;

use App\Models\LoginActivity;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $loginTime = Carbon::parse($this->login_time);
        $logoutTime = Carbon::parse($this->logout_time);

        $timeDifference = $loginTime->diff($logoutTime);

        // Extract hours, minutes, and seconds from the time difference
        $hours = $timeDifference->h;
        $minutes = $timeDifference->i;
        $seconds = $timeDifference->s;

        // Output the results
        $totalTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);
        return [
            'id' => $this->id,
            'name' => $this->user?->first_name . ' ' . $this->user->last_name,
            'login_date' => date('d/M/Y', strtotime($this->created_at)),
            'login_time' => date('h:i A', strtotime($this->created_at)),
            'logout_time' => $this->logout_time ?  date('h:i A', strtotime($this->logout_time)) : '',
            'total_time' => $totalTime,
            'day_time' => (new LoginActivity)->calculateTotalActiveTime($this->user_id),
        ];
    }
}
