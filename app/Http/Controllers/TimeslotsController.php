<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\ImageUpload;
use Auth;
use App\Settings;
use App\Logging;
use App\Util;
use App\Lang;
use SebastianBergmann\Environment\Console;

class TimeslotsController extends Controller
{
    public function load(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        Logging::log(Lang::get(506));  // Timeslots Screen

        return view('timeslots', []);
    }

    public function add(Request $request)
    {
        if (!Auth::check())
            return \Redirect::route('/');

        $id = $request->input('id', "0"); // for edit

        $name = $request->input('name');
        Logging::log2("Timeslots->Add", "Name: " . $name);

        $values = array(
            'name' => $name,
            'from' => $request->input('from'),
            'to' => $request->input('to'),
            'visible' => $request->input('visible'),
            'updated_at' => new \DateTime());

        if ($id != "0"){
            DB::table('timeslots')->where('id', $id)->update($values);
            Logging::log2("Timeslots->Update", "Name: " . $name);
        }else{
            $values['created_at'] = new \DateTime();
            DB::table('timeslots')->insert($values);
            $id = DB::getPdo()->lastInsertId();
            Logging::log2("Timeslots->Add", "Name: " . $name);
        }

        return TimeslotsController::getOne($id);
    }

    public function GetInfo(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error' => "1"]);

        $id = $request->input('id', "0");
        if ($id == "0")
            return response()->json(['error' => "4"]);

        return TimeslotsController::getOne($id);
    }

    public function getOne($id){
        $banner = DB::table('timeslots')->where("id", $id)->get()->first();

        $banner->timeago = Util::timeago($banner->updated_at);
        return response()->json(['error'=>"0", 'data' => $banner]);
    }

    public function delete(Request $request){

        if (!Auth::check())
            return \Redirect::route('/');

        $id = $request->input('id');
        $name = DB::table('timeslots')->where('id',$id)->get()->first()->name;

        if (Settings::isDemoMode()){
            Logging::log3("Timeslots->Delete", "Name: " . $name, Lang::get(487)); // "Abort! This is demo mode"
            return response()->json(['ret'=>false, 'text' => Lang::get(489)]); // This is demo app. You can't change this section
        }

        Logging::log2("Timeslots->Delete", "Name: " . $name);

        DB::table('timeslots')
            ->where('id',$id)
            ->delete();

        return response()->json(['ret'=>true]);
    }

    public function GoPage(Request $request)
    {
        if (!Auth::check())
            return response()->json(['error'=>"1"]);

        $search = $request->input('search') ? : "";
        $page = $request->input('page') ? : 1;
        $count = $request->input('count', 10);
        $sortBy = $request->input('sortBy') ? : "id";
        $sortAscDesc = $request->input('sortAscDesc') ? : "asc";
        $sortPublished = $request->input('sortPublished', "1");
        $sortUnPublished = $request->input('sortUnPublished', "1");

        $user_id = $request->input('user_id') ?: "";
        $petani = DB::table('image_uploads')->get();

        Logging::log("Banners->Go Page " . $page . " search: " . $search);

        $offset = ($page - 1) * $count;

        $searchVisible = "";
        if ($sortPublished != '1' || $sortUnPublished != '1') {
            if ($sortPublished == '1')
                $searchVisible = "visible = '1' AND ";
            if ($sortUnPublished == '1')
                $searchVisible = "visible = '0' AND ";
        }
        if ($sortPublished == '0' && $sortUnPublished == '0')
            $searchVisible = "visible='3' AND ";


        $datas = DB::select("SELECT * FROM timeslots WHERE " . $searchVisible .  " name LIKE '%" . $search . "%' ORDER BY " . $sortBy . " " . $sortAscDesc . " LIMIT " . $count . " OFFSET " . $offset);
        // $datas = DB::select("SELECT * FROM timeslots ");
        $total = count(DB::select("SELECT * FROM timeslots WHERE " . $searchVisible .  " name LIKE '%" . $search . "%'" ));

        foreach ($datas as &$data) {
            $data->timeago = Util::timeago($data->updated_at);
        }

        $t = $total/$count;
        if ($total%$count > 0)
            $t++;

        return response()->json(['error'=>"0", 'idata' => $datas, 'page' => $page, 'pages' => $t, 'total' => $total]);
    }
}
