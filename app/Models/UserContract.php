<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $tenant_id
 * @property int $user_id
 * @property int $contract_type_id
 * @property string|null $contract_startdate
 * @property string|null $contract_enddate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ContractType $type
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereContractEnddate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereContractStartdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereContractTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|UserContract whereUserId($value)
 * @mixin \Eloquent
 */
class UserContract extends Model
{
    use HasFactory;

    protected $table = 'user_contract';

    protected $fillable = [
        'user_id',
        'contract_type_id',
        'contract_startdate',
        'contract_enddate',
    ];

    public function type() {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }
}
