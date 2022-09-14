<div class="tab-pane active" id="basic_info">
  {{-- hidden --}}
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $biller->getKey() }}">
  {{-- end hidden --}}
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>@lang('Field')</th>
                <th>@lang('Value')</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>@lang('ID')</td>
                <td>{{ $biller->getKey() }}</td>
            </tr>
            <tr>
                <td>@lang('Name') *</td>
                <td><input type="text" id="name" class="form-control" name="name" placeholder="{{ __('Biller Name') }}" value="{{ $biller->name }}"></td>
            </tr>
            <tr>
                <td>@lang('Logo') *</td>
                <td><input type="text" id="logo" class="form-control" name="logo" placeholder="{{ __('Biller Logo') }}" value="{{ $biller->logo }}"></td>
            </tr>
            <tr>
                <td>@lang('adminUrl')</td>
                <td><input type="text" id="adminurl" class="form-control" name="adminurl" placeholder="{{ __('Biller admin URL') }}" value="{{ $biller->adminurl }}"></td>
            </tr>
            <tr>
                <td>@lang('apiUrl')</td>
                <td><input type="text" id="apiurl" class="form-control" name="apiurl" placeholder="{{ __('Biller api URL') }}" value="{{ $biller->apiurl }}"></td>
            </tr>
            <tr>
                <td>@lang('supported cards')</td>
                <td><input type="text" id="supported" class="form-control" name="supported" placeholder="{{ __('Supported Cards') }}" value="{{ $biller->supported }}"></td>
            </tr>
            <tr>
                <td>@lang('apiUser')</td>
                <td><input type="text" id="apiuser" class="form-control" name="apiuser" placeholder="{{ __('Biller api user') }}" value="{{ $biller->apiuser }}"></td>
            </tr>
            <tr>
                <td>@lang('apiPass')</td>
                <td><input type="text" id="apipass" class="form-control" name="apipass" placeholder="{{ __('Biller api password') }}" value="{{ $biller->apipass }}"></td>
            </tr>
            <tr>
                <td>@lang('apiKey1')</td>
                <td><input type="text" id="apikey1" class="form-control" name="apikey1" placeholder="{{ __('Biller api key 1') }}" value="{{ $biller->apikey1 }}"></td>
            </tr>
            <tr>
                <td>@lang('apiKey2')</td>
                <td><input type="text" id="apikey2" class="form-control" name="apikey2" placeholder="{{ __('Biller api key 2') }}" value="{{ $biller->apikey2 }}"></td>
            </tr>
            <tr>
                <td>@lang('biller note')</td>
                <td><textarea type="text" id="billnote" class="form-control" name="billnote" placeholder="{{ __('Biller api note') }}">{{ $biller->billnote }}</textarea></td>
            </tr>
            <tr>
                <td>@lang('rank') *</td>
                <td><input type="text" id="rank" class="form-control" name="rank" placeholder="{{ __('Biller rank') }}" value="{{ $biller->rank }}"></td>
            </tr>
            <tr>
                <td>@lang('Active Status')</td>
                <td>
                  <select class="form-control" name="is_active" id="is_active">
                    <option value="1" @if ($biller->is_active) selected @endif>Active</option>
                    <option value="0" @if (!$biller->is_active) selected @endif>Not Active</option>
                  </select>
                </td>
            </tr>
        </tbody>
    </table>
  </form>
</div>
