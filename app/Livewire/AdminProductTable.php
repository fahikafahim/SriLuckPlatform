<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class AdminProductTable extends Component
{
    public function render()
    {
        $products = Product::latest()->take(3)->get(); 

        return view('livewire.admin-product-table', [
            'products' => $products
        ]);
    }
}
