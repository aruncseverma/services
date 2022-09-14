<div class="card col-lg-12">
    <div class="card-header" data-toggle="collapse" data-target="#site_news">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('VIP Membership Plans')</span>
    </div>
    <div class="card-body collapse show" id="site_news">
        <div class="table-responsive">
            <table class="table">
                <tbody>
                    <tr>
                        <th></th>
                        <th>VIP Plan</th>
                        <th>Total Price</th>
                        <th>Monthly Price</th>
                        <th>Total Savings</th>
                    </tr>
                    @forelse($plans as $plan)
                        @php
                            if ($plan->month <= 1) {
                                $text = "{$plan->months} MONTH VIP Pass *";
                            } else {
                                $text = "{$plan->months} MONTHS VIP Pass *";
                            }

                            $discount = ($plan->discount > 0) ? "save {$plan->currency->name} {$plan->discount}" : "";
                        @endphp
                        <tr>
                            <td><input type="radio" name="plan_id" value="{{ $plan->id}}" data-duration="{{ $plan->months }}" data-price="{{ $plan->total_price}}" data-currency="{{ $plan->currency->name}}"></td>
                            <td><h3>{{ $text }}</h3><small></small></td>
                            <td>{{ $plan->currency->name }} {{ $plan->total_price }}</td>
                            <td>{{ $plan->currency->name }} {{ $plan->price_per_month }} / month</td>
                            <td><span class="text-danger">{{ $discount }}</span></td>
                        </tr>
                    @empty
                        @include('EscortAdmin::common.table.no_results', ['colspan' => 2])
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
