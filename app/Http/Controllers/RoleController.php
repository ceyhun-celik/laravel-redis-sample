<?php

namespace App\Http\Controllers;

use App\Http\Requests\Role\IndexRoleRequest;
use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRoleRequest $request): View
    {
        /** @var array<string, string> $validated */
        $validated = $request->validated();

        $validated['search'] ??= null;

        /** @var string $filter_key */
        $filter_key = collect($validated)
            ->filter()
            ->map(fn (string $item, string $key): string => "{$key}#{$item}")
            ->implode(':');

        try {
            /** @var Cache|LengthAwarePaginator $roles */
            $roles = Cache::tags('roles_collective')->remember($filter_key, 60 * 60, function () use ($validated): LengthAwarePaginator {
                return Role::query()
                    ->select('id', 'role_name', 'created_at')
                    ->when($validated['search'], function (Builder $query) use ($validated) {
                        $query->where('role_name', 'like', "%{$validated['search']}%");
                    })
                    ->paginate(10);
            });

            return view('pages.roles.index', compact('roles'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRoleRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            /** @var Role $create */
            $create = Role::query()->create($request->validated());

            DB::commit();

            return redirect()->route('roles.show', $create->id);
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        try {
            /** @var Role|Cache $role */
            $role = Cache::tags('roles_individual')->remember($id, 60 * 60, function () use ($id) {
                return Role::query()->select('id', 'role_name', 'created_at')->find($id);
            });

            return view('pages.roles.show', compact('role'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        try {
            /** @var Role|Cache $role */
            $role = Cache::tags('roles_individual')->remember($id, 60 * 60, function ($id) {
                return Role::query()->select('id', 'role_name', 'created_at')->find($id);
            });

            return view('pages.roles.edit', compact('role'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRoleRequest $request, string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            Role::query()->find($id)->update($request->validated());

            DB::commit();

            return redirect()->route('roles.show', $id);
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        DB::beginTransaction();
        try {
            Role::destroy($id);

            DB::commit();

            return redirect()->route('roles.index');
        } catch (\Throwable $th) {
            DB::rollBack();

            dd($th->getMessage());
        }
    }
}
