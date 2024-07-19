<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public $data = array('message' => '', 'data' => [], 'code' => 200);
    public $code = 200;

    public function list(Request $request){
        $data = Product::orderBy('id')->get();

        $this->data['data'] = $data;
        
        return response()->json($this->data, $this->code);
    }

    public function create(Request $request){
        $validated = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        $input = $request->all();

        $product = Product::create($input);

        if($product){
            $this->data['message'] = 'Product created successfully';
            $this->data['data'] = $product;
        }else{
            $this->data['message'] = 'Product created failed';
            $this->data['code'] = 400;
            $this->code = 400;
        }
        
        return response()->json($this->data, $this->code);
    }

    public function update(Request $request){
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
            'description' => 'required',
            'price' => 'required',
        ]);

        $input = $request->except('id');

        $update = tap(Product::find($request->id))->update($input);

        if($update){
            $this->data['message'] = 'Product updated successfully';
            $this->data['data'] = $update;
        }else{
            $this->data['message'] = 'Product updated failed';
            $this->data['code'] = 400;
            $this->code = 400;
        }
        
        return response()->json($this->data, $this->code);
    }

    
    public function delete(Request $request){
        $validated = $request->validate([
            'id' => 'required',
        ]);

        $delete = Product::find($request->id)->delete();

        if($delete){
            $this->data['message'] = 'Product deleted successfully';
            $this->data['data'] = $delete;
        }else{
            $this->data['message'] = 'Product deleted failed';
            $this->data['code'] = 400;
            $this->code = 400;
        }
        
        return response()->json($this->data, $this->code);
    }
}
