<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Product extends Model
{
    use HasFactory, Searchable;

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'products_categories');
    }

    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', '%'.$value.'%');
    }

    public function scopeOrWhereLike($query, $column, $value)
    {
        return $query->orWhere($column, 'like', '%'.$value.'%');
    }
    public function photos()
    {
        return $this->hasMany(Photo::class);
    }

    public function batches(){
        return $this->hasMany(ProductBatch::class);
    }

    protected $fillable = ['name', 'price', 'quantity', 'description'];
    public $timestamps = false;



}
