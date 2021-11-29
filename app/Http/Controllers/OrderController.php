<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Products;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function placeOrder()
    {
        $user_id = request('user_id');
        $product_id = request('product_id');
        $product = Products::where('id', $product_id)->first();
        $data['price'] = $product->price;
        $data['product_id'] = $product_id;
        $data['user_id'] = $user_id;
        $data['stkId'] = request('stkId');
        $data['name'] = request('name');
        $data['qty'] = request('qty');
        $data['phone'] = request('phone');
        $data['address'] = request('address');
        Order::create($data);
        return response()->json(array("status" => 200, "msg" => "SUCCESSFULLY INSERTED"), 201);
    }
    public function editOrder()
    {
        $id = request('order_id');
        $order = Order::select('*', 'orders.name as orderName', 'products.qty as pQuantity', 'orders.id as orderId')->join('products', 'products.id', '=', 'orders.product_id')->where(["orders.id" => $id, 'is_active_status' => 0])->first();
        if (is_null($order)) {
            return response()->json(array("status" => 401, "data" => "No data found"));
        } else {
            return response()->json(array("status" => 200, "data" => $order));
        }
    }
    public function updateOrder()
    {
        $id = request('id');
        $name = request('name');
        $address = request('address');
        $phone = request("phone");
        $order = Order::where('id', $id)->first();
        $order->name = $name;
        $order->address = $address;
        $order->phone = $phone;
        $order->save();
        return response()->json(array("status" => 200, "data" => $order));
    }
    public function getOrders()
    {
        $id = request('user_id');
        $order = Order::select('*', 'orders.name as orderName', 'products.qty as pQuantity', 'orders.qty as orderQuantity', 'orders.id as orderId')->join('products', 'products.id', '=', 'orders.product_id')->where('user_id', $id)->get();
        return $order;
    }
    public function getAllOrders()
    {
        $order = Order::select('*', 'orders.name as orderName', 'products.qty as pQuantity', 'orders.qty as orderQuantity', 'orders.id as orderId')->join('products', 'products.id', '=', 'orders.product_id')->where('status', '!=', 3)->get();
        return $order;
    }
    public function change_approval_status()
    {
        $type = request('action_type');
        $id = request('order_id');
        if ($type == 'approve') {
            Order::where('id', $id)->update(array('is_active_status' => 1));
        } else {
            Order::where('id', $id)->update(array('is_active_status' => 2));
        }
        return response()->json(array("status" => 200, "msg" => "SUCCESSFULLY APPROVED"), 200);
    }
    public function search($name)
    {
        return Order::select('*', 'orders.name as orderName', 'products.qty as pQuantity', 'orders.qty as orderQuantity', 'orders.id as orderId')->join('products', 'products.id', '=', 'orders.product_id')->where('stkId', 'like', '%' . $name . '%')->get();
    }
    public function AuditHistory($id)
    {
        $audit = Order::find($id)->audits;
        return $audit;
    }
    public function orderSort($keys, $values)
    {
        $id = request('user_id');
        if ($keys == "is_active_status") {
            return Order::select('*', 'orders.name as orderName', 'products.qty as pQuantity', 'orders.qty as orderQuantity', 'orders.id as orderId')->join('products', 'products.id', '=', 'orders.product_id')->where(['user_id' => $id, "is_active_status" => $values])->get();
        } else {
            return Order::select('*', 'orders.name as orderName', 'products.qty as pQuantity', 'orders.qty as orderQuantity', 'orders.id as orderId')->join('products', 'products.id', '=', 'orders.product_id')->where(['user_id' => $id, "status" => $values])->get();
        }
    }
    public function getNoD($keys, $values)
    {
        if ($keys == "is_active_status") {
            $data = Order::where("is_active_status", $values)->count();
            return response()->json(array("status" => 200, "data" => $data, "Order By" => "Admin Approval"));
        } else {
            $data = Order::where("status", $values)->count();
            return response()->json(array("status" => 200, "data" => $data, "Counting Column" => $keys));
        }
    }

    public function change_process_status()
    {
        $type = request('action_type');
        $id = request('order_id');

        if ($type == 'Processing') {
            $order = Order::where('id', $id)->update(array('status' => 1));
        } elseif ($type == "Shipped") {
            $order = Order::where('id', $id)->update(array('status' => 2));
        } else {
            $order = Order::where('id', $id)->update(array('status' => 3));
        }
        return response()->json(array("status" => 200, "msg" => "SUCCESSFULLY APPROVED"), 200);
    }
}
