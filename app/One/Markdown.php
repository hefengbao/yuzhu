<?php

namespace App\One;

use League\HTMLToMarkdown\HtmlConverter;
use Parsedown;
use Purifier;

class Markdown
{
    protected $htmlParser;
    protected $markdownParser;

    public function __construct()
    {
        $this->htmlParser = new HtmlConverter(['header_style' => 'atx']);
        $this->markdownParser = new Parsedown();
    }

    public function convertHtmlToMarkdown($html)
    {
        return $this->htmlParser->convert($html);
    }

    public function convertMarkdownToHtml($markdown)
    {
        $convertedHtml = $this->markdownParser->setBreaksEnabled(true)->text($markdown);
        $convertedHtml = Purifier::clean($convertedHtml, 'post_content');

        return $convertedHtml;
    }
}