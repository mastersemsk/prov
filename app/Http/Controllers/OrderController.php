<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class OrderController extends Controller
{
    /**
     * Отобразить список заказов.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        return view('orders.list', [
            'orders' => Order::with('product')->get()
        ]);
    }

    /**
     * Показать форму создания нового заказа.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id): View
    {
        return view('orders.create', [
            'products' => Product::find($id)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        //проверка
        $validated = $request->validate([
            'product_id' => 'required|numeric',
            'fio' => 'required|string|max:255',
            'comment' => 'nullable|string|max:255',
            'price' => 'required|numeric',
            'count' => 'required|numeric'
        ]);
        $validated['final_price'] = round(($validated['price'] * $validated['count']),2);
        unset($validated['price'],$validated['count']);

        Order::create($validated);
        return redirect(route('order_list'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order,$id): View
    {
        return view('orders.show', [
            'order' => $order->find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order): RedirectResponse
    {
        //проверка
        $validated = $request->validate([
            'id' => 'required|numeric',
            'status' => 'required|string',
        ]);

        $order->where('id', $validated['id'])->update(['status' => $validated['status']]);
        return redirect(route('order_show', $validated['id']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order,$id): RedirectResponse
    {
        $order->destroy($id);
 
        return redirect(route('order_list'));
    }

    private function switch_status($status): string
    {
        switch($status) {
            case 'new': 
                $new_status = 'Новый';
            break;
            case 'done':
                $new_status = 'Выполнен';
            break;
            default: $new_status = 'нет такого заказа'; break;
        }
        return $new_status;
    }
}
