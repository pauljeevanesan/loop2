<div class="cart-total-price px-0 px-lg-4">
    <h2 class="text-20">{{ get_phrase('Payment summary') }}</h2>

    <h4 class="price_type sub_total mb-4">
        <span>{{ get_phrase('Sub total') }}</span>
        <span>{{ currency(number_format($sub_total, 2)) }}</span>
    </h4>

    @if ($coupon_discount > 0)
        <h4 class="price_type tax mb-4">
            <span>
                {{ get_phrase('Coupon Discount') }}
                ({{ $coupon_discount_percentage }}{{ get_phrase('%') }})
            </span>
            <span>- {{ currency(number_format($coupon_discount, 2)) }}</span>
        </h4>
    @endif

    @if ($points_discount > 0)
        <h4 class="price_type tax mb-4 text-success">
            <span>
                {{ get_phrase('Points Discount') }}
                ({{ $points_to_apply }} Points)
            </span>
            <span>- {{ currency(number_format($points_discount, 2)) }}</span>
        </h4>
    @endif

    <h4 class="price_type tax mb-4">
        <span>
            {{ get_phrase('Tax') }}
            ({{ get_settings('course_selling_tax') }}{{ get_phrase('%') }})
        </span>
        <span>+ {{ currency(number_format($tax, 2)) }}</span>
    </h4>

    <h4 class="price_type total mb-4">
        <span>{{ get_phrase('Total') }}</span>
        <span>{{ currency(number_format($total_payable, 2)) }}</span>
    </h4>

    {{-- Apply Points UI --}}
    <div class="input-group mb-3">
        <input type="number" class="form-control" wire:model.defer="points_to_apply" placeholder="Apply points (You have {{ auth()->user()->points }})">
        <button wire:click="applyPoints" class="input-group-text eBtn gradient text-white">
            Apply
        </button>
    </div>


    <form action="{{ route('payout') }}" method="post" class="mt-20">@csrf
        <input type="hidden" name="payable" value="{{ $total_payable }}">
        <input type="hidden" name="coupon_code" value="{{ request()->query('coupon') }}">
        <input type="hidden" name="coupon_discount" value="{{ $coupon_discount }}">
        <input type="hidden" name="points_discount" value="{{ $points_discount }}">
        <input type="hidden" name="points_used" value="{{ $points_to_apply }}">
        <input type="hidden" name="tax" value="{{ $tax }}">
        <input type="hidden" name="items" value="{{ json_encode($cart_items->pluck('id')) }}">

        <div class="mt-20">
            <div class="row">
                <div class="col-md-12">
                    @if (request()->has('coupon') && isset($coupon) && $coupon_discount > 0)
                        <div class="alert w-100 alert-purple show d-flex align-items-center py-2">
                            <div>
                                {{ get_phrase('Coupon') }} <strong>{{ get_phrase('Applyed') }} ({{ $coupon_discount_percentage }}%) !</strong>
                            </div>
                            <a href="{{ route('cart') }}" type="button" class="btn ms-auto mt-2"><i class="fi-rr-cross-circle text-14px"></i></a>
                        </div>
                    @endif
                </div>
            </div>
            <div class="row g-1">
                <div class="col-md-12">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="coupon" placeholder="{{ get_phrase('Apply coupon') }}" value="{{ request()->query('coupon') }}">
                        <button type="button" value="{{ get_phrase('Apply') }}" class="input-group-text eBtn gradient text-white" id="apply-coupon">
                            {{ get_phrase('Apply') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-20 send_gift_check">
            <div class="form-check">
                <input class="form-check-input mt-0" type="checkbox" name="is_gift" value="1" id="send_gift">
                <label class="form-check-label" for="send_gift">{{ get_phrase('Send as a gift') }}</label>
            </div>

            <input type="email" class="form-control mt-15 gifted_user d-none" name="" placeholder="{{ get_phrase('Enter user email') }}">
        </div>

        <div class="mt-20">
            <input type="submit" class="form-control eBtn gradient text-white" value="{{ get_phrase('Continue to payment') }}" @if ($sub_total == 0) disabled @endif>
        </div>
    </form>
</div>
