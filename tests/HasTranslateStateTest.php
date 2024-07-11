<?php

use Darko\AutoTranslate\Tests\Models\Page;

beforeEach(function () {
    $data = [
        'title' => ['en' => 'hello'],
        'content' => ['en' => 'works', 'es' => 'works es'],
        'desc' => ['en' => 'hello', 'es' => 'hello es', 'ja' => 'hello ja', 'fr' => 'hello fr'],
    ];
    $this->page = new Page($data);
});

it('获取字段的源值', function () {
    expect($this->page->getTransFieldBaseValue('title'))->toBe('hello');
    expect($this->page->getTransFieldBaseValue('content'))->toBe('works');
    expect($this->page->getTransFieldBaseValue('blocks'))->toBeEmpty();
});

it('获取有源值的字段', function () {
    expect($this->page->getTransFieldsHasBaseValue()->toArray())->toContain('title', 'content', 'desc');
});

it('计算翻译完成度', function () {
    expect($this->page->trans_rate)->toBe(round(7 / 12, 2));
});

it('翻译完成度标签', function () {
    expect($this->page->trans_rate_label)->toBe("58%");
});

it("获取某个字段没有翻译的Locales", function () {
    expect($this->page->getTransFieldEmptyLocales('title')->toArray())->toContain('fr', 'es', 'ja');
    expect($this->page->getTransFieldEmptyLocales('content')->toArray())->toContain('fr', 'ja');
    expect($this->page->getTransFieldEmptyLocales('desc')->toArray())->toBeEmpty();
});

it("获取应该翻译的字段", function () {
    expect($this->page->getFieldsShouldTranslate()->toArray())->toContain('title', 'content');
    expect($this->page->getFieldsShouldTranslate(force: true)->toArray())->toContain('title', 'content', 'desc');

    $this->page->setTranslation('blocks', 'en', ['key' => 'value']);

    expect($this->page->getFieldsShouldTranslate()->toArray())->toContain('title', 'content', 'blocks');
    expect($this->page->getFieldsShouldTranslate(force: true)->toArray())->toContain('title', 'content', 'desc', 'blocks');
});
