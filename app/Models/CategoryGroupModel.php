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

    public function category(): \Illuminate\Database\Eloquent\Relations\HasMany {
        return $this->hasMany(CategoryModel::class, 'group_id', 'id');
    }

    public static function getMenu(): \Illuminate\Database\Eloquent\Collection|array {
        $siteId = request()->header('site-id');

        return self::with('category')
            ->whereHas('category', function ($query) use ($siteId){
                $query->where('deleted', 0)
                    ->where('status', 1)
                    ->where('site_id', $siteId);
            })
            ->where('deleted', 0)
            ->where('status', 1)
            ->where('site_id', $siteId)
            ->get();
    }
}
