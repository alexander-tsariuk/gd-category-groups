<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryModel extends Model {
    protected $table = 'categories';

    protected $fillable = [
        'id',
        'name',
        'seo_name',
        'anchor_title',
        'title',
        'h1',
        'description',
        'annotation',
        'group_id',
        'parent_id',
        'show_in_menu',
        'status',
        'created_by',
        'site_id'
    ];
}
