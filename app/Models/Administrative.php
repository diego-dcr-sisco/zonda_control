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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereBirthdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereBranchId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereClabe($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereColony($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereCompanyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereCompanyPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereContractTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereCurp($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereHiredate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereNss($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereRfc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereSalary($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Administrative whereZipCode($value)
 * @mixin \Eloquent
 */
class Administrative extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'administrative';
    protected $fillable = [
        "id",
        "user_id",
        "contract_type_id",
        "branch_id",
        "company_id",
        "birthdate",
        "phone",
        "company_phone",
        "address",
        "colony",
        "curp",
        "rfc",
        "nss",
        "city",
        "state",
        "country",
        "zip_code",
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
