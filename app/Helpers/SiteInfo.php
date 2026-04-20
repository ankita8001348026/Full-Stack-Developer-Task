<?php

namespace App\Helpers;

use App\Models\{Product, Setting};

class SiteInfo
{
    // Website information
    public static function info()
    {
        $setting = Setting::first();
        $data['site_name'] = $setting['site_name'];
        $data['site_logo'] = $setting['site_logo'];
        $data['site_fav_icon'] = $setting['site_fav_icon'];
        $data['copyright'] = $setting['copyright'];
        $data['footer_text'] = $setting['footer_text'];
        $data['facebook'] = $setting['facebook'];
        $data['twitter'] = $setting['twitter'];
        $data['linkedin'] = $setting['linkedin'];
        $data['instagram'] = $setting['instagram'];
        $data['email'] = $setting['email'];
        $data['phone'] = $setting['phone'];
        $data['address'] = $setting['address'];
        $data['map_location'] = $setting['map_location'];
        $data['contact_title1'] = $setting['contact_title1'];
        $data['contact_title2'] = $setting['contact_title2'];
        $data['contact_title3'] = $setting['contact_title3'];
        return $data;
    }
    // Proparty types
    public static function products()
    {
        $products = Product::selectColumns()->get();
        return $products;
    }
}
