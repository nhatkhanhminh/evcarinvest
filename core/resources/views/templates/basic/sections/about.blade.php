@php
    $content    = getContent('about.content',true);
    $elements   = getContent('about.element');
@endphp
@if($content)
    <section class="about-section ptb-120">
        <div class="container">
            <div class="row justify-content-center ml-b-30">
                <div class="col-lg-6 mrb-30">
                    <div class="about-thumb">
                        <img src="{{ getImage('assets/images/frontend/about/'.$content->data_values->about_image, '409x535') }}" alt="about">
                    </div>
                </div>
                <div class="col-lg-6 mrb-30">
                    <div class="about-content">
                        <h2 class="title">{{ __($content->data_values->heading) }}</h2>
                        <span class="title-border"></span>
                        <p>{{ __($content->data_values->paragraph) }}</p>
                        <div class="about-item-area ml-b-30">
                            @foreach ($elements as $item)
                                <div class="about-item d-flex flex-wrap align-items-center mrb-30">
                                    <div class="about-icon">
                                        @php echo $item->data_values->icon @endphp
                                    </div>
                                    <div class="about-details">
                                        <h3 class="title">{{ __($item->data_values->title) }}</h3>
                                        <p>{{ __($item->data_values->description) }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

