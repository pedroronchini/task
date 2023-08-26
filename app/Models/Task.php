<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'tasks';
    protected $fillable = [
        'title',
        'description',
        'attached_files',
        'completed',
        'created_at',
        'completed_at',
        'updated_at',
        'deleted_at',
        'user_id'
    ];

    protected $casts = [
        'attached_files' => 'array',
        'completed' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
