<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Option;
use App\Models\Post;
use Cache;
use Illuminate\Support\Arr;

class OptionService2
{
    protected $option;

    protected $category;

    protected $post;

    public function __construct(Option $option, Category $category, Post $post)
    {
        $this->option = $option;
        $this->category = $category;
        $this->post = $post;
    }

    /**
     * Save option
     *
     * @return bool
     */
    public function save($data)
    {
        Cache::forget('option');
        if (!isset($data['close_register'])) {
            $this->option->updateOrCreate(['option_name' => 'close_register'], ['option_name' => 'close_register', 'option_value' => 0]);
        }
        foreach ($data as $item => $value) {
            $this->option->updateOrCreate(['option_name' => $item], ['option_name' => $item, 'option_value' => $value]);
        }

        return $this->getAll();
    }

    /**
     * get all option
     *
     * @return array $option
     */
    public function getAll()
    {
        $optionCache = Cache::rememberForever('option', function () {
            $options = $this->option->select(['name', 'value'])->get()->toArray();
            $option = [];
            if (is_array($options) && !empty($options)) {
                foreach ($options as $value) {
                    $option = Arr::add($option, $value['name'], $value['value']);
                }
            }

            return $option;
        });

        return $optionCache;
    }

    public function getOptionByName($name)
    {
        return $this->option->firstOrFail($name);
    }

    /**
     * 用于后台编辑时显示的菜单
     *
     * @return string
     */
    public function getMenu()
    {
        $option = $this->getAll();
        $option_menu = array_key_exists('mainmenu', $option) ? json_decode($option['mainmenu']) : null;
        $html = '';
        if ($option_menu == null) {
            return '';
        }
        foreach ($option_menu as $menu) {
            $html .= $this->_getMenu($menu);
        }

        return $html;
    }

    public function _getMenu($menu)
    {
        $html = '';
        $children = '';
        $str = explode('_', $menu->id, 2);
        $html .= $this->_menu($str[0], $str[1], $menu->id);
        if (isset($menu->children)) {
            $ol_start = '<ol class="dd-list">';
            $ol_end = '</ol>';
            $childrenTemp = '';
            foreach ($menu->children as $menu) {
                $childrenTemp .= $this->_getMenu($menu) . '</li>';
            }
            $children .= $ol_start . $childrenTemp . $ol_end;
        }
        $html .= $children . '</li>';

        return $html;
    }

    public function _menu($flag, $id, $menu_id)
    {
        $html = '';
        if ($flag == 'page') {
            $page = $this->post->select('post_title', 'post_slug')
                ->where('id', $id)
                ->where('post_type', 'page')
                ->get();
            $html = '<li class="dd-item dd3-item" data-id="' . $menu_id . '">' .
                '<div class="dd-handle dd3-handle"></div><div class="dd3-content"><span>' . $page[0]['post_title'] . '</span><span class="pull-right">' .
                '<a href="javascript:;" class="delete">x</a></span></div>';
        } elseif ($flag == 'category') {
            $category = $this->category->select('category_name', 'category_slug')
                ->where('id', $id)
                ->get();
            $html = '<li class="dd-item dd3-item" data-id="' . $menu_id . '">' .
                '<div class="dd-handle dd3-handle"></div><div class="dd3-content"><span>' . $category[0]['category_name'] . '</span><span class="pull-right">' .
                '<a href="javascript:;" class="delete">x</a></span></div>';

        } else {
            $html = '<li class="dd-item dd3-item" data-id="' . $menu_id . '">' .
                '<div class="dd-handle dd3-handle"></div><div class="dd3-content"><span>' . $flag . '</span><span class="pull-right">' .
                '<a href="javascript:;" class="delete">x</a></span></div>';
        }

        return $html;
    }

    /**
     * 博客显示菜单
     *
     * @return string
     */
    public function getMainMenu()
    {
        $option = $this->getAll();
        $option_menu = array_key_exists('mainmenu', $option) ? json_decode($option['mainmenu']) : null;
        $html = '';
        if ($option_menu == null) {
            return '';
        }
        foreach ($option_menu as $menu) {
            $html .= $this->_getMainMenu($menu);
        }

        return $html;
    }

    public function _getMainMenu($menu)
    {
        $html = '<li ';
        $children = '';
        $str = explode('_', $menu->id, 2);
        $hasChildren = false;
        if (isset($menu->children)) {
            $hasChildren = true;
            $html .= 'class="dropdown"';
            $ul_start = '<ul class="dropdown-menu">';
            $ul_end = '</ul>';
            $childrenTemp = '';
            foreach ($menu->children as $menu) {
                $childrenTemp .= $this->_getMainMenu($menu);
            }
            $children .= $ul_start . $childrenTemp . $ul_end;
        }
        $html .= ' >';
        $html .= $this->_mainMenu($str[0], $str[1], $hasChildren);
        $html .= $children . '</li>';

        return $html;
    }

    public function _mainMenu($flag, $id, $hasChildren)
    {
        $class = '';
        $caret = '';
        if ($hasChildren) {
            $class = 'class="dropdown-toggle" data-toggle="dropdown"';
            $caret = '<b class="caret"></b>';
        }
        $html = '';
        if ($flag == 'page') {
            $page = $this->post->select('post_title', 'post_slug')
                ->where('id', $id)
                ->where('post_type', 'page')
                ->get();
            $html = '<a href="' . route('page.show', $page[0]['post_slug']) . '"' . $class . '>' . $page[0]['post_title'] . $caret . '</a>';
        } elseif ($flag == 'category') {
            $category = $this->category->select('category_name', 'category_slug')
                ->where('id', $id)
                ->get();
            $html = '<a href="' . route('category.show', $category[0]['category_slug']) . '"' . $class . '>' . $category[0]['category_name'] . $caret . '</a>';
        } else {
            $html = '<a href="' . $id . '"' . $class . '>' . $flag . $caret . '</a>';
        }

        return $html;
    }
}
