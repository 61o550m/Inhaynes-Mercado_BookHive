<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Once your account is deleted, all resources and data will be permanently removed.') }}
        </p>
    </header>

    <!-- Open modal -->
    <x-danger-button x-on:click="open = true">
        {{ __('Delete Account') }}
    </x-danger-button>

    <!-- Alpine Modal -->
    <div
        x-data="{ open: false }"
        x-show="open"
        x-cloak
        class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50"
    >
        <div class="bg-white p-6 rounded-lg shadow-lg w-full max-w-lg">
            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Please enter your password to confirm.') }}
            </p>

            <form method="POST" action="{{ route('profile.destroy') }}" class="mt-6">
                @csrf
                @method('delete')

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />

                <div class="mt-6 flex justify-end">
                    <x-secondary-button x-on:click="open = false" type="button">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="ms-3">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </div>
    </div>
</section>
