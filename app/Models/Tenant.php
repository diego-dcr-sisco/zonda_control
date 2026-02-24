<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

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
 * @mixin \Eloquent
 */
class Tenant extends Model
{
    use HasFactory, SoftDeletes, HasRoles;
    protected $table = 'tenant';
    protected $fillable = [
        'company_name',
        'slug',
        'is_active',
        'plan_id',
        'subscription_start',
        'subscription_end',
        'path',
    ];

    protected $guard_name = 'web'; 

    protected $casts = [
        'is_active' => 'boolean',
        'subscription_start' => 'date',
        'subscription_end' => 'date',
        'deleted_at' => 'datetime'
    ];

   
    public function plan()
    {
        return $this->belongsTo(Plan::class)->withDefault([
            'name' => 'Plan Eliminado',
            'limit_users' => 0
        ]);
    }

    public function users()
    {
        return $this->hasMany(User::class, 'tenant_id');
    }

    public function permissionControls()
    {
        return $this->hasMany(TenantPermissionControl::class);
    }

    /**
     * Sincroniza los permisos del tenant basándose en su plan
     * 
     * @return void
     */
    public function syncPermissionsFromPlan(): void
    {
        if (!$this->plan_id) {
            return;
        }

        $plan = $this->plan;
        $planPermissions = $plan->permissions;

        // Eliminar todos los controles de permisos actuales
        TenantPermissionControl::where('tenant_id', $this->id)->delete();

        // Crear nuevos controles de permisos basados en el plan
        $insertData = [];
        foreach ($planPermissions as $permission) {
            $insertData[] = [
                'tenant_id' => $this->id,
                'permission_id' => $permission->id,
                'is_allowed' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        if (!empty($insertData)) {
            TenantPermissionControl::insert($insertData);
        }
    }

    /**
     * Obtiene los permisos permitidos para este tenant
     * 
     * @return \Illuminate\Support\Collection
     */
    public function getAllowedPermissions()
    {
        return $this->permissionControls()
            ->where('is_allowed', true)
            ->with('permission')
            ->get()
            ->pluck('permission');
    }

    /**
     * Verifica si el tenant tiene un permiso específico
     * 
     * @param string $permissionName
     * @return bool
     */
    public function hasPermission(string $permissionName): bool
    {
        return $this->permissionControls()
            ->whereHas('permission', function ($query) use ($permissionName) {
                $query->where('name', $permissionName);
            })
            ->where('is_allowed', true)
            ->exists();
    }
}
