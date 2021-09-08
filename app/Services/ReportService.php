<?php

namespace App\Services;

use App\Models\Report;
use Illuminate\Support\Facades\Auth;

class ReportService
{
    public function create(array $fields)
    {
        $report = Report::create([
            'user_id' => Auth::user()->id,
        ]+$fields);

        return $report;
    }
}
