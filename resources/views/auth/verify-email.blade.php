<x-guest-layout>
    {{-- Mensagem Informativa --}}
    <div class="mb-3 text-secondary small">
        {{ __('Obrigado por registrar-se! Antes de começar, por favor, verifique seu endereço de email clicando no link que te enviamos. Caso não tenha recebido, enviaremos novamente sem problemas.') }}
    </div>

    {{-- Status do Reenvio (Alerta de Sucesso) --}}
    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success mb-3 small" role="alert">
            {{ __('Um novo link de verificação foi enviado para o email informado no seu cadastro.') }}
        </div>
    @endif

    {{-- Ações (Reenviar E-mail de Verificação + Log Out) --}}
    <div class="d-flex align-items-center justify-content-between mt-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary">
                {{ __('Reenviar email de verificação') }}
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-link text-decoration-none text-secondary p-0 small">
                {{ __('Desconectar') }}
            </button>
        </form>
    </div>
</x-guest-layout>

{{-- 
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                    {{ __('Resend Verification Email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>
</x-guest-layout>
 --}}
