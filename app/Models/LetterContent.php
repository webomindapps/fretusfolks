<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LetterContent extends Model
{
    public $table = 'letter_content';
    protected $fillable = [
        'type',
        'letter_type',
        'content',
    ];
}
