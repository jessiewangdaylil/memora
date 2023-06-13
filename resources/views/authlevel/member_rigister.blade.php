{{--path:view\vender\components\... --}}
<x-guest-layout>

    <x-jet-authentication-card>

        <x-slot name="logo">
          <a href="{{url('/')}}">
             <img src="{{ asset('img/login-logo.png') }}" alt="Logo" />
          </a>
        </x-slot>

        <x-jet-validation-errors class="mb-4" />

@livewire('authlevel.member-rigister',
['locale'=>config('app.locale')])
    </x-jet-authentication-card>
</x-guest-layout>
