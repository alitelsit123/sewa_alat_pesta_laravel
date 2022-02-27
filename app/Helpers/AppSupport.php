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
    public static function timeConverter($datetime) {
        $unix_timestamp = strtotime(now()) - strtotime($datetime);
        $dtf = new \DateTime('@0');
        $converted = new \DateTime('@'.$unix_timestamp);
        $day = $dtf->diff($converted)->format('%a');
        $hour = $dtf->diff($converted)->format('%h');
        $minute = $dtf->diff($converted)->format('%i');
        $second = $dtf->diff($converted)->format('%s');
        return [
            'day' => $day,
            'hour' => $hour,
            'minute' => $minute,
            'second' => $second,
            'conversion_text' => (
                $day > 0 ? 
                $day . ' Hari': (
                    $hour > 0 ? 
                    $hour . ' Jam': (
                        $minute > 0 ? 
                        $minute . ' Menit': $second . ' Detik'
                    ) 
                ) 
            ) 
        ];
    }
    public static function generalSearchFilterTypes() {
        return ['categories', 'products', 'orders', 'users', 'payments', 'chats'];
    }
}