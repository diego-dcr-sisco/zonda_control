<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|SimpleRole whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SimpleRole extends Model
{
    use HasFactory;
    protected $table = 'simple_role';
    protected $fillable = [
        'name',
    ];
}
