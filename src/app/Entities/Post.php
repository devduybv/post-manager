<?php

namespace VCComponent\Laravel\Post\Entities;

use Cviebrock\EloquentSluggable\Sluggable;
use Cviebrock\EloquentSluggable\SluggableScopeHelpers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use VCComponent\Laravel\Category\Traits\HasCategoriesTrait;
use VCComponent\Laravel\Post\Contracts\PostManagement;
use VCComponent\Laravel\Post\Contracts\PostSchema;
use VCComponent\Laravel\Post\Traits\PostManagementTrait;
use VCComponent\Laravel\Post\Traits\PostQueryTrait;
use VCComponent\Laravel\Post\Traits\PostSchemaTrait;

class Post extends Model implements Transformable, PostSchema, PostManagement
{
    use TransformableTrait, PostSchemaTrait, PostManagementTrait, PostQueryTrait, Sluggable, SluggableScopeHelpers, SoftDeletes, HasCategoriesTrait;

    const STATUS_PENDING   = 0;
    const STATUS_PUBLISHED = 1;

    const HOT = 1;

    protected $fillable = [
        'title',
        'description',
        'content',
        'type',
        'order',
        'status',
        'published_date',
        'author_id',
        'thumbnail',
        'is_hot',
        'slug',
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
            ],
        ];
    }

    public function schema()
    {
        return [
            'alt_image' => [
                'type' => 'string',
                'rule' => [],
            ],
            'is_hot'    => [
                'type' => 'integer',
                'rule' => [],
            ],
        ];
    }

    public function getLimitDescription($limit = 30)
    {
        return Str::limit($this->description, $limit);
    }

    public function getLimitedName($limit = 10)
    {
        return Str::limit($this->name, $limit);
    }

    public function scopeHot($query)
    {
        return $query->where('is_hot', self::HOT);
    }
}
