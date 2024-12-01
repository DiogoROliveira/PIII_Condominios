<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Services\GesApiService;
use Illuminate\Http\Request;

class EmailInvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('admin.mail_invoices.home', compact('invoices'));
    }

    public function send(Request $request, GesApiService $service)
    {
        try {
            $service->authenticate();

            // Decode the JSON string of invoices
            $invoices = json_decode($request->input('selected_invoices'), true);

            if (empty($invoices)) {
                return redirect()->back()->with('error', 'No invoices selected.');
            }

            foreach ($invoices as $invoiceData) {
                // Parse the invoice data as needed
                $invoice = Invoice::find(json_decode($invoiceData, true)['id']);
                $service->sendInvoiceWithMail($invoice, $request->email);
            }
            return redirect()->back()->with('success', 'Invoices sent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
