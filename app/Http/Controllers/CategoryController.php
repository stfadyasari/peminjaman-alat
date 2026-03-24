<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Support\ActivityLogger;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate(['name'=>'required']);
        $category = Category::create($request->only('name'));
        ActivityLogger::log('category.create', 'Menambahkan kategori #'.$category->id.' ('.$category->name.')');
        return back();
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
