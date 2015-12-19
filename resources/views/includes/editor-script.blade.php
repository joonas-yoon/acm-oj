
  <!-- Initialize the editor. -->
  <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
  <script type="text/javascript">
  $(document).ready(function() {
    tinymce.init({
      theme: 'modern',
      menu: {},
      menubar: false,
      toolbar: 
        'undo redo | bold italic underline strikethrough \
        | subscript superscript | alignleft aligncenter alignright \
        | bullist numlist | codesample visualblocks table \
        | link image | preview code'
      ,
      selector: 'textarea.html-editor',
      forced_root_block : false,
      plugins : 'advlist autolink link image lists table preview visualblocks code codesample bbcode',
      powerpaste_allow_local_images: true,
      content_css: '/assets/editor-skins/light/content.min.css',
      relative_urls: false,
    });
    tinymce.init({
      selector: 'textarea.html-editor-simple',
      forced_root_block : false,
      plugins : 'advlist autolink link image lists charmap print preview visualblocks code',
      relative_urls: false,
    });
  });
  </script>