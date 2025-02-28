<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        //список продуктов
        return view('products.list', [
            'products' => Product::with('category')->get()
        ]);
    }

    /**
     * Показать форму создания нового продукта.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): RedirectResponse
    {
        return redirect('/products/list');
    }

    /**
     * Сохранить созданный продукт в хранилище.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        //проверка
        $validated = $request->validate([
            'category_id' => 'required|numeric',
            'prod_name' => 'required|string|max:255',
            'description' => 'nullable|max:255',
            'price' => 'required|numeric'
        ]);

        Product::create($validated);
        return redirect('/products/list');
    }

    /**
     * Отобразить указанный ресурс.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product): View
    {
        //
    }

    /**
     * Показать форму редактирования продукта.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product,$id): View
    {
        $products = $product->find($id);
        $categories = Category::all();
        return view('products.edit', [
            'products' => $products,'categories' => $categories
        ]);
        
    }

    /**
     * Обновить продукт в хранилище.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product): RedirectResponse
    {
        return redirect('/products/list');
    }

    /**
     * Удалить продукт из хранилища.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,$id): RedirectResponse
    {
        
        $product->destroy($id);
 
        return redirect('/products/list');
    }
}
