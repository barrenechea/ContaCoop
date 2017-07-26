/*
 *  Document   : base_forms_wizard.js
 *  Author     : pixelcave
 *  Description: Custom JS code used in Form Wizard Page
 */

var BaseFormWizard = function() {
    // Init simple wizard, for more examples you can check out http://vadimg.com/twitter-bootstrap-wizard-example/
    var initWizardSimple = function(){
        jQuery('.js-wizard-simple').bootstrapWizard({
            'tabClass': '',
            'firstSelector': '.wizard-first',
            'previousSelector': '.wizard-prev',
            'nextSelector': '.wizard-next',
            'lastSelector': '.wizard-last',
            'onTabShow': function($tab, $navigation, $index) {
		var $total      = $navigation.find('li').length;
		var $current    = $index + 1;
		var $percent    = ($current/$total) * 100;

                // Get vital wizard elements
                var $wizard     = $navigation.parents('.block');
                var $progress   = $wizard.find('.wizard-progress > .progress-bar');
                var $btnPrev    = $wizard.find('.wizard-prev');
                var $btnNext    = $wizard.find('.wizard-next');
                var $btnFinish  = $wizard.find('.wizard-finish');

                // Update progress bar if there is one
		if ($progress) {
                    $progress.css({ width: $percent + '%' });
                }

		// If it's the last tab then hide the last button and show the finish instead
		if($current >= $total) {
                    $btnNext.hide();
                    $btnFinish.show();
		} else {
                    $btnNext.show();
                    $btnFinish.hide();
		}
            }
        });
    };

    // Init wizards with validation, for more examples you can check out http://vadimg.com/twitter-bootstrap-wizard-example/
    var initWizardValidation = function(){
        // Get forms
        var $form2 = jQuery('.js-form2');

        // Init form validation on the other wizard form
        var $validator2 = $form2.validate({
            errorClass: 'help-block text-right animated fadeInDown',
            errorElement: 'div',
            errorPlacement: function(error, e) {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error').addClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            success: function(e) {
                jQuery(e).closest('.form-group').removeClass('has-error');
                jQuery(e).closest('.help-block').remove();
            },
            rules: {
                'voucher-date': {
                    required: true
                },
                'voucher-description': {
                    required: true
                },
                'voucher-bank': {
                    required: true
                },
                'validation-lastname': {
                    required: true,
                    minlength: 2
                },
                'validation-email': {
                    required: true,
                    email: true
                },
                'validation-details': {
                    required: true,
                    minlength: 5
                },
                'validation-city': {
                    required: true
                },
                'validation-skills': {
                    required: true
                },
                'validation-terms': {
                    required: true
                }
            },
            messages: {
                'voucher-date': {
                    required: 'Por favor ingrese una fecha'
                },
                'voucher-description': {
                    required: 'Por favor ingrese glosa del voucher'
                },
                'voucher-bank': {
                    required: 'Por favor seleccione una opción'
                },
                'validation-lastname': {
                    required: 'Please enter a lastname',
                    minlength: 'Your lastname must consist of at least 2 characters'
                },
                'validation-email': 'Please enter a valid email address',
                'validation-details': 'Let us know a few thing about yourself',
                'validation-skills': 'Please select a skill!',
                'validation-terms': 'You must agree to the service terms!'
            }
        });

        // Init classic wizard with validation
        jQuery('.js-wizard-classic-validation').bootstrapWizard({
            'tabClass': '',
            'previousSelector': '.wizard-prev',
            'nextSelector': '.wizard-next',
            'onTabShow': function($tab, $nav, $index) {
		var $total      = $nav.find('li').length;
		var $current    = $index + 1;

                // Get vital wizard elements
                var $wizard     = $nav.parents('.block');
                var $btnNext    = $wizard.find('.wizard-next');
                var $btnFinish  = $wizard.find('.wizard-finish');

		// If it's the last tab then hide the last button and show the finish instead
		if($current >= $total) {
                    $btnNext.hide();
                    $btnFinish.show();
		} else {
                    $btnNext.show();
                    $btnFinish.hide();
		}
            },
            'onNext': function($tab, $navigation, $index) {
                var $valid = $form1.valid();

                if(!$valid) {
                    $validator1.focusInvalid();

                    return false;
                }
            },
            onTabClick: function($tab, $navigation, $index) {
		return false;
            }
        });

        // Init wizard with validation
        jQuery('.js-wizard-validation').bootstrapWizard({
            'tabClass': '',
            'previousSelector': '.wizard-prev',
            'nextSelector': '.wizard-next',
            'onTabShow': function($tab, $nav, $index) {
		var $total      = $nav.find('li').length;
		var $current    = $index + 1;

                // Get vital wizard elements
                var $wizard     = $nav.parents('.block');
                var $btnNext    = $wizard.find('.wizard-next');
                var $btnFinish  = $wizard.find('.wizard-finish');

		// If it's the last tab then hide the last button and show the finish instead
		if($current >= $total) {
                    $btnNext.hide();
                    $btnFinish.show();
		} else {
                    $btnNext.show();
                    $btnFinish.hide();
		}
            },
            'onNext': function($tab, $navigation, $index) {
                var $valid = $form2.valid();

                if(!$valid) {
                    $validator2.focusInvalid();

                    return false;
                }
            },
            onTabClick: function($tab, $navigation, $index) {
		return false;
            }
        });
    };

    return {
        init: function () {
            // Init simple wizard
            initWizardSimple();

            // Init wizards with validation
            initWizardValidation();
        }
    };
}();

// Initialize when page loads
jQuery(function(){ BaseFormWizard.init(); });