<div class="col-md-4 col-sm-4 col-xs-4 ">
    <?php $is_parent=false;  ?>
@foreach($direct_childs as $item)
    @if(\App\Category::where('parent_id', $item->id)->value('id'))
        <a href="javascript:;" onclick="loadChildCategories(this)" data-id="{{$item->id}}" data-type="child">
            <li>{{ ucfirst($item->name) }} >></li>
        </a>
    @else
        <a href="javascript:;" onclick='insertCat({{$item->id}}, "{{ $item->name }}")' data-id="{{$item->id}}" data-type="child">
            <li>{{ ucfirst($item->name) }} {{ $is_parent? '>>' : '' }}</li>
        </a>
    @endif
@endforeach
</div>