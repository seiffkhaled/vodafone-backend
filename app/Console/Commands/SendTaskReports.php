<?php

namespace App\Console\Commands;

use App\Mail\ReportMail;
use App\Models\ReportSubscription;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send periodic task reports to users based on their subscription preferences.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $subscriptions = ReportSubscription::all();
        foreach ($subscriptions as $subscription) {
            $tasks = $this->generateTasksForReport($subscription);
            if ($tasks->isNotEmpty()) {
                Mail::to($subscription->user->email)->send(new ReportMail($tasks));
            }
        }
    }
    protected function generateTasksForReport($subscription)
    {
        $startDate = Carbon::parse($subscription->start_date);
        $endDate = $this->getEndDateForFrequency($subscription->frequency);
        return Task::where('user_id', $subscription->user_id)
            ->whereBetween('due_date', [$startDate, $endDate])
            ->get();
    }

    protected function getEndDateForFrequency($frequency)
    {
        switch ($frequency) {
            case 'daily':
                return Carbon::now()->endOfDay();
            case 'weekly':
                return Carbon::now()->endOfWeek();
            case 'monthly':
                return Carbon::now()->endOfMonth();
            default:
                return Carbon::now();
        }
    }
}
