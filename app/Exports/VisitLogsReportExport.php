<?php

namespace App\Exports;

use App\Models\VisitLog;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Carbon;

class VisitLogsReportExport implements FromView
{
    protected $dateFrom;
    protected $dateTo;

    public function __construct($dateFrom, $dateTo)
    {
        $this->dateFrom = Carbon::parse($dateFrom)->startOfDay();
        $this->dateTo = Carbon::parse($dateTo)->endOfDay();
    }

    public function view(): View
    {
        $logs = VisitLog::whereBetween('created_at', [$this->dateFrom, $this->dateTo])->get();

        $counts = [
            '0-11'  => ['male' => 0, 'female' => 0],
            '12-18' => ['male' => 0, 'female' => 0],
            '19-24' => ['male' => 0, 'female' => 0],
            '25+'   => ['male' => 0, 'female' => 0],
        ];

        foreach ($logs as $log) {
            $age = $log->age;
            $gender = $log->gender; // 'male' or 'female'

            $group = null;
            if ($age >= 0 && $age <= 11) {
                $group = '0-11';
            } elseif ($age >= 12 && $age <= 18) {
                $group = '12-18';
            } elseif ($age >= 19 && $age <= 24) {
                $group = '19-24';
            } elseif ($age >= 25) {
                $group = '25+';
            }

            if ($group) {
                $counts[$group][$gender]++;
            }
        }

        return view('exports.visit_logs_report', [
            'counts' => $counts,
            'logs' => $logs,
            'dateFrom' => $this->dateFrom->format('Y-m-d'),
            'dateTo' => $this->dateTo->format('Y-m-d'),
        ]);
    }
}
