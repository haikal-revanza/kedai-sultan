<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Menu;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // Tampilkan daftar menu
    public function index()
    {
        $menus = Menu::all();
        return view('admin.menus.index', compact('menus'));
    }

    // Form tambah menu
    public function create()
    {
        return view('admin.menus.create');
    }

    // Simpan menu baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|in:makanan,minuman,snack',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = $request->file('image')->store('menus', 'public');
        }

        Menu::create($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    // Form edit menu
    public function edit(Menu $menu)
    {
        return view('admin.menus.edit', compact('menu'));
    }

    // Update menu
    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category' => 'required|string|in:makanan,minuman,snack',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($menu->image_url) {
                Storage::disk('public')->delete($menu->image_url);
            }
            $validated['image_url'] = $request->file('image')->store('menus', 'public');
        }

        $menu->update($validated);
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    // Hapus menu
    public function destroy(Menu $menu)
    {
        if ($menu->image_url) {
            Storage::disk('public')->delete($menu->image_url);
        }
        $menu->delete();
        return redirect()->route('admin.menus.index')->with('success', 'Menu berhasil dihapus.');
    }

    // Download gambar menu
    public function downloadImage(Menu $menu)
    {
        if ($menu->image_url) {
            return Storage::disk('public')->download($menu->image_url);
        }
        return back()->withErrors(['image' => 'Gambar tidak ditemukan.']);
    }
}
