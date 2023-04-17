<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Cart;
use App\Models\Category;

class OrderController extends Controller
{
    //
    public function List()
    {
        $Order = Order::all();
        return view('admin.Order.list', compact('Order'));
    }
    public function Delete(Order $id)
    {
        $id->delete();
        return redirect()->route('Order.list')->with('success', 'Đã xóa sản phẩm');
    }

    public function Change(Order $id, $type)
    {
        $Order = Order::find($id);
        $Order->status = $type;
        $Order->save();
        return redirect()->back()->with('success', 'Thành công');
    }
    public function Show($id)
    {
        $Order = Order::find($id);
        $cartArray =  implode(',',$Order->id_cart);
        $Cart = Order::whereIn('id_cart',$cartArray)->get();
        return view('admin.Order.Show', compact('Order','Cart'));
    }
}
