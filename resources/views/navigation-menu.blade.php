<nav x-data="{ open: false }" class="navbar bg-base-100">
    <!-- Primary Navigation Menu -->
    <div class="navbar-start">
        <div class="dropdown">
            <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /></svg>
            </div>
            <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
                @foreach ($modules as $module)
                    @php
                        $moduleRoute = $module->route;
                        $modulePermission = $permissions->firstWhere('module', $moduleRoute);
                        $subModules = $modules->whereIn('relation', $moduleRoute)->values();
                        $activeSubRoute = $subModules
                            ->map(function ($module) {
                                return $module->route;
                            })
                            ->contains(request()->route()->getName());
                        $isActive = $activeSubRoute || $moduleRoute === request()->route()->getName();
                        $classes = $isActive ? 'btn-active' : '';
                    @endphp
                    @if ($module->status === 1 && $module->relation == '0' && $modulePermission && auth()->user()->hasPermission($modulePermission->name))
                        <li class="{{ $classes }}">
                            <details>
                                <summary>
                                    {!! $purifier->purify($modulePermission->icon) !!}
                                    {{ __($module->name) }}
                                </summary>
                                <ul class="p-2">
                                    @foreach ($subModules as $subModule)
                                        @php
                                            $subModuleRoute = $subModule->route;
                                            $subModulePermission = $permissions->firstWhere('module', $subModuleRoute);
                                        @endphp
                                        @if ($subModule->status === 1 && $subModulePermission && auth()->user()->hasPermission($subModulePermission->name))
                                            <li>
                                                <a href="{{ route($subModuleRoute) }}">
                                                    {!! $purifier->purify($subModulePermission->icon) !!}
                                                    {{ __($subModule->name) }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </details>
                        </li>
                    @elseif ($module->status === 1 && $module->relation == 'NULL' && $modulePermission && auth()->user()->hasPermission($modulePermission->name))
                        <li class="{{ $classes }}">
                            <a href="{{ route($moduleRoute) }}">
                                {!! $purifier->purify($modulePermission->icon) !!}
                                {{ __($module->name) }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </div>
    </div>

    <div class="navbar-center hidden lg:flex">
        <ul class="menu menu-horizontal px-1">
            @foreach ($modules as $module)
                @php
                    $moduleRoute = $module->route;
                    $modulePermission = $permissions->firstWhere('module', $moduleRoute);
                    $subModules = $modules->whereIn('relation', $moduleRoute)->values();
                    $activeSubRoute = $subModules
                        ->map(function ($module) {
                            return $module->route;
                        })
                        ->contains(request()->route()->getName());
                    $isActive = $activeSubRoute || $moduleRoute === request()->route()->getName();
                    $classes = $isActive ? 'btn-active' : '';
                @endphp
                @if ($module->status === 1 && $module->relation == '0' && $modulePermission && auth()->user()->hasPermission($modulePermission->name))
                    <li class="{{ $classes }}">
                        <details>
                            <summary>
                                {!! $purifier->purify($modulePermission->icon) !!}
                                {{ __($module->name) }}
                            </summary>
                            <ul class="p-2">
                                @foreach ($subModules as $subModule)
                                    @php
                                        $subModuleRoute = $subModule->route;
                                        $subModulePermission = $permissions->firstWhere('module', $subModuleRoute);
                                    @endphp
                                    @if ($subModule->status === 1 && $subModulePermission && auth()->user()->hasPermission($subModulePermission->name))
                                        <li>
                                            <a href="{{ route($subModuleRoute) }}">
                                                {!! $purifier->purify($subModulePermission->icon) !!}
                                                {{ __($subModule->name) }}
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </details>
                    </li>
                @elseif ($module->status === 1 && $module->relation == 'NULL' && $modulePermission && auth()->user()->hasPermission($modulePermission->name))
                    <li class="{{ $classes }}">
                        <a href="{{ route($moduleRoute) }}">
                            {!! $purifier->purify($modulePermission->icon) !!}
                            {{ __($module->name) }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>

    <div class="navbar-end">
        @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
            <div class="dropdown">
                <button tabindex="0" class="btn">
                    {{ Auth::user()->currentTeam->name }}
                </button>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">{{ __('Team Settings') }}</a></li>
                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <li><a href="{{ route('teams.create') }}">{{ __('Create New Team') }}</a></li>
                    @endcan
                    @if (Auth::user()->allTeams()->count() > 1)
                        <li class="border-t border-gray-200 dark:border-gray-600"></li>
                        @foreach (Auth::user()->allTeams() as $team)
                            <li><x-switchable-team :team="$team" /></li>
                        @endforeach
                    @endif
                </ul>
            </div>
        @endif

        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div class="dropdown">
                <button tabindex="0" class="btn btn-ghost btn-circle avatar">
                    <div class="w-10 rounded-full">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                </button>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <li><a href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a></li>
                    @endif
                    <li class="border-t border-gray-200 dark:border-gray-600"></li>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <li><a href="{{ route('logout') }}" @click.prevent="$root.submit();">{{ __('Log Out') }}</a></li>
                    </form>
                </ul>
            </div>
        @else
            <div class="dropdown">
                <button tabindex="0" class="btn btn-ghost">
                    {{ Auth::user()->name }}
                    <svg class="ml-2 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                    </svg>
                </button>
                <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52">
                    <li><a href="{{ route('profile.show') }}">{{ __('Profile') }}</a></li>
                    @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                        <li><a href="{{ route('api-tokens.index') }}">{{ __('API Tokens') }}</a></li>
                    @endif
                    <li class="border-t border-gray-200 dark:border-gray-600"></li>
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf
                        <li><a href="{{ route('logout') }}" @click.prevent="$root.submit();">{{ __('Log Out') }}</a></li>
                    </form>
                </ul>
            </div>
        @endif
    </div>
</nav>
