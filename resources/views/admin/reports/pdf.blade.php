<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Sirkulasi - NOMBACA</title>
    <style>
        /* CSS murni untuk PDF (DomPDF) */
        @page {
            margin: 40px 40px;
        }

        body {
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 11px;
            color: #1f2937;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        
        /* HEADER (KOP SURAT) */
        .header-container {
            width: 100%;
            margin-bottom: 25px;
            border-bottom: 3px solid #000;
            padding-bottom: 15px;
            position: relative;
        }

        .header-title {
            margin: 0;
            font-size: 26px;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .header-subtitle {
            margin: 5px 0 0 0;
            font-size: 12px;
            color: #4b5563;
        }

        .print-date {
            position: absolute;
            top: 10px;
            right: 0;
            font-size: 10px;
            color: #6b7280;
            text-align: right;
        }

        /* SUMMARY BLOCK */
        .summary-box {
            background-color: #f3f4f6;
            padding: 15px;
            margin-bottom: 30px;
        }
        
        .summary-box p {
            margin: 5px 0;
            font-size: 12px;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 40px;
        }
        
        th {
            background-color: #f9fafb;
            color: #374151;
            font-size: 10px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 10px;
            text-align: left;
            border-bottom: 2px solid #e5e7eb;
        }
        
        td {
            padding: 12px 10px;
            border-bottom: 1px solid #f3f4f6;
            vertical-align: middle;
        }
        
        /* Zebra Striping */
        tbody tr:nth-child(even) {
            background-color: #fcfcfc;
        }

        .user-name {
            font-weight: bold;
            color: #111827;
            display: block;
            margin-bottom: 2px;
        }

        .user-email {
            font-size: 9px;
            color: #6b7280;
        }
        
        .badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-active { background-color: #dbeafe; color: #1e40af; }
        .badge-returned { background-color: #d1fae5; color: #065f46; }
        .badge-overdue { background-color: #fee2e2; color: #991b1b; }
        
        .text-right { text-align: right; }
        .text-center { text-align: center; }

        /* SIGNATURE BLOCK */
        .signature-block {
            width: 250px;
            float: right;
            text-align: center;
            margin-top: 30px;
        }

        .signature-block p {
            margin: 0;
            padding: 0;
        }

        .signature-title {
            margin-bottom: 80px !important; /* Space for signature */
        }

        .signature-name {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Clearfix */
        .clearfix::after {
            content: "";
            clear: both;
            display: table;
        }

    </style>
</head>
<body>

    <div class="header-container">
        <h1 class="header-title">NOMBACA DIGITAL LIBRARY</h1>
        <p class="header-subtitle">Laporan Resmi Transaksi Sirkulasi & Tagihan Denda</p>
        
        <div class="print-date">
            Tanggal Cetak:<br>
            <strong>{{ now()->format('d F Y, H:i') }} WITA</strong>
        </div>
    </div>

    <div class="summary-box">
        <p>Ringkasan Laporan:</p>
        <p>• Total Transaksi: <strong>{{ $borrowings->count() }} Peminjaman</strong></p>
        <p>• Total Pendapatan Denda (Lunas): <strong>Rp {{ number_format($totalCollected, 0, ',', '.') }}</strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">#</th>
                <th width="20%">Peminjam</th>
                <th width="22%">Judul Buku</th>
                <th width="13%">Tgl Pinjam</th>
                <th width="13%">Tgl Kembali</th>
                <th width="12%" class="text-center">Status</th>
                <th width="15%" class="text-right">Denda (Status)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $index => $borrowing)
            <tr>
                <td class="text-center text-gray-500">{{ $index + 1 }}</td>
                <td>
                    <span class="user-name">{{ $borrowing->user->name }}</span>
                    <span class="user-email">{{ $borrowing->user->email }}</span>
                </td>
                <td style="font-weight: bold; color: #374151;">{{ $borrowing->book->title }}</td>
                <td>{{ $borrowing->borrow_date->format('d/m/Y') }}</td>
                <td>{{ $borrowing->return_date ? $borrowing->return_date->format('d/m/Y') : '-' }}</td>
                <td class="text-center">
                    @if($borrowing->status === 'pending')
                        <span class="badge badge-pending">Menunggu</span>
                    @elseif($borrowing->status === 'active')
                        <span class="badge badge-active">Dipinjam</span>
                    @elseif($borrowing->status === 'returned')
                        <span class="badge badge-returned">Selesai</span>
                    @elseif($borrowing->status === 'overdue')
                        <span class="badge badge-overdue">Terlambat</span>
                    @endif
                </td>
                <td class="text-right">
                    @if($borrowing->finePayment)
                        <strong style="{{ $borrowing->finePayment->status === 'paid' ? 'color: #10b981;' : 'color: #ef4444;' }}">
                            Rp {{ number_format($borrowing->finePayment->amount, 0, ',', '.') }}
                        </strong><br>
                        <span style="font-size: 9px; font-weight: bold; {{ $borrowing->finePayment->status === 'paid' ? 'color: #10b981;' : 'color: #ef4444;' }}">
                            {{ $borrowing->finePayment->status === 'paid' ? 'LUNAS' : 'BELUM BAYAR' }}
                        </span>
                    @else
                        <span style="color: #9ca3af;">-</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 30px;">Tidak ada data sirkulasi yang ditemukan pada periode ini.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="clearfix">
        <div class="signature-block">
            <p style="margin-bottom: 5px;">Mengetahui,</p>
            <p class="signature-title">Kepala Perpustakaan</p>
            <p class="signature-name">(.................................................)</p>
            <p style="font-size: 10px; color: #6b7280; margin-top: 5px;">NIP. ........................................</p>
        </div>
    </div>

</body>
</html>
