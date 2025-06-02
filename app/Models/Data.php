<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Data extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'data_segment_id',
        'metadata',
        'report_summary',
        'table_of_contents',
        'segmentations',
        'reference_links',
        'attachments',

        'created_by',
        'deleted_by',
        'approved_by',

        'data_ref',
        'title',
        'historical_start',
        'historical_end',

        'approval_status',
        'view_count',
    ];
}
