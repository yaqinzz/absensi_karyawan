<header class="sticky top-0 z-40 flex justify-between items-center h-16 px-lg bg-surface border-b border-outline-variant">
    <div class="flex items-center gap-lg">
        <button @click="mobileNavOpen = true" class="lg:hidden p-2 text-on-surface-variant hover:bg-surface-container-low rounded-full transition-all">
            <span class="material-symbols-outlined">menu</span>
        </button>
    </div>
    

        <div class="ml-md flex items-center gap-sm">
            <div class="text-right hidden sm:block">
                <p class="font-semibold text-body-md leading-none">{{ Auth::user()->name }}</p>
                <p class="text-xs text-on-surface-variant">
                    @if(Auth::user()->roles->count() > 0)
                        {{ ucfirst(Auth::user()->roles->first()->name) }}
                    @else
                        Karyawan
                    @endif
                </p>
            </div>
            
            <x-dropdown align="right" width="48">
                <x-slot name="trigger">
                    <button class="flex items-center justify-center w-10 h-10 rounded-full border border-outline-variant bg-primary-container text-on-primary-container font-bold text-sm hover:opacity-90 transition-opacity">
                        {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                    </button>
                </x-slot>

                <x-slot name="content">
                    <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">person</span>
                        {{ __('Profile') }}
                    </x-dropdown-link>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-dropdown-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();" class="flex items-center gap-2 text-error hover:bg-error-container">
                            <span class="material-symbols-outlined text-sm">logout</span>
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </x-slot>
            </x-dropdown>
        </div>
    </div>
</header>
