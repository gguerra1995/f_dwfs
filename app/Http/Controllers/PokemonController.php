<?php

namespace App\Http\Controllers;

use App\Models\Pokemon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PokemonController extends Controller
{
    public function index()
    {
        $pokemon = Pokemon::all();
        return response()->json(compact("pokemon"));
    }

    public function get($id)
    {
        $pokemon = Pokemon::where("id", $id)->first();
        return response()->json($pokemon);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|string",
            "ps" => "required",
            "atq" => "required",
            "df" => "required",
            "atq_spl" => "required",
            "df_spl" => "required",
            "spl" => "required",
            "vel" => "required",
            "acc" => "required",
            "evs" => "required",
            'photo' => 'required|max:10000|mimes:jpeg,png,jpg'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $file = $request->file("photo")->getClientOriginalName();
        $photo = $this->create_file_name($file);

        Storage::disk('pokemon')->put($photo, File::get($request->file('photo')));


        $pokemon = Pokemon::create([
            "name" => $request->get("name"),
            "ps" => intval($request->get("ps")),
            "atq" => intval($request->get("atq")),
            "df" => intval($request->get("df")),
            "atq_spl" => intval($request->get("atq_spl")),
            "df_spl" => intval($request->get("df_spl")),
            "spl" => intval($request->get("spl")),
            "vel" => intval($request->get("vel")),
            "acc" => intval($request->get("acc")),
            "evs" => intval($request->get("evs")),
            "photo" => "/storage/pokemon/" . $photo
        ]);

        return response()->json(["pokemon" => $pokemon]);
    }

    public function update($id, Request $request)
    {
        try {
            $pokemon = Pokemon::findOrFail($id);
            if (!array_key_exists("name", $request->all())) {
                if ($request->hasFile('photo')) {
                    $arr = explode("/", $pokemon->photo);
                    $file = end($arr);
                    Storage::disk("pokemon")->delete($file);

                    $file = $request->file("photo")->getClientOriginalName();
                    $photo = $this->create_file_name($file);

                    Storage::disk('pokemon')->put($photo, File::get($request->file('photo')));
                    $pokemon->photo = "/storage/pokemon/";
                    $pokemon->update();
                }

                $pokemon->update($request->except(['photo']));
                return response()->json(["message" => "Pokemon updated"]);
            }
            return response()->json(["message" => "You cant edit the name of pokemon"], 400);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {
            $pokemon = Pokemon::findOrFail($id);
            $arr = explode("/", $pokemon->photo);
            $file = end($arr);
            $pokemon->delete();
            Storage::disk("pokemon")->delete($file);
            return response()->json(["message" => "Pokemon Deleted"]);
        } catch (Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    private function create_file_name($file)
    {
        $timestamp = strtotime("now");
        $randomKey = 21415;
        $arr = explode(".", $file);
        $name = $arr[0];
        $ext = $arr[1];
        $name_encrypt = base64_encode($timestamp . $randomKey . $name);
        $name_file = $name_encrypt . "." . $ext;
        return  $name_file;
    }
}
