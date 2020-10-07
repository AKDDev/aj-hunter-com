<div id="blog">
    @for($i = 0; $i < 2; $i++)
        <div id="blog{{ $i + 1 }}">
            <h3>{{ $feed[$i]['title'] }}</h3>
        </div>
    @endfor
</div>
