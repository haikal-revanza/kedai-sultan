<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Menu;

class OrderController extends Controller
{
    public function showMenus()
    {
        // Ambil menu berdasarkan kategori
        $makanan = Menu::where('category', 'makanan')->get();
        $minuman = Menu::where('category', 'minuman')->get();
        $snack = Menu::where('category', 'snack')->get();

        return view('orders.menus', compact('makanan', 'minuman', 'snack'));
    }

    public function storeOrder(Request $request)
    {
        // Validasi data
        $request->validate([
            'orders' => 'required|array',
        ]);

        $orders = $request->orders;

        // Simpan pesanan ke session
        session(['orders' => $orders]);

        return redirect()->route('order.edit')->with('success', 'Pesanan berhasil disimpan!');
    }

    public function editOrder()
    {
        $orders = session('orders', []);

        if (empty($orders)) {
            return redirect()->route('menus.index')->with('error', 'Belum ada pesanan yang disimpan.');
        }

        // Ambil data menu berdasarkan ID pesanan
        $menus = Menu::whereIn('id', array_keys($orders))->get();

        // Total harga berdasarkan pesanan
        $totalPrice = 0;
        foreach ($menus as $menu) {
            $totalPrice += $menu->price * $orders[$menu->id];
        }

        return view('orders.edit', compact('orders', 'menus', 'totalPrice'));
    }

    public function updateOrder(Request $request)
    {
        // Validasi data pesanan
        $request->validate([
            'orders' => 'required|array',
        ]);

        $orders = array_filter($request->orders, fn($quantity) => $quantity > 0);

        // Perbarui pesanan di session
        session(['orders' => $orders]);

        return redirect()->route('order.edit')->with('success', 'Pesanan berhasil diperbarui!');
    }

    public function deleteOrderItem(Request $request)
    {
        $request->validate([
            'menu_id' => 'required|integer',
        ]);

        // Ambil pesanan dari session
        $orders = session('orders', []);

        // Hapus item berdasarkan ID menu
        unset($orders[$request->menu_id]);

        // Perbarui session
        session(['orders' => $orders]);

        return redirect()->route('order.edit')->with('success', 'Item berhasil dihapus!');
    }

}
