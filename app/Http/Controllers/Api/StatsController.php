<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StatsModel;
use App\Models\StatsOverviewModel;
use Validator;



class StatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Getting overall stats from database view
        $statsOverview = StatsOverviewModel::all()->first();

        //Getting daily records
        $dailyStats = StatsModel::select([
                'date',
                'tested',
                'confirmed',
                'recovered',
                'deaths'
                 ])
               ->get();

        $currentDate = date('Y-m-d');
        $currentDateStats = "";
        $dailyStats =  $dailyStats->toArray();
        $dailyStatsArrayList = array();

        //Assigning current date stats to a separate array
        foreach($dailyStats as $statsRow){
            if (in_array($currentDate, $statsRow)) {
                $currentDateStats = $statsRow;
                break;
            }
        }

        //Assigning default values when no records found for current day
        if(empty($currentDateStats)){
            $currentDateStats = array('date'=>$currentDate, 'tested'=>0, 'confirmed'=>0, 'recovered'=>0, 'deaths'=>0);
        }

        //Re-arranging daily records array by eliminating array keys
        array_map(function($item) use (&$dailyStatsArrayList){
            $dailyStatsArrayList[] = [$item['date'], $item['tested'], $item['confirmed'], $item['recovered'], $item['deaths']];
        }, $dailyStats);

        $statsOverview['current_day'] = $currentDateStats;
        $statsOverview['daily_records'] = $dailyStatsArrayList;

        //Preparing response array
        $responseArray = array('success'=>true,
                               'message'=>'success',
                               'data'=> $statsOverview,
        );

        return response($responseArray,200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'date' => 'required|date_format:Y-m-d|unique:api_stats,date',
            'tested' => 'integer',
            'confirmed' => 'integer',
            'recovered' => 'integer',
            'deaths' => 'integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response($validator->errors(), 400);
        }

        $dailyStats = StatsModel::create($request->all());

        $responseArray = array('success'=>true,
            'message'=>'success',
            'data'=> $dailyStats,
        );

        return response($responseArray,200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $year
     * @param  int  $month
     * @param  int  $day
     * @return \Illuminate\Http\Response
     */
    public function show($year, $month, $day)
    {
        //Getting the selected record by date
        $dailyStats = StatsModel::select([
            'date',
            'tested',
            'confirmed',
            'recovered',
            'deaths',
            'updated_at'
        ])
            ->whereYear('date','=', $year)
            ->whereMonth('date','=', $month)
            ->whereDay('date','=', $day)
            ->get();


        $responseArray = array('success'=>true,
                'message'=>'success',
                'data'=> $dailyStats,
        );
        return response($responseArray,200);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $year, $month, $day)
    {
        $rules = [
            'tested' => 'integer',
            'confirmed' => 'integer',
            'recovered' => 'integer',
            'deaths' => 'integer',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()){
            return response($validator->errors(), 400);
        }

        StatsModel::whereYear('date','=', $year)
            ->whereMonth('date','=', $month)
            ->whereDay('date','=', $day)
            ->update($request->all());

        $responseArray = array('success'=>true,
            'message'=>'Successfully updated'
        );

        return response($responseArray,201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
