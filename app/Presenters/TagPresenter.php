<?php
/**
 * Author: hefengbao
 * Date: 2016/11/3
 * Time: 16:40
 */

namespace App\Presenters;


class TagPresenter
{
       public function showTags($tags){
           $str='';
           if(!empty($tags)){
               foreach ($tags as $tag){
                      $str = $str.','.$tag->tag_name;
               }
           }
           return trim($str,',');
       }

       public function showTagsWithUrl($tags){
           $str='';
           if(!empty($tags)){
               foreach ($tags as $tag){
                   $str = $str.'、'.'<a href="'.url('/tag').'/'.$tag->tag_name.'" >'.$tag->tag_name.'</a>';
               }
           }
           return trim($str,'、');
       }
}