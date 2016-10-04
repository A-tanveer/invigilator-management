;(function($) {
    $(function() {
        
        $('.edit').bind('click', function(e) { 
            e.preventDefault();
            $('#element_to_pop_up').bPopup({
        contentContainer:'.content',
        loadUrl:'../action/actionPopUpdate.php' //Uses jQuery.load()
    });
});

});

})(jQuery);