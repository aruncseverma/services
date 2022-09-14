<div class="table-responsive">
  <table id="Packages" class="table table-striped table-hover creditpackages">
    <tbody>
        @foreach($packages as $package)
          <tr id={{$package->id}}>
            <td class="">{{$package->credits}} <span class="mini">Credit</span></td>
            <td>
              @if ($package->discount > 0)
                <span><s>{{$package->currency->symbol_left}}{{$package->price / (100-$package->discount) * 100}}{{$package->currency->symbol_right}}</s></span>
                <span class="mini text-success">-{{$package->discount}}% off</span>
              @endif
            </td>
            <td class="pull-right"><span class="mini">{{$package->currency->symbol_left}}</span>{{$package->price}}<span class="mini">{{$package->currency->symbol_right}}</span></td>
          </tr>
        @endforeach
    </tbody>
  </table>
</div>
  <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save" onclick="payNow(selectedPackage);">PAY NOW</button>
</div>

<style>
  .table-hover > tbody > tr:hover {
    background-color: #CFF5FF;
}
</style>