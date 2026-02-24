<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $tenant_id
 * @property int $user_id
 * @property int $contract_type_id
 * @property int $branch_id
 * @property int $company_id
 * @property string|null $curp
 * @property string|null $rfc
 * @property string|null $nss
 * @property string|null $phone
 * @property string|null $company_phone
 * @property string|null $address
 * @property string|null $colony
 * @property string|null $city
 * @property string|null $state
 * @property string|null $country
 * @property string|null $zip_code
 * @property string|null $birthdate
 * @property string|null $hiredate
 * @property float|null $salary
 * @property string|null $clabe
 * @property string|null $signature
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch $branch
 * @property-read \App\Models\Company $company
 * @property-read \App\Models\ContractType $contractType
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereClabe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereColony($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereCompanyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereContractTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereHiredate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereNss($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereRfc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Technician whereZipCode($value)
 * @mixin \Eloquent
 */
class Technician extends Model
{
    use HasFactory;
    protected $table = 'technician';

    protected $fillable = [
        "id",
        "user_id",
        "contract_type_id",
        "branch_id",
        "company_id",
        "curp",
        "rfc",
        "nss",
        "phone",
        "company_phone",
        "address",
        "colony",
        "city",
        "state",
        "country",
        "zip_code",
        "birthdate",
        "hiredate",
        "salary",
        "clabe",
        "signature",
        "created_at",
        "updated_at"
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function company() {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function contractType() {
        return $this->belongsTo(ContractType::class, 'contract_type_id');
    }
}
