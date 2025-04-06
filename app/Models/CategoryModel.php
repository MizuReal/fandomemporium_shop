<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model
{
    use HasFactory;

    protected $table = 'categories';
    
    protected $fillable = [
        'name', 'status', 'created_by_id'
    ];
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
