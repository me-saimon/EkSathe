<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    public function initiate(Request $request, Campaign $campaign)
    {
        $request->validate(['amount' => 'required|numeric|min:10']);

        $tran_id = "TRANS_" . uniqid();

        // 1. Create Pending Donation Record
        Donation::create([
            'campaign_id' => $campaign->id,
            'user_id' => Auth::id(),
            'amount' => $request->amount,
            'transaction_id' => $tran_id,
            // 'status' => 'pending',
            'status' => 'verified'
        ]);

        // 2. Prepare SSLCommerz Data
        $post_data = [
            'store_id' => env('SSLC_STORE_ID'),
            'store_passwd' => env('SSLC_STORE_PASSWORD'),
            'total_amount' => $request->amount,
            'currency' => "BDT",
            'tran_id' => $tran_id,
            'success_url' => route('donate.success'),
            'fail_url' => route('donate.fail'),
            'cancel_url' => route('donate.cancel'),
            'cus_name' => Auth::user()->full_name,
            'cus_email' => Auth::user()->email,
            'cus_phone' => Auth::user()->phone ?? '01700000000',
            'shipping_method' => 'NO',
            'product_name' => "Donation for " . $campaign->title,
            'product_category' => "Humanitarian",
            'product_profile' => "non-physical-goods",
        ];

        $mode = env('SSLC_MODE') == 'sandbox' ? 'sandbox' : 'securepay';
        $direct_api_url = "https://{$mode}.sslcommerz.com/gwprocess/v4/api.php";

        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $direct_api_url);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POST, 1);
        curl_setopt($handle, CURLOPT_POSTFIELDS, http_build_query($post_data));
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, FALSE);

        $content = curl_exec($handle);
        $code = curl_getinfo($handle, CURLINFO_HTTP_CODE);

        if ($code == 200 && !(curl_errno($handle))) {
            curl_close($handle);
            $sslcommerzResponse = json_decode($content, true);
            if (isset($sslcommerzResponse['GatewayPageURL']) && $sslcommerzResponse['GatewayPageURL'] != "") {
                return redirect($sslcommerzResponse['GatewayPageURL']);
            }
        }

        return redirect()->back()->with('error', 'Payment initiation failed.');
    }

    // public function success(Request $request)
    // {
    //     $tran_id = $request->input('tran_id');
    //     $donation = Donation::where('transaction_id', $tran_id)->first();

    //     if ($donation) {
    //         $donation->update([
    //             'status' => 'verified',
    //             'payment_data' => json_encode($request->all())
    //         ]);
    //         return redirect()->route('campaigns.show', $donation->campaign_id)->with('success', 'Donation Successful! Thank you.');
    //     }
    // }


    public function success(Request $request)
    {
        $tran_id = $request->input('tran_id');
        $donation = Donation::where('transaction_id', $tran_id)->first();

        if (!$donation) {
            return redirect()->route('campaigns.index')->with('error', 'Transaction not found.');
        }


        $donation->update(['status' => 'verified']);


        if (!auth()->check()) {
            auth()->loginUsingId($donation->user_id);
        }

        return redirect()->route('campaigns.show', $donation->campaign_id)->with('success', 'Thank you for your donation!');
    }

    public function fail(Request $request)
    {
        return redirect()->route('campaigns.index')->with('error', 'Payment Failed.');
    }

    public function cancel(Request $request)
    {
        return redirect()->route('campaigns.index')->with('info', 'Payment Cancelled.');
    }
}
