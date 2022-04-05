<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryGroupModel extends Model {
    protected $table = 'category_groups';

    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'status',
        'created_by',
        'site_id'
    ];
}
