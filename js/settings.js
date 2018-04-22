$('document').ready(function(){
        $('.edit-details').hide();

        $('.change').on('click', function(e){
            e.preventDefault();
            $(this).parent().siblings('.edit-details').show();
            $(this).parent().siblings('.view-details').hide();
            $(this).parent().hide();
        });

        $('.cancel').on('click', function(e){
            e.preventDefault();
            $(this).parent('.edit-details').hide();
            $(this).parent().siblings().show();
            
        });

        $('.save').on('click', function(e){
            e.preventDefault();
            var type            = $(this).siblings('input').attr('id');
            var changedValue    = $(this).siblings('input').val();
            var $this           = $(this);
            $.ajax({
                type: "POST",
                url: "update-profile",
                data: {changedValue: changedValue, type: type},
                dataType: 'json',
                success: function (result) {
                    if( result ) {
                        $this.parent('.edit-details').hide();
                        $this.parent().siblings('.view-details').children('span').text(changedValue);
                        $this.parent().siblings().show();
                    }
                }
            });
        });

        $('#change-password').on('click', function(){
            $('#change-password-section').removeClass('hide');
            $('#change-password').addClass('hide');
        });

        $('#cancel-password').on('click', function(){
            $('#change-password-section').addClass('hide');
            $('#change-password').removeClass('hide');
        });

        $('#name').keydown(function (e) {
            if (e.shiftKey || e.ctrlKey || e.altKey) {
                e.preventDefault();
            } else {
                var key = e.keyCode;
                if (!((key == 8) || (key == 32) || (key == 46) || (key >= 35 && key <= 40) || (key >= 65 && key <= 90))) {
                      e.preventDefault();
                }
            }
      });
});