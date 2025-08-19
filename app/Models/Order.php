<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\PaymentStatus;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_type',
        'description',
        'images',
        'price',
        'status',
        'payment_status',
        'payment_date',
    ];

    // Зв'язок із користувачем
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $casts = [
    'images' => 'array',
    'payment_status' => PaymentStatus::class,
    /**
     * Атрибут 'payment_date' автоматично приводиться до екземпляра DateTime.
     */
    'payment_date' => 'datetime',

];

    /**
     * Перевіряє, чи замовлення оплачено
     * 
     * @return bool
     */
    public function isPaid(): bool
    {
        return $this->payment_status === PaymentStatus::Paid ||
               $this->payment_status === PaymentStatus::Cash;
    }

}
