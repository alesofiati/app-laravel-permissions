<?php

namespace App\Repository;

use Spatie\Permission\Models\Role;

class RoleRepository extends AbstractRepository
{

    protected $model = Role::class;

    public function getAllPluck()
    {
        return $this->model->pluck('name','name')->all();
    }

    public function whereNotInRoles(array $notIn)
    {
        return $this->model->whereNotIn('id', $notIn)->pluck('name','name')->all();
    }

}
