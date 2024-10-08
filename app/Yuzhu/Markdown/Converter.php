<?php

namespace App\Yuzhu\Markdown;

interface Converter
{
    public function toHtml(string $markdown): string;
}
