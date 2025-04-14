<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'quizzes';
    protected $primaryKey = 'quiz_id';
    public $incrementing = true;
    public $timestamps = true;


    protected $nullable =[

    ];

    protected $fillable = [
        'name',
        'category_id',
        'author_id',
        'play_count',
        'description',
        'details'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function questions()
    {
        return $this->hasMany(Question::class, 'quiz_id');
    }

}
