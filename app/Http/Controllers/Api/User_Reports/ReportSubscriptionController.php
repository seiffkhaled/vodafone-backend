<?php

namespace App\Http\Controllers\Api\User_Reports;

use App\Http\Controllers\Controller;
use App\Models\ReportSubscription;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportSubscriptionController extends Controller
{
    public function subscribe(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date_format:Y-m-d H|after:today',
            'frequency' => 'required|in:daily,weekly,monthly',
            'report_time' => 'required|integer|between:0,23',
        ]);
        $existingSubscription = ReportSubscription::where('user_id', auth()->id())->first();
        if ($existingSubscription) {
            return response()->json([
                'message' => 'You already have an active subscription.',
            ], 400);
        }
        $user = User::where('id', auth()->id())->first();
        $user->is_subscribed_to_reports = true;
        $user->save();
        $subscription = ReportSubscription::create([
            'user_id' => auth()->id(),
            'start_date' => Carbon::parse($validated['start_date']),
            'frequency' => $validated['frequency'],
            'report_time' => $validated['report_time'],
        ]);
        return response()->json([
            'message' => 'Successfully subscribed to task reports.',
            'subscription' => $subscription,
        ], 201);
    }

    public function unsubscribe()
    {
        $subscription = ReportSubscription::where('user_id', auth()->id())->first();
        if (!$subscription) {
            return response()->json([
                'message' => 'You do not have an active subscription.',
            ], 404);
        }
        $user = User::where('id', auth()->id())->first();
        $user->is_subscribed_to_reports = false;
        $user->save();
        $subscription->delete();
        return response()->json([
            'message' => 'Successfully unsubscribed from task reports.',
        ]);
    }
}
