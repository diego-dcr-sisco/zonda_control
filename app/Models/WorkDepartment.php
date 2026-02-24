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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|WorkDepartment whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WorkDepartment extends Model
{
    use HasFactory;

    protected $table = 'work_department';

    protected $fillable = [
        'name',
    ];
}
