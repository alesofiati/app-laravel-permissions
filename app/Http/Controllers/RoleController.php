<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Services\PermissionService;
use App\Services\RoleService;
use Spatie\Permission\Models\Role;


class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:role-index', ["only" => ["index"]]);
        $this->middleware('permission:role-create', ["only" => ["create","store"]]);
        $this->middleware('permission:role-edit', ["only" => ["edit","update"]]);
        $this->middleware('permission:role-delete', ["only" => ["destroy"]]);
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("Roles/Index", [
            "roles" => Role::paginate(5)
        ]);
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(PermissionService $permissionService): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('Roles/CreateOrUpdate',[
            "permissions" => $permissionService->getPermissions()
        ]);
    }

    /**
     * @param RoleRequest $request
     * @param RoleService $roleService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request, RoleService $roleService): \Illuminate\Http\RedirectResponse
    {
        return redirect()->route("role.index")->with("status",
            $roleService->create($request) ? "Perfil criado com sucesso" : "Não foi possivel criar o perfil"
        );
    }

    public function show($id)
    {
        abort(404);
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse|\Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(int $id, PermissionService $permissionService, RoleService $roleService): \Inertia\Response|\Inertia\ResponseFactory|\Illuminate\Http\RedirectResponse
    {

        if($roleService->isAdm($id)){
            return redirect()->route('role.index')->with('error', "Não é possivel edital o perfil Adm. Pois e já o administrador do sistema.");
        }

        $role = $roleService->find($id);
        return inertia('Roles/CreateOrUpdate',[
            "role" => $role,
            "permissions" => $permissionService->getPermissions($id)
        ]);
    }

    /**
     * @param RoleRequest $request
     * @param $roleId
     * @param RoleService $roleService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RoleRequest $request, $roleId, RoleService $roleService): \Illuminate\Http\RedirectResponse
    {
        if($roleService->isAdm($roleId)){
            return redirect()->route('role.index')->with('error', "Não é possivel edital o perfil Adm. Pois e já o administrador do sistema.");
        }
        $result = $roleService->update($roleId, $request);
        return redirect()->route("role.index")->with($result ? "success" : "error",
            $result ? "Perfil alterado com sucesso" : "Não foi possivel alterar o perfil"
        );
    }

    /**
     * @param $id
     * @param RoleService $roleService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id, RoleService $roleService): \Illuminate\Http\RedirectResponse
    {
        if($roleService->isAdm($id)){
            return redirect()->route('role.index')->with('error', "Não é possivel remover o perfil Adm. Pois é o administrador do sistema.");
        }
        $result = $roleService->delete($id);
        return redirect()->route("role.index")->with($result ? "success" : "error",
            $result ? "Perfil removido com sucesso" : "Não foi possivel remover o perfil"
        );
    }
}
