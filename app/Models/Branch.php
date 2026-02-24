<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int|null $tenant_id
 * @property int $status_id
 * @property string $name
 * @property string|null $code
 * @property string|null $fiscal_name
 * @property string|null $email
 * @property string|null $alt_email
 * @property string|null $phone
 * @property string|null $alt_phone
 * @property string $address
 * @property string $colony
 * @property int $zip_code
 * @property string $city
 * @property string $state
 * @property string $country
 * @property string|null $license_number
 * @property string|null $rfc
 * @property string|null $fiscal_regime
 * @property string|null $url
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereAltEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereAltPhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereColony($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereFiscalName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereFiscalRegime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereLicenseNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereRfc($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Branch whereZipCode($value)
 * @mixin \Eloquent
 */
class Branch extends Model
{
    use HasFactory;
    protected $table = 'branch';
   
    protected $fillable = [
        'id',
        'tenant_id',
        'status_id',
        'name',
        'code',
        'fiscal_name',
        'email',
        'alt_email',
        'phone',
        'alt_phone',
        'address',
        'colony',
        'zip_code', 
        'city',
        'state',
        'country',
        'license_number', 
        'rfc', 
        'fiscal_regime', 
        'url',
        'description',
    ];

}
