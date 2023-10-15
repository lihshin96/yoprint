<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\UploadHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use League\Csv\Reader;
use App\Jobs\ProcessCSVData;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }

    /**
     * Process uploaded CSV file.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function processCSVFile(Request $request)
    {
        // If CSV exist in requests
        if($request->has('csv_file')) {
            $file = $request->file('csv_file');
            $fileName = $file->getClientOriginalName();
            $fileSize = $file->getSize();
            $fileContent = file_get_contents($file->getRealPath());
            $fileHash = hash('sha256', $fileContent);

            $csv_file = file($request->csv_file);
            $chunks = array_chunk($csv_file,1000);
            $batch  = Bus::batch([])->dispatch();
            $header = [];
            $csv_data = [];

            DB::beginTransaction();

            // Insert upload history
            $uploadHistoryID = null;
            $insertUploadHistory = UploadHistory::create([
                'file_name' => $fileName,
                'file_size' => $fileSize,
                'file_hash' => $fileHash
            ]);

            if(!$insertUploadHistory)
            {
                DB::rollback();
                return response()->json([
                    'status' => '',
                    'msg' => 'Failed to update upload record.',
                ]);
            }

            $uploadHistoryID = $insertUploadHistory->id;

            foreach ($chunks as $key => $chunk) {
                // Remove non UTF-8 character
                $cleanedChunk = array_map(function($row) {
                    // Remove BOM (U+FEFF) character
                    $row = preg_replace('/\x{FEFF}/u', '', $row);

                    // Remove non-UTF-8 characters
                    return iconv('UTF-8', 'UTF-8//IGNORE', $row);
                }, $chunk);

                $data = array_map('str_getcsv', $cleanedChunk);

                // Get CSV header
                if($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }

                $batch->add(new ProcessCSVData($data, $header, $uploadHistoryID));
            }

            DB::commit();
            return redirect()->route('importCSV.index')->with('success', 'Successful added CSV import on queue.');
        }

        return response()->json([
            'status' => '',
            'msg' => 'CSV not found, please try to upload CSV file again.',
        ]);
    }
}
