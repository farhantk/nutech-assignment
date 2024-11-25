<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function view_category(){
        $categories = Category::all();
        return view('dashboard/category', [
            'categories' => $categories
        ]);
    }

    public function action_addCategory(Request $request){
        $validated = $request->validate([
            'name' => 'required'
        ]);

        try {
            DB::insert('insert into categories (name) values (:name)', [
                'name' => $validated['name']
            ]);

            $request->session()->flash('success', 'Category added successfully!');
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Internal server error');
        }

        return redirect('/category');
    }

    public function action_edit(Request $request, $id){
        $validated = $request->validate([
            'name' => 'required',
        ]);

        try {
            $category = DB::table('categories')
                ->where('id', $id)
                ->update(['name' => $validated['name']]);

            if ($category) {
                $request->session()->flash('success', 'Update category successful!');
            } else {
                $request->session()->flash('error', 'Category not found or no changes made');
            }
        } catch (\Exception $e) {
            $request->session()->flash('error', 'Internal server error');
        }

        return redirect('/category');
    }

    public function action_destroy($id)
    {
        try {
            $category = DB::table('categories')->where('id', $id)->first();

            if (!$category) {
                session()->flash('error', 'Category not found!');
                return redirect('/category');
            }

            DB::table('categories')->where('id', $id)->delete();

            session()->flash('success', 'Category deleted successfully!');
        } catch (\Exception $e) {
            session()->flash('error', 'Internal server error');
        }

        return redirect('/category');
    }
}
