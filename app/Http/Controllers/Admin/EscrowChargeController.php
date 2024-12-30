<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EscrowCharge;
use App\Models\GeneralSetting;

class EscrowChargeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageTitle = "Charges for escrow";
        $escrowCharge    = EscrowCharge::first();
        $general   = GeneralSetting::first();
        return view('admin.charge.index',compact('pageTitle','general','escrowCharge'));

    }

    public function escrowCharge(Request $request)
    {

        $request->validate([
            "minimum" => "required|numeric",
            "maximum" => "required|numeric",
            "fixed"   => "required|numeric",
            "percent" => "required|numeric"
        ]);

        $escrowCharge =  EscrowCharge::first();
        $escrowCharge->minimum        = $request->minimum;
        $escrowCharge->maximum        = $request->maximum;
        $escrowCharge->fixed_charge   = $request->fixed;
        $escrowCharge->percent_charge = $request->percent;
        $escrowCharge->save();

        $notify[] = ['success', 'Charge setup successfully'];
        return back()->withNotify($notify);
    }

    public function generalCharge(Request $request)
    {
        $request->validate([
            'generalFixed'      => 'required|numeric',
            'generalPercent'    => 'required|numeric'
        ]);

        $general                    = GeneralSetting::first();
        
        $general->fixed_charge      = $request->generalFixed;
        $general->percent_charge    = $request->generalPercent;
        $general->save();

        $notify[] = ['success', 'Charge setup successfully'];
        return back()->withNotify($notify);
    }


}
