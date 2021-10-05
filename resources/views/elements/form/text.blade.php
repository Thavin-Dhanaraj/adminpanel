
<div id="element_{{$id}}">
    <div class="col-md-12 " style="margin-bottom: 0px">
        <div class="col-md-4 form-control-label" style="margin-bottom: 0px">
            <label for="{{$id}}"><h4>{{$label}}
                @if ($request == "true")
                    <span class="col-red">*</span>
                @endif
            </h4></label>
        </div>
        <div class="col-md-8" style="margin-bottom: 0px">
            <div class="form-group form-group-lg form-float " style="margin-bottom: 0px">
                <div class="form-line">
                    <input type="text" name="{{$id}}" id="{{$id}}" class="form-control" placeholder="" maxlength="{{$maxlength}}">
                </div>
                <p class="font-12 mdl-color-text--indigo-A700">{{$text}}</p>
            </div>
        </div>
    </div>
</div>
