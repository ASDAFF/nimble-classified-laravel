
<div class="col-md-2" id="parent" data-parent="2">
@if(count($categories) > 0)
    @foreach($categories as $v)
        <li><a href="javascript:void (0)" title="{{ $v['name'] }}" data-parent="2" data-id="{{ $v['id'] }}" onclick="load_category(this)"> <i class="{{ $v['icon'] }}"></i>  {{ ucfirst( $v['name'] ) }} » </a></li>
    @endforeach
@endif
</div>

