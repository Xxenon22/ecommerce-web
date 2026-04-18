<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Transaction extends Model
{
    protected $table = 'transactions';
    protected $fillable = ['user_id', 'restaurant_id', 'total_price', 'status', 'payment_method_id', 'snap_token', 'address_id', 'transaction_code', 'biteship_order_id', 'courier_link'];
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function transactionProducts()
    {
        return $this->hasMany(TransactionProduct::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            // ❗ Jangan generate kalau sudah ada (safety)
            if (!empty($model->transaction_code)) {
                return;
            }

            DB::beginTransaction();

            try {
                $today = Carbon::now()->format('Ymd');

                // Ambil data terakhir hari ini (lock biar aman)
                $lastTransaction = DB::table('transactions')
                    ->whereDate('created_at', Carbon::today())
                    ->whereNotNull('transaction_code')
                    ->lockForUpdate()
                    ->orderBy('transaction_code', 'desc')
                    ->first();

                if ($lastTransaction) {
                    // Ambil 4 digit terakhir
                    $lastNumber = (int) substr($lastTransaction->transaction_code, -4);
                    $newNumber = $lastNumber + 1;
                } else {
                    // Kalau belum ada data hari ini
                    $newNumber = 1;
                }

                // Format jadi 4 digit
                $sequence = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

                // Gabungkan: YYYYMMDD + sequence
                $model->transaction_code = $today . $sequence;

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
    }
}
