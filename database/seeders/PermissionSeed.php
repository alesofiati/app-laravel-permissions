<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                "name" => "user-index",
                "description" => "Lista de usúarios"
            ],
            [
                "name" => "user-create",
                "description" => "Criar usúario"
            ],
            [
                "name" => "user-edit",
                "description" => "Editar usúario"
            ],
            [
                "name" => "role-index",
                "description" => "Lista de perfils"
            ],
            [
                "name" => "role-create",
                "description" => "Criar perfil"
            ],
            [
                "name" => "role-edit",
                "description" => "Editar Perfil"
            ],
            [
                "name" => "role-delete",
                "description" => "Remover Perfil"
            ],
        ];

        foreach ($permissions as $permission)
        {
            if(Permission::where(['name' => $permission['name']])->count()){
                Permission::where(['name' => $permission['name']])->update($permission);
            }else{
                Permission::create($permission);
            }
        }
    }
}
