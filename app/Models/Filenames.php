<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string|null $folder Carpeta donde se almacena el archivo
 * @property int|null $tenant_id
 * @property string $name
 * @property string $type
 * @property string $code
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereFolder($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Filenames whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Filenames extends Model
{
    use HasFactory;

    protected $table = 'filenames';
    protected $fillable = [
        'id',
        'name',
        'type',
    ];
}
