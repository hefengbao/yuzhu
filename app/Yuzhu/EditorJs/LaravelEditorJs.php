<?php

namespace App\Yuzhu\EditorJs;

use EditorJS\EditorJS;
use EditorJS\EditorJSException;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

/**
 * https://github.com/alaminfirdows/laravel-editorjs
 */
class LaravelEditorJs
{
    /**
     * Render blocks
     */
    public function render(string $data): string
    {
        try {
            $configJson = json_encode(config('laravel_editorjs.config') ?: []);

            $editor = new EditorJS($data, $configJson);

            $renderedBlocks = [];

            foreach ($editor->getBlocks() as $block) {

                $viewName = 'editorjs.blocks.' . Str::snake($block['type'], '-');

                if (!View::exists($viewName)) {
                    $viewName = 'editorjs.blocks.not-found';
                }

                $renderedBlocks[] = View::make($viewName, ['data' => $block['data']])->render();
            }

            return implode($renderedBlocks);
        } catch (EditorJSException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
