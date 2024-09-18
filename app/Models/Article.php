<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        "title" => "string",
        "subtitle" => "string",
        "content" => "string",
        "user_id" => "int",
        "photo" => "string",
        "date" => "string",
        "time" => "string"
    ];
}
