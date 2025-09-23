<?php

namespace App\Helpers;

use App\Models\Menu;
use App\Models\MenuEmplacement;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class Helper
{
    public static function generateUniqueSlug($title, $model, $column = 'slug')
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while ($model::where($column, $slug)->exists()) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    public static function buildMenu($codeMenu = 'admin-sidebar')
    {
        $emplacementMenu = MenuEmplacement::where('code_menu', $codeMenu)->first();
        $menus = Menu::where('menu_emplacement_id', $emplacementMenu->id)->whereNull('parent_id')->with('children')->orderBy('position')->get();

        return $menus;
    }

    public static function sendSms($phone, $message)
    {
        $smsurl = Setting::where('key', 'sms_url')->first();
        $smsusername = Setting::where('key', 'sms_username')->first();
        $smspassword = Setting::where('key', 'sms_password')->first();
        $smsfrom = Setting::where('key', 'sms_from')->first();

        $response = Http::post($smsurl->value ?? '', [
            'ClientId' => $smsusername->value ?? '',
            'ApiKey' => $smspassword->value ?? '',
            'Message' => $message,
            'MobileNumbers' => str_replace(' ', '', str_replace('+', '', $phone)),
            'SenderId' => $smsfrom->value ?? '',
        ]);

        return $response->json();
    }
}
