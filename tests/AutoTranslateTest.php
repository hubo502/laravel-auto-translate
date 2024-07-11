<?php

use Darko\AutoTranslate\Tests\Models\Page;
use Darko\AutoTranslate\Tests\Models\Person;

beforeEach(function () {
    $data = [
        'title' => ['en' => 'title'], //not translated
        'content' => ['en' => 'content', 'es' => 'content es'], //partial translated
        'desc' => ['en' => 'desc', 'es' => 'desc es', 'ja' => 'desc ja', 'fr' => 'desc fr'], //fully translated

        'blocks' => ['en' => ['title' => 'title', 'description' => 'description', 'other' => 'other']],

    ];
    $this->page = new Page($data);
    $this->page->autoTranslate();
    config()->set('app.locale', 'fr');
});

it('can not translate model not implements autoTranslatable', function () {
    $model = new Person();
    $model->autoTranslate();
})->throws(Exception::class);

it('can translate missing locale', function () {
    expect($this->page->title)->toBe('title - fr');
});

it('can translate block json field', function () {
    expect($this->page->blocks['description'])->toBe('description - fr');
    expect($this->page->blocks['other'])->toBe('other');
});

it('can not override translated field when not force mode', function () {
    expect($this->page->desc)->toBe('desc fr'); //original
});
