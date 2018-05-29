<article @php post_class() @endphp>
  <header class="post-header">
    <h2 class="entry-title"><a href="{{ get_permalink() }}">{!! get_the_title() !!}</a></h2>
    @if (get_post_type() === 'post')
      @include('partials/entry-meta')
    @endif
  </header>
  <div class="main-content">
    @php the_excerpt() @endphp
  </div><!-- .main-content -->
</article>
