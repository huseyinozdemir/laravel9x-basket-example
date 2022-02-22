<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['name', 'category_id', 'price', 'stock'];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

}
