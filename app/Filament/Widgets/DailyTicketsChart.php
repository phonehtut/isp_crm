<?php
namespace App\Filament\Widgets;

use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Illuminate\Support\Facades\DB;

class DailyTicketsChart extends ApexChartWidget
{
    /**
     * Chart Id
     *
     * @var string
     */
    protected static ?string $chartId = 'dailyTicketsChart';

    /**
     * Widget Title
     *
     * @var string|null
     */
    protected static ?string $heading = 'Daily Tickets Chart';

    /**
     * Chart options (series, labels, types, size, animations...)
     * https://apexcharts.com/docs/options
     *
     * @return array
     */
    protected function getOptions(): array
    {
        // Get the current date
        $currentDate = now()->format('Y-m-d');

        // Fetch ticket counts from the database for the current date
        $ticketCounts = DB::table('tickets')
            ->select(DB::raw('status, COUNT(*) as count'))
            ->whereIn('status', [0, 1, 2, 3])
            ->whereDate('updated_at', $currentDate)
            ->groupBy('status')
            ->pluck('count', 'status')
            ->all();

        // Prepare data for the chart
        $statuses = [0, 1, 2];
        $series = [];
        $labels = ['Open', 'Resolved', 'Closed'];

        foreach ($statuses as $status) {
            $series[] = $ticketCounts[$status] ?? 0;
        }

        return [
            'chart' => [
                'type' => 'bar',
                'height' => 300,
            ],
            'series' => [
                [
                    'name' => 'Tickets',
                    'data' => $series,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Number of Tickets',
                ],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
            ],
            'dataLabels' => [
                'enabled' => true,
            ],
            'legend' => [
                'labels' => [
                    'colors' => '#9ca3af',
                    'fontWeight' => 600,
                ],
            ],
        ];
    }
}
