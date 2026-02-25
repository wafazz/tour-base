<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class InvoicePdfController extends Controller
{
    public function __invoke(Request $request, Invoice $invoice)
    {
        $user = $request->user();

        if (!$user || (!$user->isAdmin() && $user->id !== $invoice->agency_id && $user->id !== $invoice->guide_id)) {
            abort(403);
        }

        $invoice->load(['agency.agencyProfile', 'guide.guideProfile', 'application.tourJob']);

        $pdf = Pdf::loadView('pdf.invoice', compact('invoice'));

        return $pdf->download('Invoice-' . $invoice->invoice_number . '.pdf');
    }
}
