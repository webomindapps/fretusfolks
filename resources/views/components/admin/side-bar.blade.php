@foreach ($menus as $key => $menu)
    {{-- {{dd($menu['roles'])}} --}}
    @if (isset($menu['roles']) && array_intersect($menu['roles'], auth()->user()->getRoleNames()->toArray()))
        <li class="dropdown nav-item {{ str_contains(url()->current(), $menu['name']) ? 'active' : '' }}">
            <a class="nav-link"
                @if (!$menu['isSubMenu']) href="{{ route($menu['route'], $menu['params'] ?? []) }}" @endif>
                <span class="shape1"></span>
                <span class="shape2"></span>
                <i class="{{ $menu['icon'] }}"></i>
                <span class="link_names">{{ $menu['title'] }}</span>
                @if ($menu['isSubMenu'])
                    <span class="right-arr">
                        <i class='bx bx-chevron-down'></i>
                    </span>
                @endif
            </a>

            @if ($menu['isSubMenu'])
                <ul class="dropdown_menu">
                    @foreach ($menu['subMenus'] as $subMenu)
                        @if (isset($subMenu['roles']) && array_intersect($subMenu['roles'], auth()->user()->getRoleNames()->toArray()))
                            <li>
                                <a href="{{ route($subMenu['route'], $subMenu['params'] ?? []) }}">
                                    <i class='bx bx-chevron-right'></i>
                                    {{ $subMenu['title'] }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            @endif
        </li>
    @endif
    {{-- @role('Admin')
        @if (str_starts_with(strtolower($menu['name']), 'f'))
        @elseif(auth()->user()->username == 'Superadm')
            <li class="dropdown nav-item {{ str_contains(url()->current(), $menu['name']) ? 'active' : '' }}">
                <a class="nav-link"
                    @if (!$menu['isSubMenu']) href="{{ route($menu['route'], $menu['params'] ?? []) }}" @endif>
                    <span class="shape1"></span>
                    <span class="shape2"></span>
                    <i class="{{ $menu['icon'] }}"></i>
                    <span class="link_names">{{ $menu['title'] }}</span>
                    @if ($menu['isSubMenu'])
                        <span class="right-arr">
                            <i class='bx bx-chevron-down'></i>
                        </span>
                    @endif
                </a>

                @if ($menu['isSubMenu'])
                    <ul class="dropdown_menu">
                        @foreach ($menu['subMenus'] as $subMenu)
                            <li>
                                <a href="{{ route($subMenu['route'], $subMenu['params'] ?? []) }}">
                                    <i class='bx bx-chevron-right'></i>
                                    {{ $subMenu['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endif
    @endrole --}}
@endforeach
