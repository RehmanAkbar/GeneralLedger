<?php

namespace Softpyramid\GeneralLedger\Models\Traits;

use Softpyramid\GeneralLedger\Models\Permission;
use Softpyramid\GeneralLedger\Models\Role;

trait HasRoles
{
    /**
     * Assign the given role to the user.
     *
     * @param  string $role
     * @return mixed
     */
    public function assignRole($role)
    {
        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }
    
    /**
     * Determine if the user has the given role.
     *
     * @param  mixed $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if (is_string($role)) {

            return $this->roles->contains('name', $role);
        }


        return !! $this->roles->pluck('name')->intersect($role->pluck('name'))->count();
    }
    
    /**
     * Determine if the user may perform the given permission.
     *
     * @param  Permission $permission
     * @return boolean
     */
    public function hasPermission(Permission $permission)
    {

        return $this->hasRole($permission->roles);
    }


}