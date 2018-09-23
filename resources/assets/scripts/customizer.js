wp.customize('blogname', (value) => {
  value.bind(to => document.querySelectorAll('.brand').text(to));
});
