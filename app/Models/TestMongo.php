<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestMongo extends Model
{
    protected $connection = 'mongodb';
    protected $table = 'test_collection';

    protected $fillable = [
        'name',
        'email',
        'data'
    ];
}