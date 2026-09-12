<x-guest-layout>
    {{-- Mensagem Informativa --}}
    <div class="mb-3 text-secondary small">
        {{ __('Esqueceu sua senha? Sem problemas. Informe seu email para que possamos enviar um link que te permita escolher uma nova senha.') }}
    </div>

    {{-- Status da Sessão (Ex: Link de redefinição enviado com sucesso) --}}
    @if (session('status'))
        <div class="alert alert-success mb-3 small" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        {{-- Endereço de E-mail --}}
        <div class="mb-3">
            <label for="email" class="form-label">{{ __('Email') }}</label>
            <input id="email" 
                   type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   name="email" 
                   value="{{ old('email') }}" 
                   required 
                   autofocus 
                   autocomplete="email">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        {{-- Botão de Submissão --}}
        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary">
                {{ __('Enviar link para nova senha') }}
            </button>
        </div>
    </form>
</x-guest-layout>

{{-- 
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Email Password Reset Link') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
--}}