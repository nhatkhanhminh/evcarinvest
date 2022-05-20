
@php
$content = getContent('banner.content',true);
@endphp
@if($content)
    <section class="banner-section bg-overlay-primary bg_img" data-background="{{ getImage('assets/images/frontend/banner/'.$content->data_values->banner_image, '1950x600') }}">
        <div class="container">
            <div class="row justify-content-center align-items-center ml-b-30">
                <div class="col-lg-10 text-center mrb-30">
                    <div class="banner-content">
                        <h2 class="title">{{ __($content->data_values->heading) }}</h2>
                        <p>{{ __($content->data_values->paragraph) }}</p>
                        <div class="banner-btn justify-content-center">
                            <a href="{{ $content->data_values->button_one_link }}" class="cmn-btn py-3 px-5">{{ __($content->data_values->button_one) }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="particles-js"></div>
    </section>
@endif
