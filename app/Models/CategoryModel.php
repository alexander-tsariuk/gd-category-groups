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

    protected $with = [
        'group',
        'parent'
    ];

    protected $appends = [
        'depth',
        'page_url'
    ];

    /**
     * Превращаем в массив
     * @return array
     */
    public function toArray(): array {
        $array = parent::toArray();
        $array['depth'] = $this->getDepthAttribute();
        $array['page_url'] = $this->getPageUrlAttribute();

        return $array;
    }

    /**
     * Группа категорий
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function group(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne(CategoryGroupModel::class, 'id', 'group_id');
    }

    /**
     * Родительский элемент категории
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function parent(): \Illuminate\Database\Eloquent\Relations\HasOne {
        return $this->hasOne(CategoryModel::class, 'id', 'parent_id');
    }

    /**
     * Аттрибут: уровень вложенности категории
     * @return int
     */
    public function getDepthAttribute(): int {
        return $this->getDepth($this, 1);
    }

    /**
     * Аттрибут: ссылка на страницу категории
     * @return string
     */
    public function getPageUrlAttribute() : string {
        return match ($this->depth) {
            1 => "/{$this->seo_name}/",
            2 => "/{$this->parent()->first()->seo_name}/{$this->seo_name}/",
            3 => "/{$this->getRootCategory($this)->seo_name}/{$this->seo_name}/",
            default => "",
        };
    }

    /**
     * Поиск главной родительской категории
     * @param $category
     * @return mixed
     */
    private function getRootCategory($category): mixed {
        if($parent = $category->parent()->first()) {
            return $this->getRootCategory($parent);
        }

        return $category;
    }

    /**
     * Поиск вложенности категории
     * @param $category
     * @param int $depth
     * @return int
     */
    public function getDepth($category, int $depth = 0): int
    {
        if($parent = $category->parent()->first()) {
            $depth = $this->getDepth($parent, ++$depth);
        }

        return $depth;
    }

    /**
     * Пользовательская часть: получение категории
     * @param string $seoName
     * @return mixed
     */
    public static function frontendGetBySeoName(string $seoName): mixed {
        return self::where('deleted', 0)
            ->where('status', 1)
            ->where('seo_name', trim($seoName))
            ->where('site_id', request()->header('site-id'))
            ->first();
    }
}
