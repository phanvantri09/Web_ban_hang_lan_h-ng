<?php
   
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  App\Models\Product;
use  App\Models\Category;
use  App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Bill\createRequest;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
       
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {  
        $pro = Product::all();
        
        return view('users.home', compact('pro'));
    }
    public function viewpro( $id){
        
        $pro1 = Product::find($id);
        return view('users.pages.product.detail', compact('pro1'));
        
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function adminHome()

    {
        $this->middleware('auth');
        return view('admin.home');
    }

    public function addcart($idUser , $idProduct){
        $cardData = Cart::all();
        //dd($cardData);
        foreach($cardData as $key => $card)
        {
            $empryData =($card->idProduct == $idProduct) && ($card->idUser == $idUser) && ($card->amount >= 1);
            //dd($k);
            if($empryData == true)
            {
                $cardRowUpdate = Cart::find($card->id);
                $cardRowUpdate->amount = $card->amount + 1;
                $cardRowUpdate->save();
                return redirect()->route('home')->with('success','Successfully add card ');
            }
        }
        if(Cart::create([
            'idUser'=>$idUser,
            'idProduct'=>$idProduct,
            'genaral'=>1,
            'amount'=>1
        ])){
            return redirect()->route('home')->with('success','Successfully add card ');
        }
        else{
            return redirect()->route('home')->with('error','error add card ');
        }
    }
    public function themcart($idUser , $idProduct){
        $cardData = Cart::all();
        //dd($cardData);
        foreach($cardData as $key => $card)
        {
            $empryData =($card->idProduct == $idProduct) && ($card->idUser == $idUser)  && ($card->amount >= 1);
            //dd($k);
            if($empryData == true)
            {
                $cardRowUpdate = Cart::find($card->id);
                $cardRowUpdate->amount = $card->amount + 1;
                $cardRowUpdate->save();
                return redirect()->route('home.cartUser',Auth::user()->id)->with('success','Đã thêm thành công');
            }
        }
        if(Cart::create([
            'idUser'=>$idUser,
            'idProduct'=>$idProduct,
            'genaral'=>1,
            'amount'=>1
        ])){
            return redirect()->route('home')->with('success','Successfully add card ');
        }
        else{
            return redirect()->route('home')->with('error','error add card ');
        }
    }
    public function trucart($idUser , $idProduct){
        $cardData = Cart::all();
        //dd($cardData);
        foreach($cardData as $key => $card)
        {
            $empryData =($card->idProduct == $idProduct) && ($card->idUser == $idUser);
            //dd($k);
            if($empryData == true && ($card->amount >= 2))
            {
                $cardRowUpdate = Cart::find($card->id);
                $cardRowUpdate->amount = $card->amount - 1;
                $cardRowUpdate->save();
                return redirect()->route('home.cartUser',Auth::user()->id)->with('success','Đã trừ thành công ');
            }
            if($empryData == true && ($card->amount = 1)){
                $card->delete();
                return redirect()->route('home.cartUser',Auth::user()->id)->with('error','Sản phẩm đã được xóa của bạn');
            }
        }
        if(Cart::create([
            'idUser'=>$idUser,
            'idProduct'=>$idProduct,
            'genaral'=>1,
            'amount'=>1
        ])){
            return redirect()->route('home')->with('success','Successfully add card ');
        }
        else{
            return redirect()->route('home')->with('error','error add card ');
        }
    }

    public function viewProduct($idProduct){
        $data =Product::find($idProduct);
        $amount = 0;
        $total =0;
        $idUser = Auth::user()->id;
        $cart = Cart::where('idUser','=',$idUser)->get();
        //$data = Product::orderBy('id','DESC')->search()->paginate(20);
        foreach($cart as $car){
            if($car->idUser == $idUser && $car->genaral == 1){
                $product =Product::find($car->idProduct); 
                if(!empty($product)) 
                {
                    $total = $total + ($product->price * $car->amount);
                    $amount++;
                }
                else
                {
                    $total = 0;
                    $amount = 0;
                }
            }
        }
        return view("page.content.product", compact('data', 'total','amount'));
    }
    public function delete(Cart $id)
    {   
        $id->delete();
        return redirect()->route('home.cartUser',Auth::user()->id)->with('success','Đã xóa sản phẩm');   
    }
    public function pay(){
        $amount = 0;
        $total =0;
        $idUser = Auth::user()->id;
        $cart = Cart::where('idUser','=',$idUser)->get();
        $products = Product::all();
        foreach($cart as $car){
            if($car->idUser == $idUser ){
                $product =Product::find($car->idProduct); 
                if(!empty($product)) 
                {
                    $total = $total + ($product->price * $car->amount);
                    $amount++;
                }
                else
                {
                    $total = 0;
                    $amount = 0;
                }
            }
        }
        $data = Cart::where('idUser','=',$idUser)->get();
        return view("users.pages.order.checkout", compact('data', 'total','amount', 'products'));
    }
    public function cartUser($idUser){
        $amount = 0;
        $total =0;
        $idUser = Auth::user()->id;
        $cart = Cart::where('idUser','=',$idUser)->get();
        $products = Product::all();
        foreach($cart as $car){
            if($car->idUser == $idUser ){
                $product =Product::find($car->idProduct);
                if(!empty($product)) 
                {
                    $total = $total + ($product->price * $car->amount);
                    $amount++;
                }
                else
                {
                    $total = 0;
                    $amount = 0;
                }
            }
        }
        $data = Cart::where('idUser','=',$idUser)->get();
        return view('users.pages.cart.cart', compact('products','data','total','amount'));
    }
    public function postthanhtoan(createRequest $request){
        // dd($request->all());
        if(Bill::create([
            'idUser'=>Auth::user()->id,
            'name'=>$request->name,
            'email'=>$request->email,
            'genaral'=>1,
            'price'=>$request->price,
            'numberPhone'=>$request->numberPhone,
            'address'=>"Số-Đường :".$request->sonha."/Xã :".$request->xa."/Huyện-Quận :".$request->huyen."/Tỉnh :".$request->tinh
        ]))
        {
            $cartUser = Cart::where('idUser', '=', Auth::user()->id)->get();
            //dd($cartUser);
            foreach($cartUser as $car){
                //$pro = Product::where('id', '=', $car->idProduct)->get();
                $pro =Product::find($car->idProduct); 
                //dd($pro);
                $pro->amount = $pro->amount - $car->amount;
                $pro->save();
                $car->genaral = 2;
                $car->save();
            }
            return redirect()->route('home')->with('success','Đặt thành công.');
        }
    }

    
}