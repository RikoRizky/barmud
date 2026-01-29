<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    /**
     * Tampilkan dashboard dengan list data (READ)
     */
    public function index()
    {
        $items = Item::latest()->paginate(10);
        return view('admin.dashboard', compact('items'));
    }

    /**
     * Form untuk create data baru
     */
    public function create()
    {
        return view('admin.create');
    }

    /**
     * Simpan data baru (CREATE)
     */
    public function store(Request $request)
    {
        // GANTI BAGIAN INI - Tambahkan validasi image
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Handle upload gambar
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('menu-images', 'public');
            $validated['image'] = $imagePath;
        }

        Item::create($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit (UPDATE)
     */
    public function edit(Item $item)
    {
        return view('admin.edit', compact('item'));
    }

    /**
     * Update data (UPDATE)
     */
    public function update(Request $request, Item $item)
    {
        // Tambahkan validasi image
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // TAMBAHAN
            'description' => 'nullable|string',
            'price' => 'required|numeric',
        ]);

        // Handle upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $imagePath = $request->file('image')->store('menu-images', 'public');
            $validated['image'] = $imagePath;
        }

        $item->update($validated);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil diupdate!');
    }

    /**
     * Hapus data (DELETE)
     */
    public function destroy(Item $item)
    {
        // Hapus gambar saat delete item
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();

        return redirect()->route('admin.dashboard')
            ->with('success', 'Menu berhasil dihapus!');
    }
}