jQuery(document).ready(function () {

    jQuery('.sm-members-wrap #sejlomraade').before('<i class="mec-sl-location-pin"></i>');
    jQuery('.sm-members-wrap #sejlperiode_start').before('<i class="mec-sl-calendar"></i>');
    jQuery('.sm-members-wrap #sejlerfaring_select_gast').before('<i class="mec-sl-tag"></i>');
    jQuery('.sm-members-wrap #sejladstype').before('<i class="mec-sl-globe"></i>');
    jQuery('.sm-members-wrap #aktiviteter').before('<i class="mec-sl-folder"></i>');
    jQuery('.sm-members-wrap #skills').before('<i class="mec-sl-equalizer"></i>');
    jQuery('.sm-members-wrap #user_login').before('<i class="mec-sl-user"></i>');

    jQuery(document.body).on('change', '.sm-members-wrap .um-s1', function (e) {

        jQuery(this).parents('form').find('input').filter(function (e) {
            if (this.value.length === 0) {
                return true;
            }
        }).prop('disabled', true);


        jQuery(this).parents('form').find('select').filter(function (e) {
            if (this.value.length === 0) {
                return true;
            }
        }).prop('disabled', true);

        jQuery(this).parents('form').submit();
        return false;
    });
});