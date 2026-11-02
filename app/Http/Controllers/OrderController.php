<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderConclusion;
use App\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /*
     * Список заявок
     */
    public function index()
    {
        $orders = Order::orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.index', [
            'orders' => $orders,
        ]);
    }


    /*
     * Новая
     */
    public function create()
    {
        $users = User::orderBy('name', 'asc')
            ->get();

        return view('admin.orders.create', [
            'users' => $users,
        ]);
    }


    /*
     * Сохранение
     */
    public function store(Request $request)
    {
        $order = Order::create($request->all());

        return redirect()
            ->to(route('orders.index'))
            ->with('success', 'Заявка успешно создана');
    }


    /*
     * Редактирование
     */
    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $users = User::orderBy('name', 'asc')
            ->get();

        return view('admin.orders.edit', [
            'order' => $order,
            'users' => $users,
        ]);
    }


    /*
     * Сохранение изменений
     */
    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->all());

        return redirect()
            ->to(route('orders.index'))
            ->with('success', 'Изменения успешно сохранены');
    }


    /*
     * Удаление заявки
     */
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()
            ->to(route('orders.index'))
            ->with('success', 'Заявка успешно удалена');
    }


    /*
     * Список заключений в заявке
     */
    public function list_conclusions($order_id)
    {
        $order = Order::findOrFail($order_id);
        $conclusions = OrderConclusion::where('order_id', $order->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.orders.list_conclusions', [
            'order' => $order,
            'conclusions' => $conclusions,
        ]);
    }


    /*
     * Обновление информации заявки
     */
    public function update_info(Request $request):void
    {
        $order_id = (int) $request->order_id;
        $order = Order::findOrFail($order_id);
        $order->update([
            'status' => $request->status,
            'comment' => $request->comment,
        ]);
    }


    /*
     * Прикрепление архива
     */
    public function archive(Request $request, $id)
    {
        $path = 'uploads/orders/'.$id.'/';
        $fullpath = public_path($path);
        $filename = 'archive.zip';
        @mkdir($fullpath);
        if(file_exists($fullpath.$filename))
            @unlink($fullpath.$filename);

        $file = $request->file('archive');
        $file->move($fullpath, $filename);

        return redirect()
            ->to(route('orders.index'));
    }
}
