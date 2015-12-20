
  <!-- Initialize the editor. -->
  <script src='//cdn.tinymce.com/4/tinymce.min.js'></script>
  <script type="text/javascript">
  $(document).ready(function() {
    tinyMCE.baseURL = '<?php echo url(); ?>/assets/tinymce'; // trailing slash important
    tinymce.init({
      selector: 'textarea.html-editor',
      menu: {},
      menubar: false,
      toolbar: 
        'styleselect | undo redo | bold italic underline strikethrough \
        | subscript superscript | alignleft aligncenter alignright \
        | bullist numlist | codesample visualblocks table \
        | link image fontawesome | preview code fullscreen'
      ,
      plugins : [
        'advlist autolink link image lists table preview visualblocks paste',
        'code codesample fontawesome fullscreen'
      ],
      relative_urls: false,
      force_br_newlines : false,
      force_p_newlines : true,
      forced_root_block : '',
      convert_newlines_to_brs: true,
      remove_linebreaks : true,
      paste_as_text: true,
    
      height: 300,
      content_css: [
        '/assets/style.css',
        '/assets/semantic-ui/css/semantic.min.css',
        '/assets/tinymce/style.css',
        '//netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css'
      ],
      skin_url: '/assets/tinymce/skins/light',
      table_default_attributes: {
        class: 'ui celled table'
      },
      
      style_formats: [
        { title: "제목글",
          items: [
            {title: "제목 1", format: "h2", class: 'ui header'},
            {title: "제목 2", format: "h3", class: 'ui header'},
            {title: "제목 3", format: "h4", class: 'ui header'},
            {title: "제목 4", format: "h5", class: 'ui header'},
            {title: "제목 5", format: "h6", class: 'ui header'}]
        },
        { title: "문단", block: 'p' },
        { title: "인용글", block: 'blockquote' },
      ],
    });
    tinymce.init({
      selector: 'textarea.html-editor-simple',
      menu: {},
      menubar: false,
      toolbar: 
        'undo redo | bold italic underline strikethrough \
        | subscript superscript \
        | bullist numlist | codesample visualblocks table \
        | link image | code'
      ,
      forced_root_block : false,
      plugins : 'advlist autolink link image lists table visualblocks code codesample bbcode',
      relative_urls: false,
      
      content_css: [
        '/assets/style.css',
        '/assets/semantic-ui/css/semantic.min.css'
      ],
      skin_url: '/assets/tinymce/skins/light',
      table_default_attributes: {
        class: 'ui celled table'
      },
    });
  });
  </script>