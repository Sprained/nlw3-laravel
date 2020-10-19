<?php

namespace App\Http\Controllers;

use App\Http\Resources\Orphanages;
use App\Models\Orphanage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrphanageController extends Controller
{
    public function index()
    {
        $sql = "SELECT
                    o.id,
                    o.name,
                    o.latitude,
                    o.longitude,
                    o.about,
                    o.instructions,
                    o.open_on_weekends,
                    o.opening_hours,
                    i.id as idImage,
                    i.path
                FROM
                    orphanages AS o
                INNER JOIN 
                    images i ON i.id_orphanage = o.id";
        $orphanages = DB::select($sql);

        return response()->json(Orphanages::collection($orphanages));
    }

    public function show($id)
    {
        $sql = "SELECT
                    o.id,
                    o.name,
                    o.latitude,
                    o.longitude,
                    o.about,
                    o.instructions,
                    o.open_on_weekends,
                    o.opening_hours,
                    i.id as idImage,
                    i.path
                FROM
                    orphanages AS o
                INNER JOIN 
                    images i ON i.id_orphanage = o.id
                WHERE
                    o.id=$id";
        $orphanage = DB::selectOne($sql);

        return response()->json(new Orphanages($orphanage));
    }

    public function store(Request $request)
    {
        $name = $request->input('name');
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $about = $request->input('about');
        $instructions = $request->input('instructions');
        $opening_hours = $request->input('opening_hours');
        $open_on_weekends = $request->input('open_on_weekends');
        $images = $request->allFiles('images');

        // $sql = "INSERT INTO 
        //             orphanages ( name, latitude, longitude, about, instructions, open_on_weekends, opening_hours )
        //         VALUES
        //             ( $name, $latitude, $longitude, $about, $instructions, $opening_hours, $open_on_weekends )";
        // DB::insert($sql);

        $orphanage = Orphanage::create([
            'name' => $name,
            'latitude' => $latitude,
            'longitude' => $longitude,
            'about' => $about,
            'instructions' => $instructions,
            'opening_hours' => $opening_hours,
            'open_on_weekends' =>$open_on_weekends
        ]);

        // return response()->json($orphanage->id);
        foreach ($images as $value) {
            $image = (object) $value;
            $fileName = time() . '-' . $image->getClientOriginalName();
            $image->storeAs('public/imgs', $fileName);
            $sql = "INSERT INTO 
                        images ( path, id_orphanage )
                    VALUES
                        ( '$fileName', $orphanage->id )";
            DB::insert($sql);
        }

        return response()->json(['message' => 'Orfanato cadastrado com sucesso'], 201);
    }
}
