function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    var results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

(function($) {
    $(document).ready(function($) {

        var $form_validate = $('.form_validate');
        var form_url = $form_validate.attr('action');
        $form_validate.append('<input type="hidden" name="ajax" value="1">');
        $form_validate.find('[type=submit]').on('click', function(e) {
            // stop the form from submitting the normal way and refreshing the page
            // e.preventDefault();
            // process the form
            $.ajax({
                    type: 'POST', // define the type of HTTP verb we want to use (POST for our form)
                    url: form_url, // the url where we want to POST
                    data: $form_validate.serialize(), // our data object
                    dataType: 'json', // what type of data do we expect back from the server
                    encode: true,
                    beforeSend: function() {
                        $form_validate.find('div.error-message').hide();
                        $form_validate.find('input.not_valid').removeClass('not_valid');
                        $form_validate.find('textarea.not_valid').removeClass('not_valid');
                        $form_validate.find('select.not_valid').removeClass('not_valid');
                    }
                })
                // using the done promise callback
                .done(function(data) {
                    if (data.valid == "true") {
                    	$('main').removeClass('page-entry-error');
                        $form_validate.find('[name=ajax]').remove();
                        $form_validate.submit();
                    } else {
                        $.each(data.errors, function(key, value) {
                            $form_validate.find('div.error-message').show();
                            var error_block = $form_validate.find('[name=' + key + ']');
                            var error_msg_block = $form_validate.find('.error-message .' + key);
                            error_block.addClass('not_valid');
                            error_block.parent().addClass('block_not_valid');
                            if (error_msg_block.length){
                                error_msg_block.html('<span>'+value+'</span>').fadeIn(350);
                            }else{
                                $form_validate.children( ".error-message" ).after('<p class="'+key+'"><span>' + value + '</span></p>');
                                //error_msg_block.html('aaaa');
                            }
                        });
                        $('html, body').stop().animate({
                            scrollTop: $form_validate.find('.contact-form-heading').offset().top - 160
                        }, 400);
                        $('.contact-form-heading .notice.contact').hide();
                        $('.contact-form-heading .notice.error').show();
                        $('main').addClass('page-entry-error');
                        return false;
                    }
                    // here we will handle errors and validation messages
                });

            return false;
        });

        $(document).on('change keyup paste', 'input.not_valid, textarea.not_valid', function(event) {
            var name = $(this).attr('name');
            $(this).removeClass('not_valid');
            $(this).closest('.form_validate').find('.error-message .' + name).fadeOut(350);
        });
    });
})(jQuery);