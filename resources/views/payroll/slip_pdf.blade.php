<!DOCTYPE html>
<html>
<head>
    <title>Slip Gaji</title>
    <style>
        body { font-family: sans-serif; font-size: 14px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #ddd; padding-bottom: 10px; }
        .header h1 { margin: 0; font-size: 24px; color: #111; }
        .header p { margin: 5px 0 0; color: #666; }
        .info { margin-bottom: 30px; }
        .info table { width: 100%; }
        .info td { padding: 5px 0; }
        .info td.label { font-weight: bold; width: 120px; }
        .details { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .details th, .details td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .details th { background-color: #f8f9fa; }
        .details td.amount { text-align: right; }
        .total-box { border: 2px solid #10b981; background-color: #ecfdf5; padding: 15px; text-align: center; margin-bottom: 30px; }
        .total-box h3 { margin: 0; color: #065f46; font-size: 16px; }
        .total-box p { margin: 5px 0 0; font-size: 20px; font-weight: bold; color: #047857; }
        .footer { text-align: right; margin-top: 50px; }
        .signature { margin-top: 50px; border-top: 1px solid #000; display: inline-block; width: 200px; text-align: center; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>SLIP GAJI</h1>
        <p>Periode: {{ $payroll->run->period_start->format('F Y') }}</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td class="label">Nama Karyawan</td>
                <td>: {{ $payroll->employee->name }}</td>
                <td class="label">Divisi</td>
                <td>: {{ $payroll->employee->division->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Jabatan</td>
                <td>: {{ $payroll->employee->position->name ?? '-' }}</td>
                <td class="label">Tanggal Cetak</td>
                <td>: {{ date('d F Y') }}</td>
            </tr>
        </table>
    </div>

    <table class="details">
        <thead>
            <tr>
                <th>Deskripsi</th>
                <th class="amount">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2"><strong>Pendapatan</strong></td>
            </tr>
            <tr>
                <td style="padding-left: 30px;">Gaji Pokok</td>
                <td class="amount">Rp {{ number_format($payroll->base_salary, 0, ',', '.') }}</td>
            </tr>
            @foreach($payroll->items->where('type', 'allowance') as $item)
            <tr>
                <td style="padding-left: 30px; color: #555;">{{ $item->name }}</td>
                <td class="amount">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr>
                <td style="padding-left: 10px; font-weight: bold;">Total Pendapatan Kotor</td>
                <td class="amount" style="font-weight: bold;">Rp {{ number_format($payroll->base_salary + $payroll->total_earnings, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="2"><strong>Potongan</strong></td>
            </tr>
            @forelse($payroll->items->where('type', 'deduction') as $item)
            <tr>
                <td style="padding-left: 30px; color: #555;">{{ $item->name }}</td>
                <td class="amount">Rp {{ number_format($item->amount, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td style="padding-left: 30px; color: #888; font-style: italic;" colspan="2">Tidak ada potongan</td>
            </tr>
            @endforelse
            <tr>
                <td style="padding-left: 10px; font-weight: bold;">Total Potongan</td>
                <td class="amount" style="font-weight: bold;">Rp {{ number_format($payroll->total_deductions, 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <div class="total-box">
        <h3>Total Gaji Bersih</h3>
        <p>Rp {{ number_format($payroll->net_pay, 0, ',', '.') }}</p>
    </div>

    <div class="footer">
        <p>Hormat Kami,</p>
        <div class="signature">HRD / Keuangan</div>
    </div>
</body>
</html>
