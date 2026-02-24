<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
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
 */
	class Administrative extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $primary_color
 * @property string $secondary_color
 * @property string $logo_path
 * @property string $watermark_path
 * @property float $watermark_opacity
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting wherePrimaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereSecondaryColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereWatermarkOpacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|AppearanceSetting whereWatermarkPath($value)
 */
	class AppearanceSetting extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Company whereUpdatedAt($value)
 */
	class Company extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ContractType whereUpdatedAt($value)
 */
	class ContractType extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Filenames extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property numeric $price
 * @property int $limit_users
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tenant> $tenants
 * @property-read int|null $tenants_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereLimitUsers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Plan whereUpdatedAt($value)
 */
	class Plan extends \Eloquent {}
}

namespace App\Models{
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
 */
	class SimpleRole extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int|null $tenant_id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Status whereUpdatedAt($value)
 */
	class Status extends \Eloquent {}
}

namespace App\Models{
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
 */
	class Technician extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property string $company_name
 * @property string $slug
 * @property bool $is_active
 * @property int|null $plan_id
 * @property \Illuminate\Support\Carbon|null $subscription_start
 * @property \Illuminate\Support\Carbon|null $subscription_end
 * @property string $path
 * @property int $users_amount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TenantPermissionControl> $permissionControls
 * @property-read int|null $permission_controls_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \App\Models\Plan|null $plan
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant wherePlanId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSubscriptionEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereSubscriptionStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant whereUsersAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant withoutRole($roles, $guard = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Tenant withoutTrashed()
 */
	class Tenant extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $tenant_id
 * @property int $permission_id
 * @property bool $is_allowed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Spatie\Permission\Models\Permission $permission
 * @property-read \App\Models\Tenant $tenant
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl allowed()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl denied()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl forPermission($permissionName)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl forTenant($tenantId)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl whereIsAllowed($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl wherePermissionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TenantPermissionControl whereUpdatedAt($value)
 */
	class TenantPermissionControl extends \Eloquent {}
}

namespace App\Models{
/**
 * @property int $id
 * @property int $is_superAdmin
 * @property int|null $tenant_id
 * @property int|null $work_department_id
 * @property int|null $status_id
 * @property int|null $role_id
 * @property int $type_id
 * @property string $name
 * @property string $nickname
 * @property string|null $username
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property string|null $session_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\UserContract> $contracts
 * @property-read int|null $contracts_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Spatie\Permission\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\SimpleRole|null $simpleRole
 * @property-read \App\Models\Status|null $status
 * @property-read \App\Models\WorkDepartment|null $workDepartment
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User permission($permissions, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User role($roles, $guard = null, $without = false)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereIsSuperAdmin($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereNickname($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereRoleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereSessionToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereStatusId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTenantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereTypeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereUsername($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereWorkDepartmentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutPermission($permissions)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User withoutRole($roles, $guard = null)
 */
	class User extends \Eloquent {}
}

namespace App\Models{
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
 */
	class UserContract extends \Eloquent {}
}

namespace App\Models{
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
 */
	class UserFile extends \Eloquent {}
}

namespace App\Models{
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
 */
	class WorkDepartment extends \Eloquent {}
}

