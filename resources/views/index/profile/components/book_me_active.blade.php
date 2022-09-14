<!-- book me active -->
<div class="col-xs-20 panel-bookmeactive collapse" id="bookme_collapse">
    
        <div class="panel panel-primary"> 
            <div class="panel-heading widget_header widget_accordian_title"> 
                <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
                <h3 class="panel-title">Book Me</h3> 
            </div>
            <div class="panel-body widget_accordian_content">
                <div class="row">
                <form action="{{ route('index.profile.add_booking') }}" method="POST" class="default_form es es-validation es-ajax" id="book_me_form">
                @csrf
                    <input type="hidden" name="id" value="{{ $user->id ?? '' }}">
                    <div class="col-md-10 col-lg-10 col-lg-push-5 ">
                        <div class="row">
                            <div class="col-lg-10">                         
                                <label for="firstname" class="es-required" style="display:none;">Firstname</label>
                                <input class="input_field" placeholder="First Name" id="firstname" name="firstname" value="{{ old('firstname') }}"> 
                                @include('Index::common.form.error', ['key' => 'firstname'])
                            </div>
                            <div class="col-lg-10">                         
                                <label for="lastname" class="es-required" style="display:none;">Lastname</label>
                                <input class="input_field" placeholder="Last Name" id="lastname" name="lastname" value="{{ old('lastname')}}"> 
                                @include('Index::common.form.error', ['key' => 'lastname'])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-10">                         
                                <label for="phone" class="es-required" style="display:none;">Phone</label>
                                <input class="input_field" placeholder="Phone" id="phone" name="phone" value="{{ old('phone') }}"> 
                                @include('Index::common.form.error', ['key' => 'phone'])
                            </div>
                            <div class="col-lg-10">                         
                                <label for="email" class="es-required es-email" style="display:none;">Email</label>
                                <input class="input_field" placeholder="Email" id="email" name="email" value="{{ old('email') }}"> 
                                @include('Index::common.form.error', ['key' => 'email'])
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-20">
                                <label for="message" class="es-required" style="display:none;">Message</label>
                                <textarea class="form-control" rows="3" style="resize: none;" placeholder="Message" id="message" name="message">{{ old('message') }}</textarea>
                                @include('Index::common.form.error', ['key' => 'message'])
                            </div>
                        
                        </div>
                    </div>
                    <div class="col-md-10 col-lg-5 col-lg-push-5 bookmeactive-texts">
                        @if ($user->phone)
                            Call {{ $user->name ?? 'me' }} at<br />
                            <span style="font-size: 24px; font-weight: 600; margin-bottom: 24px; display: block">{{ $user->phone ?? '' }}</span>
                        @endif
                        <a style="margin-bottom: 12px; display: block" class="cancel-butt" href="#bookme_collapse" role="button" aria-expanded="true" aria-controls="bookme_collapse" data-toggle="collapse"><input type="reset" value="CANCEL" class="general-button" style="width: 100%;"></a>
                        <a style="margin-bottom: 12px; display: block"><input type="submit" value="SUBMIT" class="general-button" style="width: 100%;" id="book_me_submit"></a>
                    </div>
                </form>
                </div>
            </div>
        </div> 
</div>
