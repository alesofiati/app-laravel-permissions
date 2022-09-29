<?php

namespace App\Services;
use App\Repository\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;

class UserService
{

    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
    }

    /**
     * Can user access the ability
     * @param string $permission
     * @return bool
     */
    public static function can(string $permission):bool
    {
        return auth()->user()->can($permission);
    }

    /**
     * @return array
     */
    public static function userPermissions(): array
    {
        //dd(self::hasRole('Adm'),auth()->user()->userPermissions());
        if(auth()->check()) {
            return self::hasRole('Adm')
                ? Permission::select('name')->get()->pluck('name')->toArray()
                : auth()->user()->userPermissions();
        }
        return [];
    }

    /**
     * @param string $role
     * @return bool
     */
    public static function hasRole(string $role):bool
    {
        return auth()->user()->hasRole($role);
    }

    /**
     * @param Request $request
     * @return bool
     */
    public function create(Request $request): bool
    {
        $user = $this->userRepository->create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => bcrypt($request->password)
        ]);

        if($user){
            $user->assignRole($request->role);
            return true;
        }
        return false;
    }

    /**
     * @param int $userId
     * @param Request $request
     * @return bool
     */
    public function update(int $userId, Request $request): bool
    {
        DB::beginTransaction();
        try{
            $user = $this->userRepository->update($userId, [
                "name" => $request->name,
                "email" => $request->email,
                "password" => bcrypt($request->password)
            ]);
            DB::table("model_has_roles")->where("model_id", $userId)->delete();
            $user->assignRole($request->role);
            DB::commit();
            return true;
        }catch (\Exception $exception){
            DB::rollBack();
            return false;
        }
    }

}
