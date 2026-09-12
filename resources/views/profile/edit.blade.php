<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 fw-semibold">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-8">

            {{-- Informações do Perfil --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-md-5">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Atualização de Senha --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-md-5">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Exclusão de Conta --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-4 p-md-5">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

{{--  
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
--}}