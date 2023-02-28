<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRole\CreateUserRoleRequest;
use App\Http\Requests\UserRole\StoreUserRoleRequest;
use App\Http\Requests\UserRole\UpdateUserRoleRequest;
use App\Models\UserRole;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserRoleController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create(CreateUserRoleRequest $request): View
    {
        /** @var array<string, int> $validated */
        $validated = $request->validated();

        try {
            /** @var User $user */
            $user = User::query()->select('id', 'name', 'email')->find($validated['user_id']);

            /** @var Roles $roles */
            $roles = Role::query()->select('id', 'role_name')->get();

            return view('pages.userRoles.create', compact('user', 'roles'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRoleRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            $create = UserRole::query()->create($request->validated());

            DB::commit();

            return redirect()->route('user-roles.edit', $create->id);
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        try {
            $user_role = UserRole::query()
                ->with('user:id,name')
                ->select('id', 'user_id', 'role_id')
                ->find($id);

            $roles = Role::query()->select('id', 'role_name')->get();

            return view('pages.userRoles.edit', compact('user_role', 'roles'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRoleRequest $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            UserRole::query()->find($id)->update($request->validated());

            DB::commit();

            return redirect()->route('user-roles.edit', $id);
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
        }
    }
}
