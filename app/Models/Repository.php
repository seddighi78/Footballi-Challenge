<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $source_id
 * @property int $user_id
 * @property string $name
 * @property string|null $language
 * @property string $url
 * @property string $description
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property User $user
 * @property Tag[] $tags
 */
class Repository extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'source_id',
        'user_id',
        'name',
        'language',
        'url',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'repository_tags');
    }
}
