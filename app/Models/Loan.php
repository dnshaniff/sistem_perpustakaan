<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable('user_id', 'book_id', 'loan_date', 'return_date')]

class Loan extends Model
{
    protected $casts = [
        'loan_date' => 'date',
        'return_date' => 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
