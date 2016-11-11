<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Version extends Model
{
    protected $fillable = [
        'device', 'version_code', 'version_name', 'app_url', 'changes'
    ];
}
