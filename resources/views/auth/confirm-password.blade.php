<x-guest-layout>
    {{-- Mensagem Informativa --}}
    <div class="mb-3 text-secondary small">
        {{ __('Essa é uma área segura da aplicação. Por favor, confirme sua senha para prosseguir.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        {{-- Campo de Senha --}}
        <div class="mb-3">
            <label for="password" class="form-label">{{ __('Senha') }}</label>
            <input id="password" 
                   type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   name="password" 
                   required 
                   autocomplete="senha atual" 
                   autofocus>
            @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Botão de Confirmação --}}
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
</x-guest-layout>

{{-- 
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex justify-end mt-4">
            <x-primary-button>
                {{ __('Confirm') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
 --}}