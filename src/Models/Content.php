<?php

namespace Netauratech\ContentManager\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
use JsonException;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'content',
        'status',
        'type',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'content_tag');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'content_category');
    }

    /**
     * @throws JsonException
     */
    public function getContent(): mixed
    {
        return json_decode($this->content ?: '[]', true, 512, JSON_THROW_ON_ERROR);
    }

    public function setTitleAttribute(string $value): void
    {
        $this->attributes['title'] = $value;
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value);
        }
    }
}