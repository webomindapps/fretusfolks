<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CandidateDocuments extends Model
{
    public $table = 'candidate_documents';

    public $fillable = [
        'emp_id',
        'name',
        'path',
        'status'
    ];
}
