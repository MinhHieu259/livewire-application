<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use App\NullSetting;

function setting($key)
{
    $setting = Cache::rememberForever('setting', function () {
        return Setting::first() ?? NullSetting::make();
    });

    if ($setting){
        return $setting->{$key};
    }

}
