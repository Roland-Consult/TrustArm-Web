<div class="row">
    <div class="col">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.escrow.list') ? 'active' : '' }}"
                    href="{{route('admin.escrow.list')}}">@lang('All')</a>
            </li>


            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.escrow.accepted') ? 'active' : '' }}"
                    href="{{route('admin.escrow.accepted')}}">@lang('Accepted')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.escrow.not_accepted') ? 'active' : '' }}"
                    href="{{route('admin.escrow.not_accepted')}}">@lang('Not Accepted')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.escrow.disputed') ? 'active' : '' }}"
                    href="{{route('admin.escrow.disputed')}}">@lang('Disputed')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.escrow.dispatched') ? 'active' : '' }}"
                    href="{{route('admin.escrow.dispatched')}}">@lang('Dispatched')</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::routeIs('admin.escrow.cancelled') ? 'active' : '' }}"
                    href="{{route('admin.escrow.cancelled')}}">@lang('Cancelled')</a>
            </li>

        </ul>
    </div>
</div>