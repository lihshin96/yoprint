<?php

namespace App\Jobs;

use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\UploadHistory;

class ProcessCSVData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;

    public $header;
    public $data;
    public $uploadHistoryID;

    /**
     * Create new job instance.
     *
     * @return void
     */
    public function __construct($data, $header, $uploadHistoryID)
    {
        $this->data = $data;
        $this->header = $header;
        $this->uploadHistoryID = $uploadHistoryID;
    }

    /**
     * Handle the job.
     *
     * @return void
     */
    public function handle()
    {
        try
        {
            $uploadHistoryRecord = UploadHistory::find($this->uploadHistoryID);
            if($uploadHistoryRecord) {
                $status = UploadHistory::PROCESSING;
                $response = app('App\Http\Controllers\UploadHistoryController')->updateUploadHistoryStatus($uploadHistoryRecord, $status);
            }

            foreach ($this->data as $products) {
                $productData = array_combine($this->header,$products);
                if (is_array($productData) && !empty($productData)) {
                    Product::upsert([
                        'UNIQUE_KEY' => $productData['UNIQUE_KEY'],
                        'PRODUCT_TITLE' => $productData['PRODUCT_TITLE'],
                        'PRODUCT_DESCRIPTION' => $productData['PRODUCT_DESCRIPTION'],
                        'STYLE#' => $productData['STYLE#'],
                        'SANMAR_MAINFRAME_COLOR' => $productData['SANMAR_MAINFRAME_COLOR'],
                        'SIZE' => $productData['SIZE'],
                        'COLOR_NAME' => $productData['COLOR_NAME'],
                        'PIECE_PRICE' => $productData['PIECE_PRICE'],
                    ], ['UNIQUE_KEY']);
                }
            }

            $this->succeeded();

        } catch (Exception $e) {
            throw $e;
        }

    }

    /**
     * Callback when job is succeeded
     *
     * @return void
     */
    public function succeeded()
    {
        $uploadHistoryRecord = UploadHistory::find($this->uploadHistoryID);
        if($uploadHistoryRecord) {
            $status = UploadHistory::COMPLETED;
            $response = app('App\Http\Controllers\UploadHistoryController')->updateUploadHistoryStatus($uploadHistoryRecord, $status);
        }
    }

    /**
     * Callback when job is failed
     *
     * @return void
     */
    public function failed()
    {
        $uploadHistoryRecord = UploadHistory::find($this->uploadHistoryID);
        if($uploadHistoryRecord) {
            $status = UploadHistory::FAILED;
            $response = app('App\Http\Controllers\UploadHistoryController')->updateUploadHistoryStatus($uploadHistoryRecord, $status);
        }
    }
}
