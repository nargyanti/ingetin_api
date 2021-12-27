<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Category;

class Todo extends Model
{
    use HasFactory;

    protected $table = 'todos';    

    protected $fillable = [        
        'name',
        'description',
        'due_date',
        'due_time',
        'category_id',        
        'is_done',
    ];

    protected $hidden = [
        'user_id',
    ];

    protected $casts = [
        'done' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}