@inject('userinfo', 'App\UserInfo')
@inject('currency2', 'App\Currency')
@inject('lang', 'App\Lang')
@extends('bsb.app')

@section('content')

    <!-- Input Mask Plugin Js -->
    <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

    <div class="header">
        <div class="row clearfix">
            <div class="col-md-12">
                <h3 class="">{{$lang->get(148)}}</h3>
            </div>
        </div>
    </div>
    <div class="body">

    <!-- Tabs -->

        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>
            <li id="tabEdit" style='display:none;' role="presentation"><a href="#edit" data-toggle="tab"><h4>{{$lang->get(66)}}</h4></a></li>
        </ul>


        <!-- Tab List -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane fade in active" id="home">
                @if ($texton == "green")
                    <div class="alert bg-green" >
                        {{$text}}
                    </div>
                @endif

                <div class="row clearfix js-sweetalert">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h3>
                                    {{$lang->get(149)}}
                                </h3>
                            </div>
                            <div class="body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-striped table-hover dataTable js-exportable">
                                        <thead>
                                        <tr>
                                            <th>{{$lang->get(69)}}</th>
                                            <th>{{$lang->get(70)}}</th>
                                            <th>{{$lang->get(71)}}</th>
                                            <th>{{$lang->get(150)}}</th>
                                            <th>{{$lang->get(151)}}</th>
                                            <th>{{$lang->get(155)}}</th>
                                            <th>{{$lang->get(72)}}</th>
                                            <th>{{$lang->get(74)}}</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th>{{$lang->get(69)}}</th>
                                            <th>{{$lang->get(70)}}</th>
                                            <th>{{$lang->get(71)}}</th>
                                            <th>{{$lang->get(150)}}</th>
                                            <th>{{$lang->get(151)}}</th>
                                            <th>{{$lang->get(155)}}</th>
                                            <th>{{$lang->get(72)}}</th>
                                            <th>{{$lang->get(74)}}</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>


                                        @foreach($restaurants as $key => $data)
                                            <tr id="tr{{$data->id}}">
                                                <td>{{$data->name}}</td>
                                                <td>
                                                    <img src="images/{{$data->filename}}" height="50" style='min-height: 50px; ' alt="">
                                                </td>

                                                <td>{{$data->desc}}</td>

                                                <td>{{$data->address}}</td>

                                                <td>{{$data->phone}}</td>

                                                <td>{{$data->mobilephone}}</td>

                                                <td>{{$data->updated_at}}</td>

                                                <td>
                                                    @if ($userinfo->getUserPermission("Restaurants::Edit"))
                                                    <button type="button" class="btn btn-default waves-effect"
                                                            onclick="editItem('{{$data->id}}','{{$data->name}}', '{{$data->published}}', '{{$data->imageid}}',
                                                                    '{{$data->filename}}', '{{$data->desc}}',
                                                                '{{$data->delivered}}', '{{$data->address}}', '{{$data->phone}}', '{{$data->mobilephone}}',
                                                                '{{$data->lat}}', '{{$data->lng}}', '{{$data->fee}}', '{{$data->percent}}',
                                                                '{{$data->minAmount}}', '{{$data->perkm}}')">
                                                        <img src="img/iconedit.png" width="25px">
                                                    </button>
                                                    @endif
                                                </td>
                                            </tr>

                                        @endforeach

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        <!-- End Tab List -->

    <!-- Tab Edit -->

        <div role="tabpanel" class="tab-pane fade" id="edit">

            <div id="redalertEdit" class="alert bg-red" style='display:none;' >

            </div>

            <form id="formedit" method="post" action="{{url('restaurantsedit')}}"  >
                @csrf

                <input type="hidden" id="imageidEdit" name="image"/>
                <input type="hidden" id="editid" name="id"/>

                <div class="row clearfix">

                    <div class="col-md-6 foodm">

                        <div class="col-md-3 foodm">
                            <label for="name"><h4>{{$lang->get(69)}} <span class="col-red">*</span></h4></label>
                        </div>
                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="text" name="name" id="nameEdit" class="form-control" placeholder="" maxlength="100">
                                </div>
                                <label class="foodm">{{$lang->get(91)}}</label>
                            </div>
                        </div>


                        <div class="col-md-3 foodm">
                            <label for="name"><h4>{{$lang->get(150)}}</h4></label>
                        </div>
                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="text" name="address" id="addressEdit" class="form-control" placeholder="" maxlength="100">
                                </div>
                                <label class="foodm">{{$lang->get(153)}}</label>
                            </div>
                        </div>

                        <div class="col-md-3 foodm">
                            <label><h4>{{$lang->get(152)}}</h4></label>
                        </div>
                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="text" name="phone" id="phoneEdit" class="form-control" placeholder="" maxlength="20">
                                </div>
                                <label class="foodm">{{$lang->get(154)}}</label>
                            </div>
                        </div>

                        <div class="col-md-3 foodm">
                            <label><h4>{{$lang->get(155)}}</h4></label>
                        </div>

                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="text" name="mobilephone" id="mobilephoneEdit" class="form-control" placeholder="" maxlength="20">
                                </div>
                                <label class="foodm">{{$lang->get(156)}}</label>
                            </div>
                        </div>

                        <div class="col-md-3 foodm">
                            <label><h4>{{$lang->get(71)}}</h4></label>
                        </div>
                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="text" name="desc" id="descEdit" class="form-control" placeholder="" maxlength="300">
                                </div>
                                <label class="foodm">{{$lang->get(76)}}</label>
                            </div>
                        </div>

                        <div class="col-md-4 foodm">
                            <label><h4>{{$lang->get(157)}} <span class="col-red">*</span></h4></label>  {{--Delivery fee--}}
                        </div>
                        <div class="col-md-8 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="number" name="fee" id="feeEdit" class="form-control" placeholder="" min="0" step="0.01">
                                </div>
                                <label class="font-12">{{$lang->get(158)}}</label>
                            </div>

                        <div class="col-md-12 foodm">
                            <div class="form-group">
                                <input type="checkbox" id="percentEdit" name="percent" class="filled-in checkmark">
                                <label for="percentEdit" class="form-label"><h5>{{$lang->get(159)}}</h5></label>
                            </div>
                        </div>
                        <div class="col-md-12 foodm">
                            <div class="form-group">
                                <input type="checkbox" id="perkmEdit" name="perkm" class="filled-in checkmark">
                                <label for="perkmEdit" class="form-label"><h5>{{$lang->get(611)}}</h5></label>     {{--per kilometer or mile--}}
                            </div>
                        </div>
                        </div>

                        <div class="col-md-12 info" style="margin-top: 5px; margin-left: 20px;">
                            <h4>{{$lang->get(160)}}</h4>
                            <p>{{$lang->get(161)}}</p>
                            <p id="currentEdit">{{$lang->get(162)}}: {{$currency}}0</p>
                        </div>

                        <div class="col-md-3 foodm">
                            <label><h4>{{$lang->get(163)}}</h4></label>     {{--Delivery Area--}}
                        </div>
                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="number" name="area" id="areaEdit" class="form-control" placeholder="" value="30">
                                    <label class="form-label">{{$lang->get(164)}}</label>
                                </div>
                            </div>
                        </div>

                        @include('elements.form.price', array('label' => $lang->get(550), 'text' => $lang->get(551), 'id' => "minAmount", 'request' => "false"))  {{--Minimum purchase amount - For ex: 100. If 0 - no Minimum purchase amount --}}

                    </div>

                    <div class="col-md-6 foodm">

                        <div class="col-md-3 foodm">
                            <label for="lat"><h4>{{$lang->get(165)}} <span class="col-red">*</span></h4></label>
                        </div>
                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="number" name="lat" id="latEdit" class="form-control" placeholder="" step="0.00000000000000001">
                                </div>
                                <label class="foodm">{{$lang->get(166)}}</label>
                            </div>
                        </div>

                        <div class="col-md-3 foodm">
                            <label for="lng"><h4>{{$lang->get(167)}} <span class="col-red">*</span></h4></label>
                        </div>
                        <div class="col-md-9 foodm">
                            <div class="form-group form-group-lg form-float">
                                <div class="form-line">
                                    <input type="number" name="lng" id="lngEdit" class="form-control" placeholder="" step="0.00000000000000001">
                                </div>
                                <label class="foodm">{{$lang->get(168)}}</label>
                            </div>
                        </div>


                        <div class="row clearfix">
                            <div class="col-md-2 form-control-label">
                                <label><h4>{{$lang->get(70)}}:</h4></label>
                                <br>
                                <div align="center">
                                    <button type="button" onclick="fromLibraryEdit()" class="btn btn-primary m-t-15 waves-effect "><h5>{{$lang->get(77)}}</h5></button>
                                </div>
                            </div>
                            <div class="col-md-10">
                                <div id="dropzoneEdit" class="fallback dropzone">
                                    <div class="dz-message">
                                        <div class="drag-icon-cph">
                                            <i class="material-icons">touch_app</i>
                                        </div>
                                        <h3>{{$lang->get(78)}}</h3>
                                    </div>
                                    <div class="fallback">
                                        <input name="file" type="file" multiple />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 foodm">
                            <label><h4>{{$lang->get(169)}}:</h4></label>
                        </div>
                        <div class="col-md-9 foodm" style="margin-top: 20px;">
                            <table border="0">
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <h5>{{$lang->get(170)}}</h5>
                                    </td>
                                    <td></td>
                                    <td>
                                        <h5>{{$lang->get(171)}}</h5>
                                    </td>

                                </tr>
                                <tr>
                                    <td><h5>{{$lang->get(172)}}:</h5></td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="openTimeMonday" id="openTimeMondayEdit" class="form-control time24" placeholder="Ex: 10:00">
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="closeTimeMonday" id="closeTimeMondayEdit" class="form-control time24" placeholder="Ex: 23:00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h5>{{$lang->get(173)}}:</h5></td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="openTimeTuesday" id="openTimeTuesdayEdit" class="form-control time24" placeholder="Ex: 10:00">
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="closeTimeTuesday" id="closeTimeTuesdayEdit" class="form-control time24" placeholder="Ex: 23:00">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="margin-top: 5px;">
                                    <td><h5>{{$lang->get(174)}}:</h5></td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="openTimeWednesday" id="openTimeWednesdayEdit" class="form-control time24" placeholder="Ex: 10:00">
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="closeTimeWednesday" id="closeTimeWednesdayEdit" class="form-control time24" placeholder="Ex: 23:00">
                                        </div>
                                    </td>
                                </tr>
                                <tr style="margin-top: 5px;">
                                    <td><h5>{{$lang->get(175)}}:</h5></td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="openTimeThursday" id="openTimeThursdayEdit" class="form-control time24" placeholder="Ex: 10:00">
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="closeTimeThursday" id="closeTimeThursdayEdit" class="form-control time24" placeholder="Ex: 23:00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h5>{{$lang->get(176)}}:</h5></td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="openTimeFriday" id="openTimeFridayEdit" class="form-control time24" placeholder="Ex: 10:00">
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg " style="margin-top: 5px;">
                                            <input type="text" name="closeTimeFriday" id="closeTimeFridayEdit" class="form-control time24" placeholder="Ex: 23:00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h5>{{$lang->get(177)}}:</h5></td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="openTimeSaturday" id="openTimeSaturdayEdit" class="form-control time24" placeholder="Ex: 10:00">
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg " style="margin-top: 5px;">
                                            <input type="text" name="closeTimeSaturday" id="closeTimeSaturdayEdit" class="form-control time24" placeholder="Ex: 23:00">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><h5>{{$lang->get(178)}}:</h5></td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg" style="margin-top: 5px;">
                                            <input type="text" name="openTimeSunday" id="openTimeSundayEdit" class="form-control time24" placeholder="Ex: 10:00">
                                        </div>
                                    </td>
                                    <td width="5%"></td>
                                    <td>
                                        <div class="demo-masked-input input-group-lg " style="margin-top: 5px;">
                                            <input type="text" name="closeTimeSunday" id="closeTimeSundayEdit" class="form-control time24" placeholder="Ex: 23:00">
                                        </div>
                                    </td>
                                </tr>

                            </table>

                        </div>


                    </div>

                </div>

                <div class="row clearfix">
                    <div class="col-md-12 form-control-label">
                        <div align="center">
                            <button type="submit"  class="btn btn-primary m-t-15 waves-effect "><h5>{{$lang->get(142)}}</h5></button>
                        </div>
                    </div>
                </div>


            </form>

        </div>

    </div>
    </div>

    <script type="text/javascript">

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href")
            if (target != "#edit")
                document.getElementById("tabEdit").style.display = "none";
            console.log(target);
        });

        async function editItem(id, name, visible, imageid, ifile, desc,
                                delivered, address, phone, mobilephone, lat, lng,
                                fee, percent, minAmount, perkm) {
            document.getElementById("tabEdit").style.display = "block";
            $('.nav-tabs a[href="#edit"]').tab('show');

            document.getElementById("nameEdit").value = name;
            document.getElementById("editid").value = id;
            document.getElementById("addressEdit").value = address;
            document.getElementById("phoneEdit").value = phone;
            document.getElementById("mobilephoneEdit").value = mobilephone;
            document.getElementById("latEdit").value = lat;
            document.getElementById("lngEdit").value = lng;
            document.getElementById("descEdit").value = desc;
            document.getElementById("perkmEdit").checked = perkm === '1';
            console.log("perkm", perkm);
            //
            document.getElementById('feeEdit').value = fee;
            document.getElementById("percentEdit").checked = percent === '1';
            if (percent == '1')
                currentEdit.innerHTML = "Current: "+fee+"%";
            else
                currentEdit.innerHTML = "Current: {{$currency}}"+fee;
            //
            @foreach($restaurants as $key => $data)
            if ({{$data->id}} == id){
                document.getElementById("openTimeMondayEdit").value = '{{$data->openTimeMonday}}';
                document.getElementById("closeTimeMondayEdit").value = '{{$data->closeTimeMonday}}';
                document.getElementById("openTimeTuesdayEdit").value = '{{$data->openTimeTuesday}}';
                document.getElementById("closeTimeTuesdayEdit").value = '{{$data->closeTimeTuesday}}';
                document.getElementById("openTimeWednesdayEdit").value = '{{$data->openTimeWednesday}}';
                document.getElementById("closeTimeWednesdayEdit").value = '{{$data->closeTimeWednesday}}';
                document.getElementById("openTimeThursdayEdit").value = '{{$data->openTimeThursday}}';
                document.getElementById("closeTimeThursdayEdit").value = '{{$data->closeTimeThursday}}';
                document.getElementById("openTimeFridayEdit").value = '{{$data->openTimeFriday}}';
                document.getElementById("closeTimeFridayEdit").value = '{{$data->closeTimeFriday}}';
                document.getElementById("openTimeSaturdayEdit").value = '{{$data->openTimeSaturday}}';
                document.getElementById("closeTimeSaturdayEdit").value = '{{$data->closeTimeSaturday}}';
                document.getElementById("openTimeSundayEdit").value = '{{$data->openTimeSunday}}';
                document.getElementById("closeTimeSundayEdit").value = '{{$data->closeTimeSunday}}';
                //
                var area = '{{$data->area}}';
                if (area == "")
                    area = 30;
                document.getElementById("areaEdit").value = area;
                document.getElementById("minAmount").value = minAmount;
            }
            @endforeach

            addEditImage(imageid, ifile);
        }

        var form = document.getElementById("formedit");
        form.addEventListener("submit", checkFormEdit, true);

        function checkFormEdit(event) {
            var alertText = "";
            if (!document.getElementById("nameEdit").value) {
                alertText = "<h4>{{$lang->get(85)}}</h4>";
            }
            if (!document.getElementById("latEdit").value) {
                alertText = alertText+"<h4>{{$lang->get(179)}}</h4>";
            }
            if (!document.getElementById("lngEdit").value) {
                alertText = alertText+"<h4>{{$lang->get(180)}}</h4>";
            }
            if (alertText != "") {
                var div = document.getElementById("redalertEdit");
                div.innerHTML = '';
                div.style.display = "block";
                var div2 = document.createElement("div");
                div2.innerHTML = alertText;
                div.appendChild(div2);
                window.scrollTo(0, 0);
                event.preventDefault();
                return false;
            }
        }

        //
        // edit
        //
        percentEdit = document.getElementById('percentEdit');
        currentEdit = document.getElementById('currentEdit');
        feeEdit = document.getElementById('feeEdit');
        percentEdit.addEventListener('change', (event) => {
            var vl = feeEdit.value;
            if (vl == null) vl = 0;
            if (event.target.checked) {
                if (feeEdit.value > 100){
                    vl = 100;
                    feeEdit.value = 100;
                }
                currentEdit.innerHTML = "Current: "+vl+"%";
            } else {
                currentEdit.innerHTML = "Current: {{$currency}}"+vl;
            }
        })
        feeEdit.addEventListener('input', (event) => {
            var vl = feeEdit.value;
            if (vl == null) vl = 0;
            if (percentEdit.checked) {
                if (feeEdit.value > 100){
                    vl = 100;
                    feeEdit.value = 100;
                }
                currentEdit.innerHTML = "Current: "+vl+"%";
            } else {
                currentEdit.innerHTML = "Current: {{$currency}}"+vl;
            }
        })

    //Time
    var $demoMaskedInput = $('.demo-masked-input');

    $demoMaskedInput.find('.time12').inputmask('hh:mm t', { placeholder: '__:__ _m', alias: 'time12', hourFormat: '12' });
    $demoMaskedInput.find('.time24').inputmask('hh:mm', { placeholder: '__:__ _m', alias: 'time24', hourFormat: '24' });

    // per km
    var percentEdit = document.getElementById('percentEdit');
    var currentEdit = document.getElementById('currentEdit');
    var feeEdit = document.getElementById('feeEdit');
    var perkmEdit = document.getElementById('perkmEdit');
    percentEdit.addEventListener('change', (event) => {
        var vl = feeEdit.value;
        if (vl == null) vl = 0;
        if (event.target.checked) {
            if (feeEdit.value > 100){
                vl = 100;
                feeEdit.value = 100;
            }
            currentEdit.innerHTML = "Current: "+vl+"%";
            perkmEdit.checked = false;
        } else {
            if (perkmEdit.checked)
                currentEdit.innerHTML = "Current: {{$currency2->currency()}}" + vl + " per km or ml"
            else
                currentEdit.innerHTML = "Current: {{$currency2->currency()}}"+vl;
        }
    });
    perkmEdit.addEventListener('change', (event) => {
        if (perkmEdit.checked) {
            let vl = feeEdit.value;
            percentEdit.checked = false;
            currentEdit.innerHTML = "Current: {{$currency2->currency()}}" + vl + " per km or ml"
        }
    });


    </script>

    @include('bsb.image', array('petani' => $petani))

@endsection
