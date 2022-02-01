@if(count($data) > 0)

    @if($pro == true)
        <div class="form-group">
            <label for="comune" class="col-sm-3 control-label">Comune</label>
            <div class="col-sm-9">
                <select id="comune" name="comune_id" class="form-control" required>
                    @foreach($data as $v)
                        <option value="{{$v->id}}">{{$v->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @else
        <div class="form-group clearfix m-b-10">
            <label class="col-md-2 control-label" for="seller-area">Comune <span class="text-danger">*</span></label>
            <div class="col-md-10">
                <select id="comune" name="comune_id" class="form-control" required>
                    @foreach($data as $v)
                        <option value="{{$v->id}}">{{$v->title}}</option>
                    @endforeach
                </select>
            </div>
        </div>
    @endif
@endif


