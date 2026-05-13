<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['category_id', 'title', 'author', 'stock', 'isbn', 'cover_image', 'description'])]
class Book extends Model
{
    use HasFactory;

    /**
     * Get the category this book belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all borrowings for this book.
     */
    public function borrowings(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
