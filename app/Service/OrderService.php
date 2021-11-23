<?php

namespace App\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function reserch($keyword = null, $start_date = null, $end_date = null)
    {
        // 管理者権限の有無で表示内容を条件分岐
        if (!empty(Auth::user()->admin)) {
            // 検索開始日と検索終了日、検索キーワードがある時の条件分岐
            if (!empty($keyword) && !empty($start_date) && !empty($end_date)) {
                $orders = DB::table('buying_orders')->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('buying_orders.user_id', Auth::user()->id)->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%')->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('buying_orders.id', 'like', '%' . $keyword . '%')->whereBetween('order_date', [$start_date, $end_date])
                    ->simplePaginate(5);
            }
            // 検索開始日と検索終了日がある時の条件分岐
            if (!empty($start_date) && !empty($end_date)) {
                $orders = DB::table('buying_orders')->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->simplePaginate(5);
            }

            // 検索キーワードがある時の条件分岐
            if (!empty($keyword)) {
                $orders = DB::table('buying_orders')
                    ->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('buying_orders.user_id', Auth::user()->id)->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%')->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('buying_orders.id', 'like', '%' . $keyword . '%')->simplePaginate(5);
            } else {
                $orders = DB::table('buying_orders')->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->simplePaginate(5);
            }
        } else {
            if (!empty($start_date) && !empty($end_date)) {
                $orders = DB::table('buying_orders')->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('buying_orders.user_id', Auth::user()->id)->whereBetween('order_date', [$start_date, $end_date])
                    ->simplePaginate(5);
            }

            // 検索キーワードがある時の条件分岐
            if (!empty($keyword)) {
                $orders = DB::table('buying_orders')
                    ->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('title', 'like', '%' . $keyword . '%')->orWhere('user_id', 'like', '%' . $keyword . '%')->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('buying_orders.id', 'like', '%' . $keyword . '%')->simplePaginate(5);
            } else {
                $orders = DB::table('buying_orders')
                    ->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('buying_orders.user_id', Auth::user()->id)->simplePaginate(5);
            }
        }
        return $orders;
    }
}
