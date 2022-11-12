<?php

namespace App\Http\Controllers;

use App\Helpers\ExtensionHelper;
use App\Models\{Orders, Products, User, Invoices, Extensions, Statistics};
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $products = session('cart');
        $total = 0;

        if ($products) {
            foreach ($products as $product) {
                $total += $product->price * $product->quantity;
            }
        }
        return view('checkout.index', compact('products', 'total'));
    }

    public function success()
    {
        return view('checkout.success');
    }

    public function cancel()
    {
        return view('checkout.cancel');
    }

    public function add(Request $request)
    {

        $product = json_decode(Products::find($request->id)->toJson());
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found');
        }
        // Get extension config
        if (isset($product->server_id)) {
            $server = Extensions::find($product->server_id);
            $extension = json_decode(file_get_contents(base_path('app/Extensions/Servers/' . $server->name . '/extension.json')));

            if (isset($extension->userConfig)) {
                return redirect()->route('checkout.config', $product->id);
            }
        }
        $product->quantity = 1;
        $cart = session()->get('cart');
        if (\Illuminate\Support\Arr::has($cart, $product->id)) {
            $cart[$product->id]->quantity++;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        } else {
            $cart[$product->id] = $product;
            session()->put('cart', $cart);
            return redirect()->back()->with('success', 'Product added to cart successfully!');
        }
    }

    public function config(Request $request, Products $id)
    {
        $product = $id;
        $server = Extensions::find($product->server_id);
        include_once(base_path('app/Extensions/Servers/' . $server->name . '/index.php'));
        $function = $server->name . '_getUserConfig';
        $userConfig = json_decode(json_encode($function($product)));
        if (!isset($userConfig)) {
            return redirect()->route('checkout.index');
        }
        return view('checkout.config', compact('product', 'userConfig'));
    }

    public function configPost(Request $request, Products $id)
    {
        $product = $id;
        $server = Extensions::find($product->server_id);
        $extension = json_decode(file_get_contents(base_path('app/Extensions/Servers/' . $server->name . '/extension.json')));
        $config = [];
        foreach ($extension->userConfig as $configItem) {
            $config[$configItem->name] = $request->input($configItem->name);
        }
        $product->config = $config;
        $product->quantity = 1;
        $cart = session()->get('cart');
        if (\Illuminate\Support\Arr::has($cart, $product->id)) {
            $cart[$product->id]->quantity++;
            session()->put('cart', $cart);
            return redirect()->route('checkout.index')->with('success', 'Product added to cart successfully!');
        } else {
            $cart[$product->id] = $product;
            session()->put('cart', $cart);
            return redirect()->route('checkout.index')->with('success', 'Product added to cart successfully!');
        }
    }

    public function pay(Request $request)
    {
        $products = session('cart');
        if (!$products) {
            return redirect()->back()->with('error', 'Cart is empty');
        }
        $total = 0;
        if (!$products) {
            return redirect()->back()->with('error', 'No products in cart');
        }
        if ($products) {
            foreach ($products as $product) {
                $total += $product->price * $product->quantity;
            }
        }
        $productsids = array();
        foreach ($products as $product) {
            $productJson = [
                'id' => $product->id,
                'quantity' => $product->quantity,
            ];
            if (isset($product->config)) {
                $productJson['config'] = $product->config;
            }
            array_push($productsids, $productJson);
        }
        $user = User::find(auth()->user()->id);
        $order = new Orders();
        $order->client = $user->id;
        $order->total = $total;
        $order->products = $productsids;
        $order->expiry_date = date('Y-m-d H:i:s', strtotime('+1 month'));
        if ($total == 0) {
            $order->status = 'paid';
            ExtensionHelper::createServer($order);
        } else {
            $order->status = 'pending';
        }
        $order->save();

        $invoice = new Invoices();
        $invoice->user_id = $user->id;
        $invoice->order_id = $order->id;
        if ($total == 0) {
            $invoice->status = 'paid';
        } else {
            $invoice->status = 'pending';
        }
        $invoice->save();

        session()->forget('cart');
        return redirect()->route('invoice.show', ['id' => $invoice->id]);
    }

    public function remove(Request $request, $id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product removed successfully');
    }

    /*
    * Update product quantity in cart
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|numeric|min:1'
        ]);
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            $cart[$id]->quantity = $request->quantity;
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Product updated successfully');
    }
}
