<ul class="list-unstyled" style='padding-top:50px;'>
    <li style='margin:15px 0;'>
        <a href="{{route('post.index')}}" class="btn d-block btn-outline-primary  mx-2 @if (Request::is('frontpanel')) active btn-outline-warning @endif" >FrontPanel</a>
    </li>
    @hasanyrole(['Admin', 'Super_admin'])
        <li style='margin:15px 0;'>
            <a href="{{route('role.index')}}" class="btn d-block btn-outline-primary  mx-2 @if (Request::is('backpanel/role/*') || Request::is('backpanel/role')) active btn-outline-warning @endif" >Roles</a>
        </li>
        <li style='margin:15px 0;'>
            <a href="{{route('permission.index')}}" class="btn d-block btn-outline-primary @if (Request::is('backpanel/permission/*') || Request::is('backpanel/permission')) active btn-outline-warning  @endif mx-2" >Permissions</a>
        </li>
        <li style='margin:15px 0;'>
            <a href="{{route('user.index')}}" class="btn d-block btn-outline-primary  mx-2 @if (Request::is('user/*') || Request::is('user')) active btn-outline-warning  @endif" >Users</a>
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
</ul>