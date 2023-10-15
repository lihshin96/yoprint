<?php

namespace App\Http\Controllers;

use App\Models\UploadHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use App\Events\RefreshUploadHistory;

class UploadHistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Default record limit
        $limit = 20;

        // Return 
        $return = ['data' => [], 'total' => 0];

        // Define Model
        $model = new UploadHistory;

        if(!empty($limit)) {
            $uploadHistory = $model->latest()->take($limit)->get();
        } else {
            $uploadHistory = $model->get();
        }

        return view('importCSV.index', compact('uploadHistory'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UploadHistory  $uploadHistory
     * @return \Illuminate\Http\Response
     */
    public function show(UploadHistory $uploadHistory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UploadHistory  $uploadHistory
     * @return \Illuminate\Http\Response
     */
    public function edit(UploadHistory $uploadHistory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UploadHistory  $uploadHistory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UploadHistory $uploadHistory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UploadHistory  $uploadHistory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UploadHistory $uploadHistory)
    {
        //
    }

    /**
     * Update status after job complete.
     *
     * @param  \App\Models\UploadHistory  $uploadHistory
     * @return \Illuminate\Http\Response
     */
    public function updateUploadHistoryStatus(UploadHistory $uploadHistory, $status)
    {
        if($uploadHistory) {
            DB::beginTransaction();
            $uploadHistory->status = $status;
            $save = $uploadHistory->save();
            if(!$save) {
                 DB::rollback();
                return "Failed to update history.";
            }

            DB::commit();
            event(new RefreshUploadHistory($uploadHistory));
        }
    }
}
