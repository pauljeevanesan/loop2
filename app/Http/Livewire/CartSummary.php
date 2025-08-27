<?php

namespace App\Http\Livewire;

use App\Models\GamificationSetting;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CartSummary extends Component
{
    public $cart_items;
    public $coupon_discount_percentage;
    public $points_to_apply = 0;
    public $points_discount = 0;

    public $sub_total = 0;
    public $coupon_discount = 0;
    public $tax = 0;
    public $total_payable = 0;

    public function mount($cart_items, $discount)
    {
        $this->cart_items = $cart_items;
        $this->coupon_discount_percentage = $discount;
        $this->calculateTotals();
    }

    public function applyPoints()
    {
        $this->calculateTotals(); // Recalculate to ensure everything is fresh
    }

    public function calculateTotals()
    {
        // 1. Calculate subtotal
        $this->sub_total = 0;
        foreach ($this->cart_items as $item) {
            $this->sub_total += $item->discount_flag == 1 ? $item->discounted_price : $item->price;
        }

        // 2. Calculate coupon discount
        $this->coupon_discount = $this->sub_total * ($this->coupon_discount_percentage / 100);
        $price_after_coupon = $this->sub_total - $this->coupon_discount;

        // 3. Calculate points discount
        $points_to_usd_rate = GamificationSetting::where('action_name', 'points_to_currency_rate')->value('points');
        if ($points_to_usd_rate > 0) {
            $max_points_for_cart = $price_after_coupon * $points_to_usd_rate;
            $user_points = Auth::user()->points;

            // Validate points to apply
            $this->points_to_apply = min($this->points_to_apply, $user_points, $max_points_for_cart);
            $this->points_to_apply = max(0, $this->points_to_apply); // Ensure not negative

            $this->points_discount = $this->points_to_apply / $points_to_usd_rate;
        }

        // 4. Calculate Tax
        $price_after_points = $price_after_coupon - $this->points_discount;
        $tax_rate = get_settings('course_selling_tax') ?? 0;
        $this->tax = ($tax_rate / 100) * $price_after_points;

        // 5. Calculate final total
        $this->total_payable = $price_after_points + $this->tax;
    }

    public function render()
    {
        return view('livewire.cart-summary');
    }
}
