<ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                {{$selectedLang->literal}} <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-user">
                @foreach ($langs as $lang)
                <li>
                    <a href="/{{$lang->code}}">{{$lang->literal}}</a>
                </li>
                @endforeach
            </ul>
        </li>
</ul>
