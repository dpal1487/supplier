<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginActivity extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'login_time', 'logout_time'];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function calculateTotalActiveTime($userId)
    {
        $userActivities = LoginActivity::where('user_id', $userId)
            ->orderBy('login_time')
            ->get();
        $totalActiveTimeSeconds = 0; // Initialize total active time in seconds

        $previousLogoutTime = null;

        foreach ($userActivities as $activity) {
            $loginTime = Carbon::parse($activity->login_time);
            $logoutTime = Carbon::parse($activity->logout_time);

            // Check if the login and logout are on the same day
            if ($loginTime->isSameDay($logoutTime)) {
                // If there was a previous logout time, add the time difference to total
                if ($previousLogoutTime) {
                    $timeDifference = $previousLogoutTime->diffInSeconds($loginTime);
                    $totalActiveTimeSeconds += $timeDifference;
                }
                // Add the current session time to total
                $totalActiveTimeSeconds += $loginTime->diffInSeconds($logoutTime);
            }

            $previousLogoutTime = $logoutTime;
        }

        // Convert total active time to hours, minutes, and seconds
        $totalHours = intdiv($totalActiveTimeSeconds, 3600);
        $totalMinutes = intdiv(($totalActiveTimeSeconds % 3600), 60);
        $totalSeconds = $totalActiveTimeSeconds % 60;

        return sprintf('%02d:%02d:%02d', $totalHours, $totalMinutes, $totalSeconds);
    }
}
