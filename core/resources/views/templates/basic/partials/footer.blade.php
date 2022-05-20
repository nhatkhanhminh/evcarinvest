@php
    $footerCaption = getContent('footer.content', true);
@endphp

<footer class="footer-section ptb-80">
    <div class="container">
        <div class="footer-area">
            <div class="row ml-b-30">
                <div class="col-lg-4 col-sm-6 mrb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">{{ __($footerCaption->data_values->heading) }}</h3>
                        <p>{{ __($footerCaption->data_values->short_details) }}</p>

                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mrb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Quick Links')</h3>
                        <ul class="footer-list">
                            @if($pages->count() > 0)
                                @foreach ($pages as $item)
                                    <li><a href="{{route('pages', ['slug'=> $item->slug ])}}">@lang($item->name)</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-sm-6 mrb-30">
                    <div class="footer-widget">
                        <h3 class="widget-title">@lang('Useful Links')</h3>
                        <ul class="footer-list">
                            @php
                                $links = getContent('links.element');
                            @endphp
                            @if($links->count() > 0)
                                @foreach ($links as $item)
                                <li><a href="{{route('links', slug($item->data_values->title).'-'.$item->id)}}">{{ html_entity_decode ($item->data_values->title) }}</a></li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6 mrb-30">
                    <div class="footer-widget widget-menu">
                        <h3 class="widget-title">@lang('Contact Info')</h3>
                        <ul class="footer-list">
                            <li>@lang('Call Us Now') {{ @$contactCaption->data_values->contact_number }}</li>
                            <li>{{ @$contactCaption->data_values->email_address }}</li>
                            <li>{{ @$contactCaption->data_values->contact_details }}</li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-12">
                    @php
                    $socials = getContent('social_icon.element');
                    @endphp
                    @if($socials->count() > 0)
                    <div class="social-area d-flex justify-content-center">
                        <ul class="footer-social">
                            @foreach($socials as $item)
                                <li><a href="{{$item->data_values->url}}" >@php echo $item->data_values->social_icon @endphp</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</footer>
<div class="privacy-area privacy-area--style">
    <div class="container">
        <div class="copyright-area d-flex flex-wrap align-items-center justify-content-center">
            <div class="copyright">
                <p>{{ __($footerCaption->data_values->copyright_text) }}</p>
            </div>
        </div>
    </div>
</div>

