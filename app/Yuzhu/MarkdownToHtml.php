<?php

namespace App\Yuzhu;

use League\CommonMark\ConverterInterface;

class MarkdownToHtml
{
    private ConverterInterface $converter;

    public function __construct(ConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function convert($markdown): string
    {
        return $this->converter->convert($markdown)->getContent();
    }
}
