
@php
$content = getContent('subscribe.content',true);
@endphp
@if($content)
    <section class="subscribe-section call-to-action-section pd-t-60 pd-b-60">
        <div class="container">
            <div class="call-to-action-area">
                <div class="row justify-content-center align-items-center">
                    <div class="col-lg-8 text-center">
                        <div class="call-to-action-content">
                            <h2 class="title">{{ __($content->data_values->heading) }}</h2>
                            <form class="call-to-action-form">
                                <div class="row justify-content-center">
                                    <div class="col-lg-12">
                                        <input type="email" name="email" placeholder="@lang('Your Email Adress')">
                                        <button type="button" class="submit-btn subscribe-btn w-auto mt-0"><i class="fas fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif


@push('script')
    <script>
        'use strict';
        (function($){
            //ADD TO CART
        $(document).on('click','.subscribe-btn' , function(){
            var email    = $('input[name="email"]').val();

            $.ajax({
                headers: {"X-CSRF-TOKEN": "{{ csrf_token() }}",},
                url:"{{ route('subscribe') }}",
                method:"POST",
                data:{email:email},
                success:function(response)
                {
                    console.log(response);
                    if(response.success) {
                        notify('success', response.success);
                    }else{
                        notify('error', response);
                    }
                }
            });

        });
        })(jQuery)
    </script>
@endpush
