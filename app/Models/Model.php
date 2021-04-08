<?php

namespace App\Models;

use Encore\Admin\Traits\DefaultDatetimeFormat;
use Illuminate\Database\Eloquent\Model as Eloquent;

class Model extends Eloquent
{

    use DefaultDatetimeFormat;

    protected $guarded = [];

}
