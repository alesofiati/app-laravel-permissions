<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class PermissionRepository extends AbstractRepository
{
    protected $model = Permission::class;

    /**
     * get role permissions
     * @param int $role_id
     * @return array
     */
    public function getPermissionsFromRole(int $role_id): array
    {
        return DB::table("role_has_permissions")->where("role_has_permissions.role_id", $role_id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
    }

    public function getPermissions()
    {
        return $this->model->select("id", "description", "name")->get()->toArray();
    }

}
