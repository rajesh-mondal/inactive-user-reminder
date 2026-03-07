<?php

namespace App\Jobs;

use App\Models\Reminder;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendReminderJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user) {}

    /**
     * Execute the job.
     */
    public function handle(): void {
        Log::info( "Reminder successfully sent to: " . $this->user->email );

        Reminder::create( [
            'user_id' => $this->user->id,
            'type'    => 'inactivity_reminder',
        ] );
    }
}
