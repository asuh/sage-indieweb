  <div class="main-content">
    @if (has_post_thumbnail())
      <figure class="full">@php the_post_thumbnail() @endphp</figure>
    @endif
    @php the_content() @endphp
  </div><!-- .main-content -->
{!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
