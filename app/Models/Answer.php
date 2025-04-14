<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answers';
    protected $primaryKey = 'answer_id';
    public $incrementing = true;
    public $timestamps = false;

    protected $fillable = [
        'question_id',
        'content',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
