<div id="graph">
    @for($i = 0; $i < $start; $i++)
        <div class="empty"></div>
    @endfor
    @for($i = 1; $i <= $end; $i++)
        <div class="box {{ $background[$i] }}"></div>
    @endfor
</div>

