<?php

namespace App\Console\Commands;

use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\Console\Command;

class CalculateFines extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:calculate-fines';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Kalkulasi denda harian untuk peminjaman yang melewati jatuh tempo (Rp 1.000/hari)';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        // Ambil semua peminjaman aktif/overdue yang sudah melewati due_date
        $overdueBorrowings = Borrowing::with('finePayment')
            ->whereIn('status', ['active', 'overdue'])
            ->where('due_date', '<', now()->startOfDay())
            ->get();

        if ($overdueBorrowings->isEmpty()) {
            $this->info('Tidak ada peminjaman terlambat. Tidak ada denda yang dikalkulasi.');
            return self::SUCCESS;
        }

        $processed = 0;

        foreach ($overdueBorrowings as $borrowing) {
            // Hitung selisih hari keterlambatan
            $daysLate  = max(0, $borrowing->due_date->startOfDay()->diffInDays(now()->startOfDay()));
            $totalFine = $daysLate * 1000; // Rp 1.000 per hari

            // Update status peminjaman menjadi overdue
            $borrowing->update(['status' => 'overdue']);

            // Update atau buat data denda
            // Proteksi: Jika denda sudah berstatus 'paid', jangan ubah statusnya
            $existingFine = $borrowing->finePayment;

            if ($existingFine) {
                // Update amount, tapi jangan ubah status jika sudah 'paid'
                $updateData = ['amount' => $totalFine];
                if ($existingFine->status !== 'paid') {
                    $updateData['status'] = 'unpaid';
                }
                $existingFine->update($updateData);
            } else {
                // Buat data denda baru
                Fine::create([
                    'borrowing_id' => $borrowing->id,
                    'amount'       => $totalFine,
                    'status'       => 'unpaid',
                ]);
            }

            $processed++;
        }

        $this->info("Selesai! {$processed} denda telah dikalkulasi.");

        return self::SUCCESS;
    }
}
