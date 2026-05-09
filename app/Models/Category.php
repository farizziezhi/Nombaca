<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name'])]
class Category extends Model
{
    use HasFactory;

    /**
     * Get all books in this category.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class);
    }
}
