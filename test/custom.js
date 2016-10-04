;
(function ($) {
    $(function () {

        $('.edit').bind('click', function (e) {
            var id = this.id;
            var actionType = 'update';
            $('.pop').bPopup({
                contentContainer: '.content'
            });
        });
        $('.insert').bind('click', function (e) {
            var id = this.id;
            var actionType = 'insert';
            $('.pop').bPopup({
                contentContainer: '.content'
            });
        });


    });

})(jQuery);