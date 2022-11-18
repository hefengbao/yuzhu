<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EditorjsController extends Controller
{
    public function fetchUrl(Request $request)
    {
        $url = $request->query('url');

        $meta = $this->get_sitemeta($url);

        if (count($meta)) {
            return response()->json([
                'success' => 1,
                'link' => $url,
                'meta' => [
                    'title' => $meta['title'] ?? '',
                    'description' => $meta['description'] ?? '',
                    'image' => [
                        'url' => ''
                    ]
                ]
            ]);
        } else {
            return response()->json([
                'success' => 0
            ]);
        }
    }

    // https://blog.csdn.net/sloafer/article/details/88923717
    private function get_sitemeta($url): array
    {

        $data = file_get_contents($url);

        $meta = array();
        if (!empty($data)) {
            #Title
            preg_match('/<TITLE>([\w\W]*?)<\/TITLE>/si', $data, $matches);
            if (!empty($matches[1])) {
                $meta['title'] = $matches[1];
            }

            #Keywords
            preg_match('/<META\s+name="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);
            if (empty($matches[1])) {
                preg_match("/<META\s+name='keywords'\s+content='([\w\W]*?)'/si", $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+content="([\w\W]*?)"\s+name="keywords"/si', $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+http-equiv="keywords"\s+content="([\w\W]*?)"/si', $data, $matches);
            }
            if (!empty($matches[1])) {
                $meta['keywords'] = $matches[1];
            }

            #Description
            preg_match('/<META\s+name="description"\s+content="([\w\W]*?)"/si', $data, $matches);
            if (empty($matches[1])) {
                preg_match("/<META\s+name='description'\s+content='([\w\W]*?)'/si", $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+content="([\w\W]*?)"\s+name="description"/si', $data, $matches);
            }
            if (empty($matches[1])) {
                preg_match('/<META\s+http-equiv="description"\s+content="([\w\W]*?)"/si', $data, $matches);
            }
            if (!empty($matches[1])) {
                $meta['description'] = $matches[1];
            }
        }

        return $meta;
    }
}
