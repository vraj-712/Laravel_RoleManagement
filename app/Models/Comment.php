<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'post_id',
        'comment',
        'parent_id',
        'status',
    ];
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function subComments(){
        return $this->hasMany(Comment::class, 'parent_id')->where('status',1);
    }
    public function post(){
        return $this->belongsTo(Post::class);
    }
}
