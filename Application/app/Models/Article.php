<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'title', 'content', 'publish_status', 'approve_status', 'approve_date', 'deleted_at'];
}
