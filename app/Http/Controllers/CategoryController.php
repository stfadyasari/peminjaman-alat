<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('devices')->latest()->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'description' => trim((string) $request->input('description')),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'description' => ['nullable', 'string'],
        ]);
        $category = Category::create($data);

        ActivityLogger::log('category.create', 'Menambahkan kategori #'.$category->id.' ('.$category->name.')');
        return back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function show(Category $category)
    {
        $category->load('devices');

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $category->loadCount('devices');

        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->merge([
            'name' => trim((string) $request->input('name')),
            'description' => trim((string) $request->input('description')),
        ]);

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'description' => ['nullable', 'string'],
        ]);
        $category->update($data);
        ActivityLogger::log('category.update', 'Mengubah kategori #'.$category->id.' ('.$category->name.')');
        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui.');
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
