$('.tab-navigate').each(function(){
    var first_content = $('[data-tab-navigate]', this).eq(0).attr('data-tab-navigate');
    $('[data-tab-content=' + first_content + ']').addClass('active');

    $('[data-tab-navigate]', this).click(function(){
        var navigate = $(this).attr('data-tab-navigate');
        $('[data-tab-content]').removeClass('active');
        $('[data-tab-content=' + navigate + ']').addClass('active');
    });
});