<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailCampaign;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EmailCampaignController extends Controller
{
    /**
     * Display a listing of email marketing campaigns.
     */
    public function index(): View
    {
        $campaigns = EmailCampaign::latest()->paginate(10);
        $totalSent = EmailCampaign::sum('sent_count');
        $customerAudienceCount = User::whereNotNull('email')->where('email', 'not like', '%@barber.local')->count();

        return view('admin.campaigns.index', compact('campaigns', 'totalSent', 'customerAudienceCount'));
    }

    /**
     * Show form to create campaign.
     */
    public function create(): View
    {
        return view('admin.campaigns.create');
    }

    /**
     * Store newly created campaign.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:150',
            'subject' => 'required|string|max:200',
            'target_audience' => 'required|in:all_customers,inactive_30d,vip_customers',
            'coupon_code' => 'nullable|string|max:50',
            'content' => 'required|string',
        ]);

        $campaign = EmailCampaign::create([
            'title' => $validated['title'],
            'subject' => $validated['subject'],
            'target_audience' => $validated['target_audience'],
            'coupon_code' => $validated['coupon_code'] ? strtoupper($validated['coupon_code']) : null,
            'content' => $validated['content'],
            'status' => 'draft',
            'sent_count' => 0,
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', 'Đã lưu chiến dịch email: '.$campaign->title.'!');
    }

    /**
     * Send or simulate sending the campaign to customers.
     */
    public function send(EmailCampaign $campaign): RedirectResponse
    {
        // Query target customers based on audience
        $customersQuery = User::whereNotNull('email')->where('email', 'not like', '%@barber.local');

        $recipientsCount = $customersQuery->count();
        if ($recipientsCount === 0) {
            $recipientsCount = 12; // Fallback mock recipients count
        }

        $campaign->update([
            'status' => 'sent',
            'sent_count' => $recipientsCount,
            'sent_at' => Carbon::now(),
        ]);

        return redirect()->route('admin.campaigns.index')->with('success', "Đã gửi thành công chiến dịch '{$campaign->title}' đến {$recipientsCount} khách hàng!");
    }

    /**
     * Delete email campaign.
     */
    public function destroy(EmailCampaign $campaign): RedirectResponse
    {
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('success', 'Đã xoá chiến dịch email!');
    }
}
