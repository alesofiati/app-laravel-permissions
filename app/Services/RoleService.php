<?php

namespace App\Services;

use App\Repository\RoleRepository;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class RoleService
{

    const Adm = 1;

    public function __construct()
    {
        $this->roleRepository = new RoleRepository;
    }

    /**
     * create a new role and assing your permissions
     * @param Request $request
     * @return bool
     */
    public function create(Request $request): bool
    {
        try {
            $role = $this->roleRepository->create(['name' => $request->role]);
            $role->syncPermissions(array_filter($request->permissions));
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    public function update(int $roleId, Request $request):bool
    {
        try{
            $role = $this->roleRepository->update($roleId, ['name' => $request->role]);
            $role->syncPermissions(array_filter($request->permissions));
            return true;
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * Find a role by your id
     * @param int $roleId
     * @return Model
     */
    public function find(int $roleId): Model
    {
        return $this->roleRepository->find($roleId);
    }

    /**
     * Verifica se o perfil é administrador do sistema
     * @param int $roleId
     * @return bool
     */
    public function isAdm(int $roleId): bool
    {
        $role = $this->find($roleId);
        return $role->name == "Adm";
    }

    public function delete(int $roleId):bool
    {
        return $this->roleRepository->delete($roleId);
    }

    public function getRoles()
    {
        if(UserService::hasRole("Adm")){
            return $this->roleRepository->getAllPluck();
        }

        return $this->roleRepository->whereNotInRoles([self::Adm]);
    }



}
