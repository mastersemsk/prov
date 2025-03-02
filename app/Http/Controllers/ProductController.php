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
     * Отобразить список продуктов.
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
    public function create(): View
    {

        return view('products.create', [
            'categories' => Category::all()
        ]);
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
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric'
        ]);

        Product::create($validated);
        return redirect(route('prod_list'));
    }

    /**
     * Отобразить указанный ресурс.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product,$id): View
    {
        return view('products.show', [
            'products' => $product->find($id)
        ]);
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
    public function update(Request $request, Product $product,$id): RedirectResponse
    {
        //проверка
        $validated = $request->validate([
            'category_id' => 'required|numeric',
            'prod_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'price' => 'required|numeric'
        ]);

        $product->where('id', $id)->update($validated);
        return redirect(route('prod_list'));
    }

    /**
     * Удалить продукт из хранилища.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product,$id): RedirectResponse
    {
        try {
            $product->destroy($id);
        }
        catch (\Exception $e) {
            die('Нельзя удалить, есть заказы. Сначала удалите заказ товара.');
        }
        
 
        return redirect(route('prod_list'));
    }
}
