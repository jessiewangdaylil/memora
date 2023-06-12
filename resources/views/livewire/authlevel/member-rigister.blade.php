        <form method="POST" action="{{ url('/update_profile') }}">
            @csrf
{{$locale}}
            <div class="flex mt-4">
                <div class="w-1/2 mr-3">
                  <x-jet-label for="identify" value="{{ __('identify') }}" />
                  <x-jet-input id="identify" class="block mt-1 w-full" type="password" name="identify" :value="old('identify')" required autofocus />
               </div>
              <div class="w-1/2">
                <x-jet-label for="username" value="{{ __('username') }}" />
                <x-jet-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required  autocomplete="username" />
               </div>
            </div>

            <div class="flex mt-4">
              <div class="w-1/2 mr-3">
                <x-jet-label for="first_name" value="{{ __('first_name') }}" />
                <x-jet-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required  autocomplete="first_name" />
              </div>
              <div class="w-1/2 ">
                <x-jet-label for="last_name" value="{{ __('last_name') }}" />
                <x-jet-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required  autocomplete="last_name" />
              </div>
            </div>
            <div class="mt-4 flex">
              <div class="w-1/2  mr-3">
                <x-jet-label for="birthday" value="{{ __('birthday') }}" />
                <x-jet-input id="birthday" class="block mt-1 w-full" type="date" name="birthday" required  />
              </div>
              <div class="w-1/2">
                <x-jet-label for="gender" value="{{ __('body_gender') }}"
                class="mb-4" />
                <x-jet-input id="gender" class="w-1/4" type="radio" name="gender" checkd="checked" value="old({{__('men')}})" />{{__('men')}}
                <x-jet-input id="gender" class="w-1/4" type="radio" name="gender"  value="old({{__('female')}})" />{{__('female')}}
              </div>
            </div>
          <div class="mt-4 flex">
            <div>
              <x-jet-label for="tel" value="{{__('tel')}}" />
              <x-select id="pZone" name="pZone" :options="$pZone" class="w-1/6 mr-2" />
              <x-jet-input id="tel" class="mt-1   " type="text" name="tel" :value="old('tel')" required  autocomplete="tel" />
              </div>
           </div>
          <div class="mt-4 flex">
            <div>
              <x-jet-label for="mobile" value="{{__('moblie')}}" />
             <x-select id="mobile" name="mobile" :options="$pCountry" class="w-1/6 mr-2" />
              <x-jet-input id="mobile" class="mt-1   " type="text" name="mobile" :value="old('mobile')" required  autocomplete="mobile" />
              </div>
           </div>
          <div class="mt-4 flex">
            <div>

              <x-jet-label for="address" value="{{__('address')}}" />
              {{--  --}}
             <x-select id="city" name="city"  :options="$city" class="w-1/6 mr-2" wire:change="cityChangetown" wire:model="userCity" />
             {{--  --}}
             <x-select id="town" name="town"  :options="$town" class="w-1/6 mr-2" wire:change="townChangeRoad" wire:model="userTown" />
             {{--  --}}
              <x-select id="zone" name="zone" :options="$road" class="w-1/6 mr-1" />
              <x-jet-input id="address" class="mt-1 w-full  " type="text" name="address" :value="old('address')" required  autocomplete="address" />
              </div>
           </div>
            <div class="mt-4">
                <x-jet-label for="password" value="{{ __('PasswordAuthen') }}" />
                <x-jet-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('back page') }}
                </a>

                <x-jet-button class="ml-4">
                    {{ __('Enable Function Application') }}
                </x-jet-button>
            </div>
        </form>
