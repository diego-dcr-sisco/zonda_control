<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


/**
 * @property int $id
 * @property int|null $tenant_id
 * @property int $user_id
 * @property int|null $filename_id
 * @property string|null $file_name
 * @property string|null $path
 * @property string|null $expirated_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Filenames|null $filename
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereExpiratedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereFileName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereFilenameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserFile whereUserId($value)
 * @mixin \Eloquent
 */
class UserFile extends Model
{
    use HasFactory;

    protected $table = 'user_file';

    protected $fillable = [
        'user_id',
        'filename_id',
        'file_name',
        'path',
        'expirated_at',
    ];

    public function filename()
    {
        return $this->belongsTo(Filenames::class, 'filename_id');
    }

    public function verifyPath()
    {
        if(!empty($this->path)) {
            if (Storage::disk('public')->exists($this->path)) {
                return true;
            }
        }
        return false;
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
