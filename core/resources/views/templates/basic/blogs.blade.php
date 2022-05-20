@extends($activeTemplate.'layouts.master')

@section('content')

    <!-- blog-section start -->
    <section class="blog-section ptb-120">
        <div class="container">
            <div class="row justify-content-center ml-b-30">
                @foreach($blogs as $blog)
                    <div class="col-lg-4 col-md-6 col-sm-12 mrb-30">
                        <div class="blog-item">
                            <div class="blog-thumb">
                                <img src="{{ getImage('assets/images/frontend/blog/thumb_'.@$blog->data_values->blog_image,'318x212') }}" alt="@lang('Blog')">
                                <span class="overlay-date">{{ showDateTime($blog->created_at, 'd, M') }}</span>
                            </div>
                            <div class="blog-content">
                                <h3 class="title"><a href="{{ route('blog.details',[$blog->id,str_slug($blog->data_values->title)]) }}">{{ $blog->data_values->title }}</a></h3>
                                <p> @php echo shortDescription(strip_tags($blog->data_values->description), 80) @endphp</p>
                                <div class="blog-btn">
                                    <a href="{{ route('blog.details',[$blog->id,str_slug($blog->data_values->title)]) }}" class="custom-btn">@lang('Read More') <i class="fas fa-angle-double-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            {{ $blogs->links() }}
        </div>
    </section>
    <!-- blog-section end -->


@if($sections->secs != null)
    @foreach(json_decode($sections->secs) as $sec)
        @include($activeTemplate.'sections.'.$sec)
    @endforeach
@endif

@endsection
