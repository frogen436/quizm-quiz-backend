<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $primaryKey = 'category_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'category_name',
    ];

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'category_id');
    }
}
