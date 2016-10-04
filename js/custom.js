;
(function ($) {
    $(function () {

        $('.edit').bind('click', function (e) {
            var id = this.id;
            var actionType = 'update';
            e.preventDefault();
            $('.pop').bPopup({
                //                easing: 'easeOutBack', //uses jQuery easing plugin
                //                speed: 450,
                //                transition: 'slideDown'
                contentContainer: '.content',
                loadUrl: './action/actionPopUpdate.php?id=' + id + '&type=' + actionType
//                                    loadUrl:'./test/form.html'
            });
        });
        $('.insert').bind('click', function (e) {
            var id = this.id;
            var actionType = 'insert';
            e.preventDefault();
            $('.pop').bPopup({
                contentContainer: '.content',
                loadUrl: './action/actionPopUpdate.php?id=' + id + '&type=' + actionType
//                                    loadUrl:'./test/form.html'
            });
        });


    });

})(jQuery);