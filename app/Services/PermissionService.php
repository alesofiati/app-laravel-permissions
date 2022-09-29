<?php

namespace App\Services;

use App\Repository\PermissionRepository;

class PermissionService
{

    private $permissionRepository;

    public function __construct()
    {
        $this->permissionRepository = new PermissionRepository;
    }

    public function getPermissions(int $role_id = 0): array
    {
        $permissionsFromRole = $this->permissionRepository->getPermissionsFromRole($role_id);
        $permissions = $this->permissionRepository->getPermissions();

        $permissionsGroup = [];

        foreach ($permissions as $key => $permisison)
        {
            $permissions[$key]["checked"] = in_array($permisison['id'], $permissionsFromRole);
            $group = explode("-", $permisison["name"])[0];

            unset($permissions[$key]['name']);
            if(isset($permissionsGroup[$group])){
                $permissionsGroup[$group][] = $permissions[$key];
            }else{
                $permissionsGroup[$group] = [0 => $permissions[$key]];
            }

        }

        return $permissionsGroup;

    }

}
