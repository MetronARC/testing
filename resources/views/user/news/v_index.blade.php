@extends('user.v_template')

@section('main')
  <div class="mb-5"></div>
  <div class="container">
    <div class="row">
      <div class="col-lg-9">
        <div class="news__first">
          <a
            href="{{ route('read.newsDetail', [
                'year' => date('Y', strtotime($firstNews['created_at'])),
                'month' => date('m', strtotime($firstNews['created_at'])),
                'date' => date('d', strtotime($firstNews['created_at'])),
                'id' => $firstNews['id'],
                'slug' => Str::slug($firstNews['title']),
            ]) }}">
            <div class="news__item">
              <div class="news__item_image">
                <img src="{{ cdnUrl($firstNews['image']) }}" alt="{{ $firstNews['title'] }}">
              </div>
              <div class="news__item_title">
                <h4 style="font-size: 1.25rem;">{{ $firstNews['title'] }}</h4>
                <p style="font-size: 14px;">{{ $firstNews['description'] }}</p>
                <div class="text-muted" style="font-size: 10px;">{{ date('j F Y', strtotime($firstNews['start_date'])) }}
                </div>
              </div>
            </div>
          </a>
        </div>
        <div class="mb-5"></div>
        <hr />
        <div class="mb-5"></div>
        <div class="news__list">
          @foreach ($news as $_news)
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
                  <div class="col-lg-3">
                    <div class="news__item_image">
                      <img src="{{ cdnUrl($_news['image']) }}" alt="{{ $_news['title'] }}">
                    </div>
                  </div>
                  <div class="col-lg-9 ">
                    <div class="news__item_title">
                      <h4 style="font-size: 1.25rem;">{{ $_news['title'] }}</h4>
                      <p style="font-size: 14px;">{{ $_news['description'] }}</p>
                      <div class="text-muted" style="font-size: 10px;">
                        {{ date('j F Y', strtotime($_news['start_date'])) }}</div>
                    </div>
                  </div>
                </div>
              </div>
            </a>
          @endforeach
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
      $(document).ready(function() {
        // Check window width on page load
        checkWindowWidth();

        // Check window width on window resize
        $(window).resize(function() {
          checkWindowWidth();
        });
      });

      let isDesktop = false;

      function checkWindowWidth() {
        // Get the window width
        var windowWidth = $(window).width();

        // Check if the window width is greater than 767 pixels
        if (windowWidth > 768) {
          // Perform your action here
          isDesktop = true;
        }
      }

      $(window).scroll(function() {
        // Check the scroll position
        if (isDesktop && $(this).scrollTop() >= popularPosition) {
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
