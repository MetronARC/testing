@extends('user.v_template')

@section('main')
  <div class="mb-5"></div>
  <div class="container">
    <nav class="breadcrumb">
      <a class="breadcrumb-item" href="{{ route('news.newsIndex') }}">News</a>
      <span class="breadcrumb-item active" aria-current="page">{{ $news['title'] }}</span>
    </nav>
    <div class="row">
      <div class="col-lg-9">

        <div class="news__first">
          <div class="news__item">
            <div class="news__item_image">
              <img src="{{ cdnUrl($news['image']) }}" alt="{{ $news['title'] }}">
            </div>
            <div class="news__item_title">
              <h4>{{ $news['title'] }}</h4>
            </div>
          </div>
          <div class="mb-4"></div>
          <div class="wysiwyg">
            {!! $news['content'] !!}
          </div>
        </div>
        <div class="mb-5"></div>
      </div>
      <div class="col-lg-3">
        <div class="news__popular">
          <h2>Top News</h2>
          @foreach ($popularNews as $_news)
            <a
              href="{{ route('read.newsDetail', [
                  'year' => date('Y', strtotime($_news['created_at'])),
                  'month' => date('m', strtotime($_news['created_at'])),
                  'date' => date('d', strtotime($_news['created_at'])),
                  'id' => $_news['id'],
                  'slug' => Str::slug($_news['title']),
              ]) }}">
              <div class="news__item_list">
                <div class="row">
                  <div class="col-lg-5">
                    <div class="news__item_image">
                      <img src="{{ cdnUrl($_news['image']) }}" alt="{{ $_news['title'] }}">
                    </div>
                  </div>
                  <div class="col-lg-7 ">
                    <div class="news__item_title">
                      <h4>{{ $_news['title'] }}</h4>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection

@section('topSlot')
@endsection

@section('btmSlot')
  <script>
    let popularWidth = $('.news__popular').outerWidth();
    let popularHeight = $('.news__popular').outerHeight();
    let popularPosition = $('.news__popular').offset().top;

    $(document).ready(function() {
      $(window).scroll(function() {
        // Check the scroll position
        if ($(this).scrollTop() >= popularPosition) {
          $('.news__popular').addClass('news__popular_sticky');
          $('.news__popular').width(popularWidth);
          $('.news__popular').height(popularHeight);
        } else {
          $('.news__popular').removeClass('news__popular_sticky');
          $('.news__popular').removeAttr('style');
        }
      });
    });
  </script>
@endsection
