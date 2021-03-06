/**
 * Add jQuery Validation plugin method for a valid password
 * Valid passwords contain at least one letter and one number.
 */
$.validator.setDefaults({
    errorElement: 'span',
    errorClass: 'help-block',
    errorPlacement: function(error, element) {
        error.insertAfter(element.parent());
    }
});
$.validator.addMethod('validPassword',
    function (value, element, param) {
        if (value != '') {
            if (value.match(/.*[a-z]+.*/i) == null) {
                return false;
            }
            if (value.match(/.*\d+.*/) == null) {
                return false;
            }
        }

        return true;
    },
    'Password must contain at least one letter and one number'
);