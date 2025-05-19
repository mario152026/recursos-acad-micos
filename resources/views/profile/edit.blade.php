{{-- resources/views/profile/edit.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mi Perfil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            {{-- ▷ Datos estáticos del usuario ▷ --}}
            <div class="p-6 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">
                    Datos de Usuario
                </h3>
                <p class="mb-2"><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                <p class="mb-2"><strong>Email:</strong> {{ Auth::user()->email }}</p>
                <p class="mb-0">
                    <strong>Usuario desde:</strong>
                    {{ Auth::user()->created_at->format('d/m/Y') }}
                </p>
            </div>

            {{-- ▷ Formulario para actualizar información básica (Jetstream) ▷ --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- ▷ Formulario para cambiar contraseña (Jetstream) ▷ --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- ▷ Formulario para eliminar cuenta (Jetstream) ▷ --}}
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
