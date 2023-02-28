<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Http\Requests\User\IndexUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexUserRequest $request): View
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
            /** @var LengthAwarePaginator $users */
            $users = Cache::tags('users_collective')->remember($filter_key, 60 * 60, function () use ($validated): LengthAwarePaginator {
                return User::query()
                    ->with([
                        'userRole:id,user_id,role_id' => [
                            'role:id,role_name'
                        ],
                    ])
                    ->select('id', 'name', 'email', 'created_at')
                    ->when($validated['search'], function (Builder $query) use ($validated) {
                        $query->where('name', 'like', "%{$validated['search']}%")
                            ->orWhere('email', 'like', "%{$validated['search']}%");
                    })
                    ->orderByDesc('id')
                    ->paginate(10);
            });

            return view('pages.users.index', compact('users'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        DB::beginTransaction();
        try {
            /** @var User $create */
            $create = User::query()->create($request->validated());

            DB::commit();

            return redirect()->route('users.show', $create->id);
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
            /** @var User $user */
            $user = Cache::tags('users_individual')->remember($id, 60 * 60, function () use ($id): User {
                return User::query()
                    ->with([
                        'userRole:id,user_id,role_id' => [
                            'role:id,role_name'
                        ],
                    ])
                    ->select('id', 'name', 'email', 'created_at')
                    ->find($id);
            });

            return view('pages.users.show', compact('user'));
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
            /** @var User $user */
            $user = Cache::tags('users_individual')->remember($id, 60 * 60, function () use ($id): User {
                return User::query()->select('id', 'name', 'email')->find($id);
            });

            return view('pages.users.edit', compact('user'));
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id): RedirectResponse
    {
        /** @var array<string, string> */
        $validated = $request->validated();

        if ($validated['password']) {
            $validated['password'] = Str::hash($validated['password']);
        } else {
            unset($validated['password']);
        }

        DB::beginTransaction();
        try {
            User::query()->find($id)->update($validated);

            DB::commit();

            return redirect()->route('users.show', $id);
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
            User::destroy($id);

            DB::commit();

            return redirect()->route('users.index');
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
