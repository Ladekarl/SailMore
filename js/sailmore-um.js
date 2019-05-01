jQuery(document).ready(function () {

    jQuery('#sejlomraade').before('<i class="mec-sl-location-pin"></i>');
    jQuery('#sejlerfaring_select').before('<i class="mec-sl-tag"></i>');
    jQuery('#sejladstype').before('<i class="mec-sl-globe"></i>');
    jQuery('#aktiviteter').before('<i class="mec-sl-folder"></i>');

    jQuery(document.body).on('change', '.um-s1', function (e) {

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