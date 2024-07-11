<?php
namespace Darko\AutoTranslate\Tests\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{

    protected $casts = [
        'blocks' => 'array',
    ];

    protected $fillable = ['name'];
}
