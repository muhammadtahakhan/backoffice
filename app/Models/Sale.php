<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    use HasFactory;
     protected $fillable = [
        'customer_id',
        'invoice_date',
        'due_date',
        'total_quantity',
        'total_amount',
    ];

     public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

     public function detail()
    {
        return $this->hasMany(SaleDetail::class);
    }

      public function payment()
    {
        return $this->hasMany(SalePayment::class);
    }

    public static function balances(){
          $sql = "SELECT
                    c.name,
                    c.phone,
                    COALESCE(s.total_sale, 0) AS total_sale,
                    COALESCE(sp.paid_amount, 0) AS paid_amount,
                    (COALESCE(s.total_sale, 0) - COALESCE(sp.paid_amount, 0)) AS balance
                FROM
                    customers c
                LEFT JOIN (
                    SELECT
                        s.customer_id,
                        SUM(sd.total) AS total_sale
                    FROM
                        sales s
                    LEFT JOIN
                        sale_details sd ON sd.sale_id = s.id
                    GROUP BY
                        s.customer_id
                ) s ON s.customer_id = c.id
                LEFT JOIN (
                    SELECT
                        s.customer_id,
                        SUM(sp.amount) AS paid_amount
                    FROM
                        sales s
                    LEFT JOIN
                        sale_payments sp ON sp.sale_id = s.id
                    GROUP BY
                        s.customer_id
                ) sp ON sp.customer_id = c.id;
                ";

        $results = DB::select($sql);
        return $results;
    }
}
