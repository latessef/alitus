(function ($) {
    "use stict";
    var custom_uploader;
    var custom_uploader2;

    checkPreviewBackground();
    setPreviewBackgroundOnLoad();

    $(window).on('load', function () {

        $('#upload_image_button').on('click', function (e) {
            var return_field = $(this).prev();

            e.preventDefault();

            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader) {
                custom_uploader.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function () {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                $(return_field).val(attachment.url);

                var imgcheck = attachment.url.width;
                if (imgcheck !== 0) {
                    $('#small-background-image-preview').css('background-image', 'url(' + attachment.url + ')').addClass('has-background');
                }

            });

            //Open the uploader dialog
            custom_uploader.open();

        });

        $('#upload_image_button2').click(function (e) {

            var return_field = $(this).prev();

            e.preventDefault();


            //If the uploader object has already been created, reopen the dialog
            if (custom_uploader2) {
                custom_uploader2.open();
                return;
            }

            //Extend the wp.media object
            custom_uploader2 = wp.media.frames.file_frame = wp.media({
                title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader2.on('select', function () {
                attachment = custom_uploader2.state().get('selection').first().toJSON();
                $(return_field).val(attachment.url);

                var imgcheck = attachment.url.width;
                if (imgcheck !== 0) {
                    $('#small-background-image-preview2').css('background-image', 'url(' + attachment.url + ')').addClass('has-background');
                }
            });

            //Open the uploader dialog
            custom_uploader2.open();

        });

        if ($().ColorPicker) {
            doColors();
        }
    });

    function doColors()
    {

        var pageBackgroundColor = $('#colorPageBackgroundColor').next('input').first().attr('value');
        var pageContactLeftBackgroundColor = $('#colorContactLeftBackgroundColor').next('input').first().attr('value');
        var portfolioBackgroundColor = $('#colorPortfolioBackgroundColor').next('input').first().attr('value');

        if (pageBackgroundColor == '') {
            pageBackgroundColor = '#ffffff';
        }
        if (pageContactLeftBackgroundColor == '') {
            pageContactLeftBackgroundColor = '#5f1ab4';
        }
        if (portfolioBackgroundColor == '') {
            portfolioBackgroundColor = '#221c5a';
        }

        $('#colorPageBackgroundColor').find('div').first().css('background-color', pageBackgroundColor);
        $('#colorContactLeftBackgroundColor').find('div').first().css('background-color', pageContactLeftBackgroundColor);
        $('#colorPortfolioBackgroundColor').find('div').first().css('background-color', portfolioBackgroundColor);

        $('#colorPageBackgroundColor').ColorPicker({
            color: pageBackgroundColor,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorPageBackgroundColor div').css('backgroundColor', '#' + hex);
                $('#colorPageBackgroundColor').next('input').first().attr('value', '#' + hex);
            }
        });

        $('#colorContactLeftBackgroundColor').ColorPicker({
            color: pageContactLeftBackgroundColor,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorContactLeftBackgroundColor div').css('backgroundColor', '#' + hex);
                $('#colorContactLeftBackgroundColor').next('input').first().attr('value', '#' + hex);
            }
        });

        $('#colorPortfolioBackgroundColor').ColorPicker({
            color: portfolioBackgroundColor,
            onShow: function (colpkr) {
                $(colpkr).fadeIn(500);
                return false;
            },
            onHide: function (colpkr) {
                $(colpkr).fadeOut(500);
                return false;
            },
            onChange: function (hsb, hex, rgb) {
                $('#colorPortfolioBackgroundColor div').css('backgroundColor', '#' + hex);
                $('#colorPortfolioBackgroundColor').next('input').first().attr('value', '#' + hex);
            }
        });
    }

    function setPreviewBackgroundOnLoad() {
        $('.image-url-input').each(function () {
            if ($(this).val() !== '') {
                $(this).nextAll('#small-background-image-preview:first').css('background-image', 'url(' + $(this).val() + ')');
                $(this).nextAll('#small-background-image-preview2:first').css('background-image', 'url(' + $(this).val() + ')');
            } else {
                $(this).nextAll('#small-background-image-preview:first').removeClass('has-background');
                $(this).nextAll('#small-background-image-preview2:first').removeClass('has-background');
            }
        });
    }

    function checkPreviewBackground() {
        $('.image-url-input').on('change', function () {
            if ($(this).val() === '') {
                $(this).nextAll('#small-background-image-preview:first').css('background-image', 'none').removeClass('has-background');
                $(this).nextAll('#small-background-image-preview2:first').css('background-image', 'none').removeClass('has-background');
            }
        });
    }

})(jQuery);