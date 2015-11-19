<div class="side-menu">
    
    <nav class="navbar navbar-default" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <div class="brand-wrapper">
                <!-- Hamburger -->
                <button type="button" class="navbar-toggle">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <!-- Brand -->
                <div class="brand-name-wrapper">
                    <a class="navbar-brand" href="{{ route('admin') }}">
                        {{ config('appkit.app_name') }}
                    </a>
                </div>
            </div>
        </div>
        <!-- Main Menu -->
        <div class="side-menu-container">
            <ul class="nav navbar-nav">
                <li class="widget">
                    <img class="avatar img-circle" src="{{ asset($user_image) }}" />
                    <h4 class="text-center">{{ $user_name }}</h4>
                    <h5 class="text-center" style="opacity:0.8;">{{ $user_email }}</h5>
                    <div class="button-bar">
                        <a href="auth/logout" class="btn btn-default" >
                            <i class="fa fa-sign-out"></i> Sign Out
                        </a>
                        <a href="{{ route('users.edit', $user_id) }}" class="btn btn-default" >
                            <i class="fa fa-user"></i> Profile
                        </a>
                    </div>
                </li>
            @foreach ($menu_admin_left->roots() as $item)

                @if ($item->requiresAccess)

                    @if (user_is($item->access) || user_can($item->access))

                        @include('shell::components.navigation.item', ['item' => $item])

                    @endif

                @else

                    @include('shell::components.navigation.item', ['item' => $item])

                @endif
            @endforeach
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
    
</div>