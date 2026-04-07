<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private const PRESET_CATEGORIES = [
        'Laptop',
        'Monitor',
        'Keyboard',
        'Mouse',
        'Printer',
        'Proyektor',
        'Scanner',
        'Webcam',
        'Speaker',
        'Microphone',
        'Router',
        'Tablet',
    ];

    public function index()
    {
        $categories = Category::all();
        $presetCategories = collect(self::PRESET_CATEGORIES)
            ->reject(fn ($name) => Category::where('name', $name)->exists())
            ->values();

        return view('admin.categories.index', compact('categories', 'presetCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'in:' . implode(',', self::PRESET_CATEGORIES)],
        ]);

        $category = Category::firstOrCreate([
            'name' => $request->name,
        ]);

        if (! $category->wasRecentlyCreated) {
            return back()->with('success', 'Kategori sudah tersedia, silakan pilih kategori lain.');
        }

        ActivityLogger::log('category.create', 'Menambahkan kategori #'.$category->id.' ('.$category->name.')');
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name'=>'required']);
        $category->update($request->only('name'));
        ActivityLogger::log('category.update', 'Mengubah kategori #'.$category->id.' ('.$category->name.')');
        return back();
    }

    public function destroy(Category $category)
    {
        $categoryId = $category->id;
        $categoryName = $category->name;
        $category->delete();
        ActivityLogger::log('category.delete', 'Menghapus kategori #'.$categoryId.' ('.$categoryName.')');
        return back();
    }
}
