<?php

namespace App\Filament\Widgets;

use Illuminate\Support\Facades\DB;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class CustomerInstallationTotalCableChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'customerInstallationTotalCableChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Installation Total Cable Chart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Query the total cable count grouped by month
        $data = DB::table('customers')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_cable) as total_cable'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month')
            ->toArray();

        // Initialize an array with 12 elements for each month
        $monthlyData = array_fill(1, 12, 0);

        // Populate the monthlyData array with actual values
        foreach ($data as $month => $info) {
            $monthlyData[$month] = $info->total_cable;
        }

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Customer Installation Total Cable',
                    'data' => array_values($monthlyData),
                ],
            ],
            'xaxis' => [
                'categories' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
        ];
    }
}
