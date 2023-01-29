<?php

namespace App\Http\Controllers\front;

use App\Models\Order;
use App\Models\OrderItem;

use App\Events\OrderCreated;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Intl\Countries;
use App\Repositories\Cart\CartRepositry;

class CheckOutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(CartRepositry $cart)
    {
        if ($cart->get()->count() == 0) {
            return redirect()->route('home');
        }
        return view('front.checkout', [
            'cart' => $cart,
            'countries' => Countries::getNames('en'),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, CartRepositry $cart)
    {
        DB::beginTransaction();
        try {
            $items = $cart
                ->get()
                ->groupBy('product.store_id')
                ->all();

            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_methos' => 'cod',
                ]);
                foreach ($cart_items as $item) {
                    DB::table('order_items')->insert([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => 'ii',
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach ($request->post('addr') as $type => $addresse) {
                    $addresse['type'] = $type;
                    $addresse['order_id'] = $order->id;
                    OrderAddress::create($addresse);

                    //   $order->addresses->create($addresse);
                }
                DB::commit();
                //  event('order.created');
                event(new OrderCreated($order));
            }
            //  $cart->empty();
        } catch (Throwable $e) {
            print_r($e->getMessage());
            exit();
            DB::rollBack();

            throw $e;
        }
        return redirect()->route('orders.payments.create', $order->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}