<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\ShippingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Purchase;
use App\Mail\Receive;
use App\Mail\Shipping;

/**
 * コントローラークラス
 * この中には
 * ・購入処理ビューの表示
 * ・購入時処理メソッド
 * ・発送処理ビューの表示
 * ・発送時処理メソッド
 * ・依頼者受取処理ビューの表示
 * ・依頼者受取時処理メソッド
 * が存在する
 */
class PsController extends Controller
{
    /**
     * 購入処理を行うビューを表示するメソッド
     *
     * @return void
     */
    public function purchaseView()
    {
        return view('purchase');
    }

    /**
     * 購入が行われた際の処理を行うメソッド
     *
     * @return void
     */
    public function purchase(PurchaseRequest $request)
    {
        // 送信相手のメールアドレスを取得
        $reciever = DB::table('users')->where('id', $request->user_id)->first('email');

        $price = $request->price; #価格
        $count = $request->count; #個数
        $user = Auth::user()->name; #メールに表示する名前
        $message = $request->message; #メールの内容


        $mailData = [
            'user' => $user,
            'message' => $message,
            'price' => $price,
            'count' => $count,
        ];

        // メールを送信するメソッド
        Mail::to($reciever)->send(new Purchase($mailData));


        $buying_date = new DateTime(); #DateTime関数のインスタンス化
        $buying_date->format('YY-mm-dd'); #購入日

        $data = [
            'buying_date' => $buying_date,
            'price' => $price,
            'count' => $count,
        ];

        //    テーブルのカラムを更新
        DB::table('buying_orders')->where('id', $request->id)->update($data);


        return redirect('index');
    }

    /**
     * 発送処理を行うビューを表示するメソッド
     *
     * @return void
     */
    public function shippingView()
    {
        return view('shipping');
    }

    /**
     * 発送が行われた際の処理を行うメソッド
     *
     * @return void
     */
    public function shipping(ShippingRequest $request)
    {
        // 送信相手のメールアドレスを取得
        $reciever = DB::table('users')->where('id', $request->user_id)->first('email');

        $shipping_cost = $request->shipping_cost; #フォームから送信された送料を取得
        $user = Auth::user()->name; #メールに表示する名前
        $message = $request->message; #メールの内容


        $mailData = [
            'user' => $user,
            'message' => $message,
            'shipping_cost' => $shipping_cost,
        ];

        // メールを送信するメソッド
        Mail::to($reciever)->send(new Shipping($mailData));

        $shipping_date = new DateTime(); #DateTime関数のインスタンス化
        $shipping_date->format('YY-mm-dd'); #購入日
        $data = [
            'shipping_cost' => $shipping_cost,
            'shipping_date' => $shipping_date,
        ];

        //    テーブルのカラムを更新
        DB::table('buying_orders')->where('id', $request->id)->update($data);
        return redirect('index');
    }
    /**
     * 依頼者が商品を受け取った旨を通知するビューを表示する
     *
     * @return void
     */
    public function receiveView()
    {
        return view('receive');
    }
    /**
     * 依頼者が商品を受け取った旨をメール通知し、データベースの受取完or未完を完にするメソッド
     *
     * @param Request $request
     * @return void
     */
    public function receive(Request $request)
    {
        // メールの受取人のメールアドレス（受取人は一人なので固定）
        $reciever = DB::table('users')->where('id', 1)->first('email');

        $user = Auth::user();
        $mailData['user'] = $user->name; #ユーザー名
        $mailData['message'] = $request->message; #備考欄

        // メールを送信するメソッド
        Mail::to($reciever)->send(new Receive($mailData));

        // 受取完了メソッド
        $buying_complete = $request->buying_complete;
        $data = [
            'buying_complete' => $buying_complete,
        ];

        DB::table('buying_orders')->where('id', $request->id)->update($data);
        return redirect('index');
    }
}
