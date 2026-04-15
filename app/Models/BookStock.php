<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['book_id', 'quantity'])]

class BookStock extends Model
{
    use HasFactory;

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
