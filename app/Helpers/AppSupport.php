<?php
namespace App\Helpers;

class AppSupport
{
    public static function appendQueryUrl($key, $value) {
        $old_query = request()->query();
        unset($old_query['page']);
        if(array_key_exists($key, $old_query)) {
            unset($old_query[$key]);
        }
        $mix_old_query = [];
        foreach($old_query as $k => $v) {
            array_push($mix_old_query, $k.'='.$v);
        }
        $new_query = implode('&', $mix_old_query);
        $new_query .= '&' . $key . '=' . $value;
        return $new_query;
    }
}