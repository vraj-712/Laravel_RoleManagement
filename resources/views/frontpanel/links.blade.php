<ul class="list-unstyled" style='padding-top:50px;'>
    @hasanyrole(['Editor', 'Admin', 'Super_admin'])
    <li style='margin:15px 0;'>
        <a href="{{route('user.index')}}" class="btn d-block btn-outline-primary  mx-2 @if (Request::is('backpanel/*') || Request::is('backpanel')) active btn-outline-warning  @endif" >BackPanel</a>
    </li>
    @endhasanyrole
    @hasanyrole(['Editor', 'User', 'Admin', 'Super_admin'])
        <li style='margin:15px 0;'>
            <a href="{{route('post.index')}}" class="btn d-block btn-outline-primary  mx-2 @if (Request::is('post/*') || Request::is('post')) active btn-outline-warning  @endif" >Posts</a>
        </li>
        <li style='margin:15px 0;'>
            <a href="{{route('comment.index')}}" class="btn d-block btn-outline-primary  mx-2 @if (Request::is('comment/*') || Request::is('comment')) active btn-outline-warning  @endif" >Comments</a>
        </li>
    @endhasanyrole
    @auth
        
        <li style='margin:15px 0;'>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }} </a>
                </form>
    
    @endauth
</ul>