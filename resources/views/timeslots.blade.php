@inject('userinfo', 'App\UserInfo')
@extends('bsb.app')
@inject('lang', 'App\Lang')
@inject('util', 'App\Util')

@section('content')

    <div class="header">
        <div class="row clearfix">
            <div class="col-md-12">
                <h3 class="">{{$lang->get(638)}}</h3> {{--Timeslots - Timeslots Management--}}
            </div>
        </div>
    </div>

    <div class="body">

    <!-- Tabs -->

        <ul class="nav nav-tabs tab-nav-right" role="tablist">
            <li role="presentation" class="active"><a href="#home" data-toggle="tab"><h4>{{$lang->get(64)}}</h4></a></li>   {{--LIST--}}
            @if ($userinfo->getUserPermission("Food::Categories::Create"))
            <li role="presentation"><a href="#create" data-toggle="tab" ><h4>{{$lang->get(65)}}</h4></a></li> {{--CREATE--}}
            @endif
            <li id="tabEdit" style='display:none;' role="presentation"><a href="#edit" data-toggle="tab"><h4>{{$lang->get(66)}}</h4></a></li> {{--EDIT--}}
        </ul>

        <!-- Tab List -->
        <div class="tab-content">

            <div role="tabpanel" class="tab-pane fade in active" id="home">
                <div class="row clearfix js-sweetalert">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="card">
                            <div class="header">
                                <h3>
                                    {{$lang->get(641)}} {{--BANNERS LIST--}}
                                </h3>
                            </div>
                            <div class="body">
                                @include('elements.timeslotsTable', array())
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tab Create -->

                <div role="tabpanel" class="tab-pane fade" id="create">

                    <div id="form">
                        <div class="row clearfix">
                            <div class="col-md-6 ">
                                @include('elements.form.text', array('label' => $lang->get(69), 'text' => $lang->get(91), 'id' => "name", 'request' => "true", 'maxlength' => "40"))  {{-- Name - Insert Name --}}
                                @include('elements.form.text', array('label' => $lang->get(639), 'text' => $lang->get(91), 'onchange' => "", 'id' => "from", 'request' => "true", 'maxlength' => "40"))   {{--Is in --}}
                                @include('elements.form.text', array('label' => $lang->get(640), 'text' => $lang->get(91), 'onchange' => "", 'id' => "to", 'request' => "true", 'maxlength' => "40"))   {{--Is in --}}
                                <div class="col-md-4 " >
                                </div>
                                <div class="col-md-8 " style="margin-top: 20px">
                                    @include('elements.form.check', array('id' => "visible", 'text' => $lang->get(75), 'initvalue' => "true"))  {{--Published item--}}
                                </div>
                            </div>
                        </div>
                        @include('elements.form.button', array('label' => $lang->get(142), 'onclick' => "onSave();"))  {{-- Save --}}
                    </div>

                </div>

                <!-- Tab Edit -->

                <div role="tabpanel" class="tab-pane fade" id="edit">
                </div>

            </div>
        </div>
    </div>

    @include('elements.imageselect', array())

    <script type="text/javascript">

        $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).attr("href")
            if (target != "#edit")
                document.getElementById("tabEdit").style.display = "none";
            if (target == "#create") {
                clearForm();
                document.getElementById('create').appendChild(document.getElementById("form"));
            }
            if (target == "#home")
                clearForm();
        });

        function editItem(id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("timeslotsGetInfo") }}',
                data: {
                    id: id,
                },
                success: function (data){
                    console.log(data);
                    if (data.error != "0" || data.data == null)
                        return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    document.getElementById("tabEdit").style.display = "block";
                    $('.nav-tabs a[href="#edit"]').tab('show');
                    //
                    var target = document.getElementById("form");
                    document.getElementById('edit').appendChild(target);
                    //
                    document.getElementById("name").value = data.data.name;
                    editId = data.data.id;
                    onSetCheck_visible(data.data.visible);
                    //
                    $('#from').val(data.data.from).change();
                    $('#to').val(data.data.to).change();
                    $('.show-tick').selectpicker('refresh');
                },
                error: function(e) {
                    showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    console.log(e);
                }}
            );
        }

        var editId = 0;

        function onSave(){
            if (!document.getElementById("name").value)
                return showNotification("bg-red", "{{$lang->get(85)}}", "bottom", "center", "", "");  // The Name field is required.
            if (imageid == 0)
                return showNotification("bg-red", "{{$lang->get(86)}}", "bottom", "center", "", "");  // The Image field is required.


            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                type: 'POST',
                url: '{{ url("timeslotsAdd") }}',
                data: {
                    id: editId,
                    name: document.getElementById("name").value,
                    from: document.getElementById("from").value,
                    to: document.getElementById("to").value,
                    visible: (visible) ? "1" : "0",
                },
                success: function (data){
                    console.log(data);
                    if (data.error != "0" || data.data == null)
                        return showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    if (editId != 0)
                        paginationGoPage(currentPage);
                    else{
                        var text = buildOneItem(data.data);
                        var text2 = document.getElementById("table_body").innerHTML;
                        document.getElementById("table_body").innerHTML = text+text2;
                    }
                    $('.nav-tabs a[href="#home"]').tab('show');
                    showNotification("bg-teal", "{{$lang->get(485)}}", "bottom", "center", "", ""); // Data saved
                    clearForm();
                },
                error: function(e) {
                    showNotification("bg-red", "{{$lang->get(479)}}", "bottom", "center", "", "");  // Something went wrong
                    console.log(e);
                }}
            );
        }

        function clearForm(){
            onChangeType();
            document.getElementById("name").value = "";
            document.getElementById("url").value = "";
            onSetCheck_visible(true);
            $('#isin').val(1).change();
            $('#banner_type').val(1).change();
            $('#foodForBanner').val(1).change();
            editId = 0;
            clearDropZone();
        }

        function onChangeType(){
            if ($('select[id=banner_type]').val() == 1){ // food
                document.getElementById("element_foodForBanner").hidden = false;
                document.getElementById("element_url").hidden = true;

            }else{   // external link
                document.getElementById("element_foodForBanner").hidden = true;
                document.getElementById("element_url").hidden = false;
            }
        }

    </script>

@endsection
