<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function view_product(){
        $products = Product::all();
        $categories = Category::all();
        return view('dashboard/product', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function action_addProduct(Request $request){
        try {
            $validated = $request->validate([
                'nama' => 'required|min:5|max:100',
                'hargabeli' => 'required|numeric',
                'hargajual' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'file' => 'required|image|mimes:jpg,png|max:100'
            ]);

            $filePath = null;
            if ($request->hasFile('file') && $request->file('file')->isValid()) {
                $filePath = $request->file('file')->store('thumbnail', 'public');
            } else {
                throw new \Exception("Invalid file upload.");
            }

            DB::insert('
                INSERT INTO products (nama, hargabeli, hargajual, category_id, image) 
                VALUES (:nama, :hargabeli, :hargajual, :category_id, :image)', 
                [
                    'nama' => $validated['nama'],
                    'hargabeli' => $validated['hargabeli'],
                    'hargajual' => $validated['hargajual'],
                    'category_id' => $validated['category_id'],
                    'image' => $filePath
                ]
            );

            session()->flash('success', 'Product added successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator)->withInput();
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to add product. Please try again later.');
            return redirect()->back()->withInput();
        }

        return redirect('/product');
    }

    public function action_editProduct(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'nama' => 'required|min:5|max:100',
                'hargabeli' => 'required|numeric',
                'hargajual' => 'required|numeric',
                'category_id' => 'required|exists:categories,id',
                'file' => 'image|mimes:jpg,png|max:100'
            ]);

            $product = DB::table('products')->where('id', $id)->first();

            if (!$product) {
                session()->flash('error', 'Product not found!');
                return redirect('/product');
            }

            $filePath = $product->image; 
            if ($request->hasFile('file')) {
                if (!empty($product->image)) {
                    Storage::disk('public')->delete($product->image);
                }

                $filePath = $request->file('file')->store('thumbnail', 'public');
            }

            DB::update('
                UPDATE products 
                SET nama = :nama, hargabeli = :hargabeli, hargajual = :hargajual, category_id = :category_id, image = :image 
                WHERE id = :id',
                [
                    'nama' => $validated['nama'],
                    'hargabeli' => $validated['hargabeli'],
                    'hargajual' => $validated['hargajual'],
                    'category_id' => $validated['category_id'],
                    'image' => $filePath,
                    'id' => $id
                ]
            );

            session()->flash('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to update product. Please try again later.');
        }

        return redirect('/product');
    }

    public function action_destroy($id){
        try {
            $product = DB::table('products')->where('id', $id)->first();

            if (!$product) {
                session()->flash('error', 'Product not found!');
                return redirect('/product');
            }

            if (!empty($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            DB::delete('DELETE FROM products WHERE id = :id', ['id' => $id]);

            session()->flash('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Internal server error');
        }
        return redirect('/product');
    }
}
