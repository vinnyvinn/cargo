<aside class="left-sidebar">
    <div class="scroll-sidebar">
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li> <a class="has-arrow waves-effect waves-dark" href="{{ url('/') }}" aria-expanded="false">
                        <i class="mdi mdi-gauge"></i><span class="hide-menu">Dashboard</span></a>
                </li>
                @can('manage-customers')
                    <li> <a class="has-arrow waves-effect waves-dark" href="{{ url('/customers')  }}" aria-expanded="false">
                            <i class="mdi mdi-account-multiple"></i><span class="hide-menu">All Customers</span></a>
                    </li>
                    @endcan
                @can('manage-dsr')
                    <li> <a class="has-arrow waves-effect waves-dark" href="{{ url('/dsr')  }}" aria-expanded="false">
                            <i class="mdi mdi-account-multiple"></i><span class="hide-menu">Jobs</span></a>
                    </li>
                    @endcan
                {{--<li> <a class="has-arrow waves-effect waves-dark" href="{{ url('/leads') }}" aria-expanded="false">--}}
                        {{--<i class="mdi mdi-account-multiple"></i><span class="hide-menu">Customers</span></a>--}}
                    {{--<ul aria-expanded="false" class="collapse">--}}
                        {{--<li><a href="{{ url('/leads/create') }}">New Lead</a></li>--}}
                        {{--<li><a href="{{ url('/leads') }}">Leads</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                        <i class="mdi mdi-account"></i><span class="hide-menu">Quotations</span></a>
                    <ul aria-expanded="false" class="collapse">
                        @can('view-quotation')
                            <li><a href="{{ url('/quotations')}}">All Quotations</a></li>
                            @endcan
                        @can('generate-quotation')
                                <li><a href="{{ url('/user-quotations')}}">My Quotations</a></li>
                            @endcan
                    </ul>
                </li>
                @can('manager')
                    <li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false">
                            <i class="mdi mdi-account"></i><span class="hide-menu">Transport Manager</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ url('/transport') }}">Transport</a></li>
                        </ul>
                    </li>
                    @endcan
            </ul>
        </nav>
    </div>
</aside>