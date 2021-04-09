<?php

namespace App\Exports;

use App\Exports\OrderProcessingEfficiencyReportSheet;
use App\Exports\OrderOverviewReportSheet;
use App\Exports\OrderDetailReportSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class DailyOrderReport implements WithMultipleSheets
{	
	use Exportable;
    private $query_info;

	public function __construct($query_info)
    {
        $this->query_info = $query_info;
    }
    public function sheets(): array
    {
        $sheets = [];
        $sheets[] = new OrderOverviewReportSheet($this->query_info);
        $sheets[] = new OrderDetailReportSheet($this->query_info);
        $sheets[] = new OrderProcessingEfficiencyReportSheet($this->query_info);
        return $sheets;
    }

}