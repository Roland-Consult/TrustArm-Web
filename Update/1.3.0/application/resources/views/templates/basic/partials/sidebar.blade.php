
@auth

<div class="sidebar-menu">
    <span class="sidebar-menu__close"><i class="las la-times"></i></span>
    <ul class="sidebar-menu-list">
        <li class="sidebar-menu-list__item has-dropdown active">
            <a href="{{route('user.home')}}" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa fa-tachometer-alt"></i></span>
            @lang('Dashboard')</span>
            </a>
        </li>

        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-droplet"></i></span>
            <span class="text">@lang('Escrow')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.escrow.new')}}" class="sidebar-submenu-list__link">@lang('Create Escrow ')</a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.escrow.list')}}" class="sidebar-submenu-list__link">@lang('Escrow List') </a>
                    </li>
                </ul>
            </div>
        </li>

        
        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-file-invoice-dollar"></i></span>
            <span class="text">@lang('Deposit')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.deposit')}}" class="sidebar-submenu-list__link">@lang('Deposit Right Away') </a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.deposit.history')}}" class="sidebar-submenu-list__link">@lang('Deposit Log') </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-gear"></i></span>
            <span class="text">@lang('Withdraw')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.withdraw')}}" class="sidebar-submenu-list__link">@lang('Withdraw Balance') </a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.withdraw.history')}}" class="sidebar-submenu-list__link">@lang('Log Withdrawal ')</a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="sidebar-menu-list__item has-dropdown">
            <a href="{{route('user.transactions')}}" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-book-atlas"></i></span>
            @lang('Transactions')</span>
            </a>
        </li>
        <li class="sidebar-menu-list__item has-dropdown">
            <a href="javascript:void(0)" class="sidebar-menu-list__link">
            <span class="icon"><i class="fa-solid fa-user"></i></span>
            <span class="text">@lang('Profile')</span>
            </a>
            <div class="sidebar-submenu">
                <ul class="sidebar-submenu-list">
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('ticket')}}" class="sidebar-submenu-list__link">@lang('Support Tickets') </a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('ticket.open')}}" class="sidebar-submenu-list__link">@lang('New Ticket') </a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.change.password')}}" class="sidebar-submenu-list__link">@lang('Change Password') </a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.profile.setting')}}" class="sidebar-submenu-list__link">@lang('Profile Setting')</a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.twofactor')}}" class="sidebar-submenu-list__link">@lang('2Fa Security') </a>
                    </li>
                    <li class="sidebar-submenu-list__item">
                        <a href="{{route('user.logout')}}" class="sidebar-submenu-list__link">@lang('Log Out') </a>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>

@endauth
