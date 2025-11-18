<?php

// app/Http/Controllers/DownloadController.php
namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DownloadController extends Controller
{
    public function download(Request $request, $orderId)
    {
        $purchase = Purchase::where('order_id', $orderId)
            ->where('status', 'completed')
            ->firstOrFail();

        if (!$purchase->canDownload()) {
            abort(403, 'Download not available or expired');
        }

        $dataPoint = $purchase->dataPoint;
        $attachments = $dataPoint->attachments;

        if ($attachments->count() === 1) {
            // Single file download
            $file = $attachments->first();
            $purchase->incrementDownload();
            return Storage::disk('public')->download($file->file_path, $file->file_name);
        }

        // Multiple files - create ZIP
        $zipFileName = $dataPoint->slug . '-' . now()->format('Ymd') . '.zip';
        $zipPath = storage_path('app/temp/' . $zipFileName);

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($attachments as $attachment) {
                $filePath = storage_path('app/public/' . $attachment->file_path);
                $zip->addFile($filePath, $attachment->file_name);
            }
            $zip->close();
        }

        $purchase->incrementDownload();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend();
    }
}