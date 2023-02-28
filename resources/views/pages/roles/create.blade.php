<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles') }}
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
                                {{ __('Create Role') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __("Please fill the blanks for create new role.") }}
                            </p>
                        </header>

                        <form method="post" action="{{ route('roles.store') }}" class="mt-6 space-y-6"> @csrf
                            <div>
                                <x-input-label for="role_name" :value="__('Role Name')" />
                                <x-text-input id="role_name" name="role_name" type="text" class="mt-1 block w-full"
                                    :value="old('role_name')" required autofocus autocomplete="role_name" />
                                <x-input-error class="mt-2" :messages="$errors->get('role_name')" />
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
