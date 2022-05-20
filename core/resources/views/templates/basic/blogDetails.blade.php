@extends($activeTemplate.'layouts.master')
@section('content')

<!-- blog-section start -->
<section class="blog-section ptb-120">
    <div class="container">
        <div class="row justify-content-center ml-b-30">
            <div class="col-lg-8 mrb-30">
                <div class="blog-item">
                    <div class="blog-thumb">
                        <img src="{{ getImage('assets/images/frontend/blog/'.@$blog->data_values->blog_image,'708x472') }}" alt="Blog">
                        <span class="overlay-date">{{ showDateTime($blog->created_at, 'd, M') }}</span>
                    </div>
                    <div class="blog-content">
                        <h3 class="title">{{ $blog->data_values->title }}</h3>
                        <p>
                            @php echo $blog->data_values->description @endphp
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mrb-30">
                <div class="sidebar">
                    <div class="widget-box">
                        <h5 class="widget-title">@lang('Latest Blogs')</h5>
                        <div class="popular-widget-box">
                            @foreach($latestBlogs as $latestBlog)
                            <div class="single-popular-item d-flex flex-wrap align-items-center">
                                <div class="popular-item-thumb">
                                    <img src="{{ getImage('assets/images/frontend/blog/'.@$latestBlog->data_values->blog_image) }}" alt="@lang('blog')">
                                </div>
                                <div class="popular-item-content">
                                    <h5 class="title"><a href="{{ route('blog.details',[$latestBlog->id,str_slug($latestBlog->data_values->title)]) }}">{{ $blog->data_values->title }}</a></h5>
                                    <span class="blog-date">{{showDateTime(@$latestBlog->created_at,  $format = 'd F, Y')}}</span>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- blog-section end -->
@endsection

