<?php

namespace App\One\Markdown;

interface Converter
{
    public function toHtml(string $markdown): string;
}
