<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Repository\UserRepository;
use App\Services\RoleService;
use App\Services\UserService;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:user-index', ["only" => ["index"]]);
        $this->middleware('permission:user-create', ["only" => ["create","store"]]);
        $this->middleware('permission:user-edit', ["only" => ["edit","update"]]);
    }

    /**
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index(UserRepository $userRepository): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia("User/Index", [
            "users" => $userRepository->paginate(10)
        ]);
    }

    /**
     * @param RoleService $roleService
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function create(RoleService $roleService): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('User/CreateOrUpdate',[
            "roles" => $roleService->getRoles()
        ]);
    }

    /**
     * @param UserRequest $request
     * @param UserService $userService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(UserRequest $request, UserService $userService): \Illuminate\Http\RedirectResponse
    {
        $result = $userService->create($request);

        return redirect()->route('user.index')
        ->with(
            $result ? "success" : "error",
            $result ? "Usúario criado com sucesso" : "Não foi possivel criar o usúario"
        );
    }

    public function show(int $id){}

    /**
     * @param int $id
     * @param RoleService $roleService
     * @param UserRepository $userRepository
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function edit(int $id, RoleService $roleService, UserRepository $userRepository): \Inertia\Response|\Inertia\ResponseFactory
    {
        return inertia('User/CreateOrUpdate',[
            "roles" => $roleService->getRoles(),
            "user" => $userRepository->find($id)
        ]);
    }

    /**
     * @param UserRequest $request
     * @param int $id
     * @param UserService $userService
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserRequest $request, int $id, UserService $userService): \Illuminate\Http\RedirectResponse
    {
        $result = $userService->update($id, $request);

        return redirect()->route('user.index')
            ->with(
                $result ? "success" : "error",
                $result ? "Usúario alterado com sucesso" : "Não foi possivel alterar o usúario"
            );
    }

    public function destroy(int $id)
    {
        abort(404);
    }
}
