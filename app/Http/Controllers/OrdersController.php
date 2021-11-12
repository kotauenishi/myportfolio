<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * リソースコントローラー
 * この中には
 * ・マイページの表示
 * ・新規依頼作成フォームの表示
 * ・新規依頼作成メソッド
 * ・ユーザー情報変更メソッド
 * ・詳細画面表示
 * に関するメソッドが存在する
 */
class OrdersController extends Controller
{


    /**
     * マイページを表示するメソッド
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buying_orders = DB::table('buying_orders');

        // 管理者が依頼を受けた合計金額を算出する為に必要な処理
        $seller_datas = $buying_orders->get();

        // 依頼者が自身の行った依頼の合計金額を確認する為に必要な処理
        $buyer_datas = $buying_orders->where('user_id', Auth::user()->id)->get();

        $keyword = $request->keyword; #検索キーワード
        $start_date = $request->start_date; #検索開始日
        $end_date = $request->end_date; #検索終了日

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
                return view('index', ['orders' => $orders, 'seller_datas' => $seller_datas, 'buyer_datas' => $buyer_datas]);
                exit;
            }
            // 検索開始日と検索終了日がある時の条件分岐
            if (!empty($start_date) && !empty($end_date)) {
                $orders = DB::table('buying_orders')->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->whereBetween('order_date', [$start_date, $end_date])
                    ->simplePaginate(5);
                return view('index', ['orders' => $orders, 'seller_datas' => $seller_datas, 'buyer_datas' => $buyer_datas]);
                exit;
            }

            // 検索キーワードがある時の条件分岐
            if (!empty($keyword)) {
                $orders = DB::table('buying_orders')
                    ->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('buying_orders.user_id', Auth::user()->id)->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orWhere('name', 'like', '%' . $keyword . '%')->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('buying_orders.id', 'like', '%' . $keyword . '%')->simplePaginate(5);
                return view('index', ['orders' => $orders, 'seller_datas' => $seller_datas, 'buyer_datas' => $buyer_datas]);
                exit;
            } else {
                $orders = DB::table('buying_orders')->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->simplePaginate(5);
                return view('index', ['orders' => $orders, 'seller_datas' => $seller_datas, 'buyer_datas' => $buyer_datas]);
                exit;
            }
        } else {
            if (!empty($start_date) && !empty($end_date)) {
                $orders = DB::table('buying_orders')->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('buying_orders.user_id', Auth::user()->id)->whereBetween('order_date', [$start_date, $end_date])
                    ->simplePaginate(5);
                return view('index', ['orders' => $orders, 'seller_datas' => $seller_datas, 'buyer_datas' => $buyer_datas]);
                exit;
            }

            // 検索キーワードがある時の条件分岐
            if (!empty($keyword)) {
                $orders = DB::table('buying_orders')
                    ->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('title', 'like', '%' . $keyword . '%')->orWhere('user_id', 'like', '%' . $keyword . '%')->orWhere('name', 'like', '%' . $keyword . '%')
                    ->orWhere('buying_orders.id', 'like', '%' . $keyword . '%')->simplePaginate(5);
                return view('index', ['orders' => $orders, 'seller_datas' => $seller_datas, 'buyer_datas' => $buyer_datas]);
                exit;
            } else {
                $orders = DB::table('buying_orders')
                    ->select('buying_orders.id as id', 'name', 'title', 'order_date')
                    ->join('users', 'buying_orders.user_id', '=', 'users.id')
                    ->where('buying_orders.user_id', Auth::user()->id)->simplePaginate(5);
                return view('index', ['orders' => $orders, 'seller_datas' => $seller_datas, 'buyer_datas' => $buyer_datas]);
                exit;
            }
        }
    }

    /**
     * 新規依頼作成フォームを表示する
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }

    /**
     * 新規依頼をordersテーブルに格納するメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrderRequest $request)
    {
        $order_date = new DateTime();
        $order_date->format('YY-mm-dd'); #依頼作成日
        $message = $request->message; #備考欄
        $item_name = $request->item_name; #商品名or通販サイトURL
        $count = $request->count; #個数
        $price = $request->price; #値段
        $title = $request->title; #依頼のタイトル

        $user_id = Auth::user()->id; #ユーザーIDを取得
        $order_data = [
            'item_name' => $item_name,
            'title' => $title,
            'count' => $count,
            'price' => $price,
            'message' => $message,
            'user_id' => $user_id,
            'order_date' => $order_date,
        ];

        // buying_ordersテーブルに$order_dataを格納
        e(DB::table('buying_orders')->insert($order_data));

        return redirect('index');
    }

    /**
     * 依頼内容の詳細を表示するメソッド
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // buying_ordersテーブルから対象のIDを持つカラムを取得
        $order = DB::table('buying_orders')->where('id', $request->id)->first();

        return view("detail", ['order' => $order]);
    }

    /**
     * ユーザー情報を更新するフォームを表示するメソッド
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('edit');
    }

    /**
     * ユーザー情報を更新するメソッド
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $old_password = $request->old_password; #現在のパスワード
        $id = Auth::user()->id; #ユーザーID
        $email = $request->email; #メールアドレス
        $password = $request->password; #パスワード

        // 入力された現在のパスワードとusersテーブルのpasswordカラムが等しいかを確認
        if (Hash::check($old_password, Auth::user()->password)) {

            // メールアドレスを変更する処理
            if (!empty($email)) {
                $mailData = [
                    'email' => $email,
                ];
                e(DB::table('users')->where('id', $id)->update($mailData));
            }

            // パスワードを変更する処理
            if (!empty($password)) {
                $passData = [
                    'password' => Hash::make($password),
                ];
                e(DB::table('users')->where('id', $id)->update($passData));
            }

            return redirect('index');
        }

        // 現在のパスワードの整合が出来なかった時の処理
        $msg = '誤ったデータが入力されました。';
        return view('edit', ['msg' => $msg]);
    }

    /**
     * 依頼を消去するメソッド
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
