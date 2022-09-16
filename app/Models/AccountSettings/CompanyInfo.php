<?php

namespace App\Models\AccountSettings;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CompanyInfo extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
}
