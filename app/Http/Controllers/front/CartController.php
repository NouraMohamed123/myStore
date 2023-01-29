<?php

namespace App\Http\Controllers\front;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Cart\CartRepositry;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CartRepositry $cart)
    {
       // $repositroy = new CartModelRepositry();
   //   $repositroy = App::make('cart');
    
     // $items =  $repositroy->get();
     //   $items =  $cart->get();
     
        return view('front.cart',[
            'cart' =>   $cart ,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,CartRepositry $cart)
    {
       
        $request->validate([
            'product_id' => ['required','int','exists:products,id'],
            'quantity' =>['nullable','int','min:1']
        ]);
        $product = Product::find($request->post('product_id'));
    
        //    $repositroy = new CartModelRepositry();
        //  $items =  $repositroy->add( $product ,$request->post('quantity') ); 
        
         $items = $cart->add( $product ,$request->post('quantity') ); 
         if($request->expectsJson()){
            return response()->json([
                'message'=>'Item added to cart'
            ]);
         }
         return redirect()->route('cart.index')->with('success','product add to cart');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,CartRepositry $cart, $id)
    {
         $request->validate([
         
            'quantity' =>['nullable','int','min:1']
        ]);
      
        //    $repositroy = new CartModelRepositry();
        //  $items =  $repositroy->update( $product ,$request->post('quantity') ); 
          $items =  $cart->update( $id ,$request->post('quantity') ); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartRepositry $cart ,$id)
    {
        //     $repositroy = new CartModelRepositry();
           $items = $cart->delete( $id ); 
           return [
            'message'=>'item deleted !'
           ];
    }
}