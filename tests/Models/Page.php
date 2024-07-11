<?php

namespace Darko\AutoTranslate\Tests\Models;

use Darko\AutoTranslate\Contracts\Models\AutoTranslatable;
use Darko\AutoTranslate\Models\Traits\HasAutoTranslate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends Model implements AutoTranslatable
{
    use HasAutoTranslate, HasFactory;

    protected $casts = [
        'blocks' => 'array',
    ];

    protected static $factory = PageFactory::class;

    protected $fillable = ['title', 'content', 'blocks', 'desc'];

    public $translatable = ['title', 'content', 'blocks', 'desc'];

    public $json_translatable = ['title', 'description'];
}
