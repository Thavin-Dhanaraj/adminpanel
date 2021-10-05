@inject('lang', 'App\Lang')

<div class="col-md-12 " style="margin-bottom: 10px">
    <div class="col-md-4 form-control-label" style="margin-bottom: 0px">
        <label for="name"><h4>{{$label}}
                @if ($request == "true")
                    <span class="col-red">*</span>
                @endif
            </h4></label>
    </div>
    <div class="col-md-8" style="margin-bottom: 0px">
        <div class="form-group form-group-lg" style="margin-bottom: 0px">
            <div class="form-line" >
                <select name="{{$id}}" id="{{$id}}" class="form-control show-tick" onchange="{{$onchange}};" >
                    <option value="1" style="font-size: 16px  !important;" selected>{{$lang->get(509)}}</option>  {{--Banner 1--}}
                    <option value="2" style="font-size: 16px  !important;">{{$lang->get(510)}}</option>  {{--Banner 2--}}
                </select>
            </div>
        </div>
    </div>
</div>
