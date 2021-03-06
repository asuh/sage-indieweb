<article @php post_class() @endphp>
  <header class="post-header">
    <h1 class="entry-title p-name">{!! get_the_title() !!}</h1>
    @include('partials/entry-meta')
  </header>
  <div class="main-content">
    @php the_content() @endphp
  </div><!-- .main-content -->
  <footer>
    {!! wp_link_pages(['echo' => 0, 'before' => '<nav class="page-nav"><p>' . __('Pages:', 'sage'), 'after' => '</p></nav>']) !!}
  </footer>
  @php comments_template('/partials/comments.blade.php') @endphp
</article>
