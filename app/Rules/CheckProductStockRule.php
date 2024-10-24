<?php

namespace App\Rules;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckProductStockRule implements ValidationRule
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request  = $request;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        collect($this->request->all()['products'])->filter(function ($product) use (&$fail) {
            $stockAvailable = Product::find($product['id']);
            if ($stockAvailable->stock_quantity < $product['quantity']) {
                $fail("Product does not have sufficient stock.");
            }
        });
    }
}
