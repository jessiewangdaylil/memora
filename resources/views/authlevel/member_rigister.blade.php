{{--path:view\vender\components\... --}}
<x-guest-layout>

    <x-jet-authentication-card>

        <x-slot name="logo">
             <img src="{{ asset('img/login-logo.png') }}" alt="Logo" />
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

@livewire('authlevel.member-rigister',
['locale'=>config('app.locale')])
    </x-jet-authentication-card>
</x-guest-layout>
