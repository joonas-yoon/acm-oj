$ ->
    $('#flash-overlay-modal').modal()
    $('.navbar-toggle').click ->
        $('.row-offcanvas').toggleClass('active')
        $('.navbar-nav').toggleClass('slide-in')
        $('.side-body').toggleClass('body-slide-in')
        # Uncomment code for absolute positioning tweek see top comment in css.
        # $('.absolute-wrapper').toggleClass('slide-in')
    $('#form-trigger').click ->
        $('.navbar-nav').removeClass('slide-in')
        $('.side-body').removeClass('body-slide-in')
        # Uncomment code for absolute positioning tweek see top comment in css
        # $('.absolute-wrapper').removeClass('slide-in')