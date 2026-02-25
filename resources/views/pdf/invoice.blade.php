<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #333; margin: 40px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 3px solid #1B2A4A; padding-bottom: 15px; }
        .header h1 { color: #1B2A4A; margin: 0; font-size: 28px; }
        .header p { color: #D4A843; margin: 5px 0 0; font-size: 14px; }
        .invoice-number { text-align: right; margin-bottom: 20px; }
        .invoice-number h2 { color: #1B2A4A; margin: 0; }
        .parties { display: table; width: 100%; margin-bottom: 25px; }
        .party { display: table-cell; width: 50%; vertical-align: top; }
        .party h3 { color: #1B2A4A; margin: 0 0 8px; font-size: 13px; text-transform: uppercase; }
        .party p { margin: 2px 0; }
        table.items { width: 100%; border-collapse: collapse; margin-bottom: 25px; }
        table.items th { background: #1B2A4A; color: #fff; padding: 10px; text-align: left; }
        table.items td { padding: 10px; border-bottom: 1px solid #ddd; }
        .totals { float: right; width: 280px; }
        .totals table { width: 100%; }
        .totals td { padding: 6px 10px; }
        .totals .total-row { border-top: 2px solid #1B2A4A; font-weight: bold; font-size: 14px; color: #1B2A4A; }
        .footer { clear: both; margin-top: 50px; text-align: center; color: #999; font-size: 10px; border-top: 1px solid #ddd; padding-top: 10px; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 11px; font-weight: bold; }
        .badge-pending { background: #FEF3CD; color: #856404; }
        .badge-paid { background: #D4EDDA; color: #155724; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Tour Base</h1>
        <p>Digital Job Matching Platform</p>
    </div>

    <div class="invoice-number">
        <h2>{{ $invoice->invoice_number }}</h2>
        <p>Issued: {{ $invoice->issued_at->format('d M Y') }}</p>
        <p>Status: <span class="badge {{ $invoice->payment_status === 'paid' ? 'badge-paid' : 'badge-pending' }}">{{ strtoupper($invoice->payment_status) }}</span></p>
    </div>

    <div class="parties">
        <div class="party">
            <h3>Bill To (Agency)</h3>
            <p><strong>{{ $invoice->agency->agencyProfile?->company_name ?? $invoice->agency->name }}</strong></p>
            <p>{{ $invoice->agency->email }}</p>
            @if($invoice->agency->agencyProfile?->company_phone)
                <p>{{ $invoice->agency->agencyProfile->company_phone }}</p>
            @endif
            @if($invoice->agency->agencyProfile?->company_address)
                <p>{{ $invoice->agency->agencyProfile->company_address }}</p>
            @endif
        </div>
        <div class="party">
            <h3>Guide</h3>
            <p><strong>{{ $invoice->guide->name }}</strong></p>
            <p>{{ $invoice->guide->email }}</p>
            @if($invoice->guide->guideProfile?->license_no)
                <p>License: {{ $invoice->guide->guideProfile->license_no }}</p>
            @endif
        </div>
    </div>

    <table class="items">
        <thead>
            <tr>
                <th>Description</th>
                <th>Job Period</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <strong>{{ $invoice->application->tourJob->title }}</strong><br>
                    <small>{{ ucfirst($invoice->application->tourJob->type) }} — {{ $invoice->application->tourJob->location }}</small>
                </td>
                <td>{{ $invoice->application->tourJob->start_date->format('d M Y') }} — {{ $invoice->application->tourJob->end_date->format('d M Y') }}</td>
                <td style="text-align: right;">RM {{ number_format($invoice->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <div class="totals">
        <table>
            <tr>
                <td>Subtotal</td>
                <td style="text-align: right;">RM {{ number_format($invoice->amount, 2) }}</td>
            </tr>
            <tr>
                <td>Tax (6% SST)</td>
                <td style="text-align: right;">RM {{ number_format($invoice->tax, 2) }}</td>
            </tr>
            <tr class="total-row">
                <td>TOTAL</td>
                <td style="text-align: right;">RM {{ number_format($invoice->total, 2) }}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <p>This is a computer-generated invoice. No signature is required.</p>
        <p>Tour Base &copy; {{ date('Y') }}</p>
    </div>
</body>
</html>
