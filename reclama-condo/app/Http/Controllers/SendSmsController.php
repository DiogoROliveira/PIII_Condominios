<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\MonthlyPaymentPhoneNotif;

class SendSmsController extends Controller
{
    public function index()
    {
        MonthlyPaymentPhoneNotif::sendSMS();
        return view('admin.dashboard')->with('success', 'SMS sent successfully');
    }
}
