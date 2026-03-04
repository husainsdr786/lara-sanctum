<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function topSpenders()
    {
        $data = Cache::remember('top_spenders', 60, function () {

            return DB::table('orders')
                ->join('users', 'orders.user_id', '=', 'users.id')
                ->select(
                    'users.id',
                    'users.name',
                    DB::raw('SUM(orders.total) as total_spent'),
                    DB::raw('COUNT(orders.id) as total_orders')
                )
                ->groupBy('users.id', 'users.name')
                ->orderByDesc('total_spent')
                ->paginate(5);
        });

        return response()->json($data);
    }
}