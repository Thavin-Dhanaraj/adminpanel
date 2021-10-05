@inject('lang', 'App\Lang')
@inject('util', 'App\Util')

<div id="element_{{$id}}" class="col-md-12 " style="margin-bottom: 10px">
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
                    @if ($noitem == "true")
                        <option value="0" style="font-size: 16px  !important;">{{$lang->get(114)}}</option>  {{--No--}}
                    @endif
                    @foreach($util->getFoods() as $key => $data)
                        <option value="{{$data->id}}" style="font-size: 16px  !important;" data-content="<span class=''><img src='images/{{$data->filename}}' width='40px' style='margin-right: 20px;'> {{$data->name}}</span>"">
                                </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>
</div>


