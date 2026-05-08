<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-lg bg-surface-container-low p-md rounded-lg text-primary text-body-md" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-lg">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-bold text-label-caps text-on-surface mb-xs">EMAIL ADDRESS</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline">mail</span>
                <input id="email" class="block w-full pl-12 pr-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md text-on-surface transition-colors" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@company.com" />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-sm text-error text-xs" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block font-bold text-label-caps text-on-surface mb-xs">PASSWORD</label>
            <div class="relative">
                <span class="material-symbols-outlined absolute left-md top-1/2 -translate-y-1/2 text-outline">lock</span>
                <input id="password" class="block w-full pl-12 pr-md py-sm bg-surface-container-low border border-outline-variant focus:border-primary focus:ring-1 focus:ring-primary rounded-lg text-body-md text-on-surface transition-colors"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-sm text-error text-xs" />
        </div>

        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-outline-variant text-primary shadow-sm focus:ring-primary bg-surface-container-low cursor-pointer" name="remember">
                <span class="ms-sm text-body-md text-on-surface-variant group-hover:text-on-surface transition-colors">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-body-md text-primary hover:text-on-primary-container font-semibold transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif
        </div>

        <div>
            <button type="submit" class="w-full flex justify-center py-md px-lg bg-primary text-on-primary font-bold rounded-lg hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2">
                {{ __('Secure Log In') }}
            </button>
        </div>
    </form>
</x-guest-layout>
