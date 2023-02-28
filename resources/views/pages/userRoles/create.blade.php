<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Content Starts Here -->
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Create User Role') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Please fill the blanks for create new user role.') }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('user-roles.store') }}" class="mt-6 space-y-6"> @csrf
                            <div>
                                <x-input-label for="user_id" :value="__('User')" />

                                <x-select name="user_id" id="user_id" class="w-64">
                                    <option value="{{ $user->id }}">{{ "{$user->name} - {$user->email}" }}</option>
                                </x-select>
                            </div>

                            <div>
                                <x-input-label for="role_id" :value="__('Role')" />

                                <x-select name="role_id" id="role_id" class="w-64">
                                    @forelse ($roles as $role)
                                        @if ($loop->first)
                                            <option value="">{{ __('-- Select --') }}</option>
                                        @endif

                                        <option value="{{ $role->id }}">{{ $role->role_name }}</option>
                                    @empty
                                        
                                    @endforelse
                                </x-select>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Create') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                    <!-- Content Ends Here -->
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
