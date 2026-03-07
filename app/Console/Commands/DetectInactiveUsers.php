<?php

namespace App\Console\Commands;

use App\Jobs\SendReminderJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DetectInactiveUsers extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:detect-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find users inactive for 7 days and dispatch reminder jobs';

    /**
     * Execute the console command.
     */
    public function handle() {
        $days = config( 'app.inactivity_days', 7 );
        $threshold = Carbon::now()->subDays( $days );

        $inactiveUsers = User::where( 'last_login_at', '<', $threshold )
            ->whereDoesntHave( 'reminders', function ( $query ) {
                $query->whereDate( 'created_at', Carbon::today() );
            } )
            ->get();

        if ( $inactiveUsers->isEmpty() ) {
            $this->info( 'No inactive users found today.' );
            return;
        }

        foreach ( $inactiveUsers as $user ) {
            SendReminderJob::dispatch( $user );
        }

        $this->info( "Successfully dispatched " . $inactiveUsers->count() . " reminder jobs." );
    }
}
