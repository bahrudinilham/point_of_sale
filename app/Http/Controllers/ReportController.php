<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Generate weeks array for a given month period.
     * Each month is divided into 4 weeks, with the 4th week extending to month end.
     */
    private function generateWeeksForMonth($startOfMonth, $endOfMonth, bool $includeLabels = false): array
    {
        $weeks = [];
        $currentDate = $startOfMonth->copy();
        $weekCounter = 1;
        
        while ($currentDate->lte($endOfMonth)) {
            $startOfWeek = $currentDate->copy();
            $endOfWeek = $startOfWeek->copy()->addDays(6);

            // If this is the 4th week, force it to end at the end of the month
            if ($weekCounter == 4) {
                $endOfWeek = $endOfMonth->copy();
            } elseif ($endOfWeek->gt($endOfMonth)) {
                $endOfWeek = $endOfMonth->copy();
            }
            
            $weekData = [
                'start' => $startOfWeek,
                'end' => $endOfWeek
            ];

            if ($includeLabels) {
                $weekData['label'] = "Week $weekCounter (" . $startOfWeek->format('d M') . " - " . $endOfWeek->format('d M') . ")";
            }
            
            $weeks[$weekCounter] = $weekData;
            
            if ($weekCounter == 4) break;
            
            $currentDate = $endOfWeek->copy()->addDay();
            $weekCounter++;
        }

        return $weeks;
    }

    public function index(Request $request)
    {
        // --- Monthly Drill-down Data (Determine Month First) ---
        // Generate months for the dropdown (Jan - Dec of current year)
        $months = [];
        for ($m = 1; $m <= 12; $m++) {
            $months[$m] = date('F', mktime(0, 0, 0, $m, 1));
        }

        // Determine selected month (default to current month)
        $selectedMonth = (int) $request->input('month', now()->month);
        
        $startDateMonthly = now()->month($selectedMonth)->startOfMonth();
        $endDateMonthly = now()->month($selectedMonth)->endOfMonth();

        // Query Daily Data for the Selected Month
        $monthlySales = [];
        $monthlyLabels = [];
        $monthlyTransactionCount = 0;

        $periodMonthly = \Carbon\CarbonPeriod::create($startDateMonthly, $endDateMonthly);
        foreach ($periodMonthly as $date) {
            $monthlyLabels[] = $date->format('d M');
            $dayTransactions = \App\Models\Transaction::whereDate('transaction_date', $date)->get();
            $monthlySales[] = $dayTransactions->sum('final_amount');
            $monthlyTransactionCount += $dayTransactions->count();
        }
        $totalMonthlySales = array_sum($monthlySales);


        // --- Weekly Drill-down Data (Based on Selected Month) ---
        // Use the start and end of the SELECTED month
        $startOfMonth = $startDateMonthly->copy();
        $endOfMonth = $endDateMonthly->copy();
        
        // Generate weeks using helper method
        $weeks = $this->generateWeeksForMonth($startOfMonth, $endOfMonth, true);

        // Determine default week (Current week if applicable, otherwise last week)
        $defaultWeek = count($weeks);
        foreach ($weeks as $index => $week) {
            if (now()->between($week['start'], $week['end'])) {
                $defaultWeek = $index;
                break;
            }
        }

        // Determine selected week
        $selectedWeek = (int) $request->input('week', $defaultWeek);
        // If selected week is invalid for this month, default to the last week
        if (!isset($weeks[$selectedWeek])) {
            $selectedWeek = count($weeks);
        }

        // Handle case where a month might have no weeks (unlikely but safe)
        if (empty($weeks)) {
             $startDateWeekly = $startOfMonth;
             $endDateWeekly = $startOfMonth;
             $totalWeeklySales = 0;
             $weeklyTransactionCount = 0;
             $weeklySales = [];
             $weeklyLabels = [];
        } else {
            $startDateWeekly = $weeks[$selectedWeek]['start'];
            $endDateWeekly = $weeks[$selectedWeek]['end'];

            // Query Daily Data for the Selected Week
            $weeklySales = [];
            $weeklyLabels = [];
            $weeklyTransactionCount = 0;
            
            $period = \Carbon\CarbonPeriod::create($startDateWeekly, $endDateWeekly);
            foreach ($period as $date) {
                $weeklyLabels[] = $date->format('d M');
                $dayTransactions = \App\Models\Transaction::whereDate('transaction_date', $date)->get();
                $weeklySales[] = $dayTransactions->sum('final_amount');
                $weeklyTransactionCount += $dayTransactions->count();
            }
            $totalWeeklySales = array_sum($weeklySales);
        }


        // --- Custom Date Range Data ---
        $customStartDate = $request->input('start_date') ? \Carbon\Carbon::parse($request->input('start_date')) : now()->subDays(6);
        $customEndDate = $request->input('end_date') ? \Carbon\Carbon::parse($request->input('end_date')) : now();

        // Ensure start date is before or equal to end date
        if ($customStartDate->gt($customEndDate)) {
             $temp = $customStartDate;
             $customStartDate = $customEndDate;
             $customEndDate = $temp;
        }

        $customSales = [];
        $customLabels = [];
        $customTransactionCount = 0;

        $periodCustom = \Carbon\CarbonPeriod::create($customStartDate, $customEndDate);
        foreach ($periodCustom as $date) {
            $customLabels[] = $date->format('d M');
            $dayTransactions = \App\Models\Transaction::whereDate('transaction_date', $date)->get();
            $customSales[] = $dayTransactions->sum('final_amount');
            $customTransactionCount += $dayTransactions->count();
        }
        $customTotalSales = array_sum($customSales);

        // --- Summary Cards Data & Growth Indicators ---
        $todaySales = \App\Models\Transaction::whereDate('transaction_date', now())->sum('final_amount');
        $yesterdaySales = \App\Models\Transaction::whereDate('transaction_date', now()->subDay())->sum('final_amount');
        $todayGrowth = $yesterdaySales > 0 ? (($todaySales - $yesterdaySales) / $yesterdaySales) * 100 : 0;

        $currentWeekSales = \App\Models\Transaction::whereBetween('transaction_date', [now()->startOfWeek(), now()->endOfWeek()])->sum('final_amount');
        $lastWeekSales = \App\Models\Transaction::whereBetween('transaction_date', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])->sum('final_amount');
        $weekGrowth = $lastWeekSales > 0 ? (($currentWeekSales - $lastWeekSales) / $lastWeekSales) * 100 : 0;

        $currentMonthSales = \App\Models\Transaction::whereMonth('transaction_date', now()->month)->whereYear('transaction_date', now()->year)->sum('final_amount');
        $lastMonthSales = \App\Models\Transaction::whereMonth('transaction_date', now()->subMonth()->month)->whereYear('transaction_date', now()->subMonth()->year)->sum('final_amount');
        $monthGrowth = $lastMonthSales > 0 ? (($currentMonthSales - $lastMonthSales) / $lastMonthSales) * 100 : 0;

        // --- Top 5 Products ---
        $topProducts = \App\Models\TransactionItem::select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(7)
            ->get();

        return view('reports.index', compact(
            'weeklySales', 'weeklyLabels', 'totalWeeklySales', 'weeklyTransactionCount', 'startDateWeekly', 'endDateWeekly', 'weeks', 'selectedWeek',
            'monthlySales', 'monthlyLabels', 'totalMonthlySales', 'monthlyTransactionCount', 'startDateMonthly', 'endDateMonthly', 'months', 'selectedMonth',
            'customSales', 'customLabels', 'customTotalSales', 'customTransactionCount', 'customStartDate', 'customEndDate',
            'todaySales', 'todayGrowth', 'currentWeekSales', 'weekGrowth', 'currentMonthSales', 'monthGrowth', 'topProducts'
        ));
    }

    public function print(Request $request)
    {
        $type = $request->input('type', 'monthly');
        
        $sales = [];
        $labels = [];
        $transactionCount = 0;
        $totalSales = 0;
        $startDate = null;
        $endDate = null;
        $periodText = '';

        if ($type === 'monthly') {
            $selectedMonth = (int) $request->input('month', now()->month);
            $startDate = now()->month($selectedMonth)->startOfMonth();
            $endDate = now()->month($selectedMonth)->endOfMonth();
            $periodText = $startDate->format('F Y');

            $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $labels[] = $date->format('d M');
                $dayTransactions = \App\Models\Transaction::whereDate('transaction_date', $date)->get();
                $sales[] = $dayTransactions->sum('final_amount');
                $transactionCount += $dayTransactions->count();
            }
        } elseif ($type === 'weekly') {
            $selectedMonth = (int) $request->input('month', now()->month);
            $selectedWeek = (int) $request->input('week');
            
            $startOfMonth = now()->month($selectedMonth)->startOfMonth();
            $endOfMonth = now()->month($selectedMonth)->endOfMonth();
            
            // Use shared helper method
            $weeks = $this->generateWeeksForMonth($startOfMonth, $endOfMonth);

            // Fallback if week not found
            if (!isset($weeks[$selectedWeek])) {
                $selectedWeek = count($weeks) > 0 ? count($weeks) : 1;
            }

            if (isset($weeks[$selectedWeek])) {
                $startDate = $weeks[$selectedWeek]['start'];
                $endDate = $weeks[$selectedWeek]['end'];
                $periodText = "Week $selectedWeek (" . $startDate->format('d M') . " - " . $endDate->format('d M Y') . ")";

                $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
                foreach ($period as $date) {
                    $labels[] = $date->format('d M');
                    $dayTransactions = \App\Models\Transaction::whereDate('transaction_date', $date)->get();
                    $sales[] = $dayTransactions->sum('final_amount');
                    $transactionCount += $dayTransactions->count();
                }
            }
        } elseif ($type === 'custom') {
            $startDate = \Carbon\Carbon::parse($request->input('start_date', now()->startOfMonth()));
            $endDate = \Carbon\Carbon::parse($request->input('end_date', now()));
            $periodText = $startDate->format('d M Y') . " - " . $endDate->format('d M Y');

            $period = \Carbon\CarbonPeriod::create($startDate, $endDate);
            foreach ($period as $date) {
                $labels[] = $date->format('d M');
                $dayTransactions = \App\Models\Transaction::whereDate('transaction_date', $date)->get();
                $sales[] = $dayTransactions->sum('final_amount');
                $transactionCount += $dayTransactions->count();
            }
        }

        $totalSales = array_sum($sales);
        
        // Top Products for the selected period
        $topProducts = \App\Models\TransactionItem::whereHas('transaction', function($q) use ($startDate, $endDate) {
                $q->whereBetween('transaction_date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            })
            ->select('product_id', \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'))
            ->with('product')
            ->groupBy('product_id')
            ->orderByDesc('total_qty')
            ->limit(7)
            ->get();

        return view('reports.print', compact(
            'sales', 'labels', 'totalSales', 'transactionCount', 'startDate', 'endDate', 'periodText', 'topProducts', 'type'
        ));
    }
}
