(function() {
    $(document).ready(function() {
        $('#admin-tablist a').click(function (e) {
            e.preventDefault()
            $(this).tab('show')
        });

        $('.image-upload').on('change', function() {
            $(this).parent('form').submit();
        });

        if ($('.checkout-form').length > 0) {

            Checkout.init();

        }
    });

    var Checkout = {

        init: function() {
            var _this = this;
            // Quick and dirty way, just include this inline ><
            Stripe.setPublishableKey('pk_test_LrYJnsLsDDj8jFPl7714V4Ft');
            this.assignElements();
            this.paymentMagic();
            this.elements.submit.on('click', function(event) {
                _this.checkout();
            });
        },

        elements: {
            form: null,
            error: null,
            email: null,
            ccnum: null,
            ccexp: null,
            cvc: null,
            customer_token: null,
            submit: null
        },

        values: {
            error: '',
            email: '',
            number: '',
            exp_month: '',
            exp_year: '',
            cvc: '',
            customer_token: ''
        },

        assignElements: function() {
            this.elements.form = $('#checkout_form')
            this.elements.error = $('#error')
            this.elements.email = $('#email')
            this.elements.ccnum = $('#ccnum')
            this.elements.ccexp = $('#ccexp')
            this.elements.cvc = $('#cvc')
            this.elements.customer_token = $('#customer_token')
            this.elements.submit = $('#_submit')
        },

        paymentMagic: function() {
            this.elements.ccnum.payment('formatCardNumber');
            this.elements.ccexp.payment('formatCardExpiry');
            this.elements.cvc.payment('formatCardCVC');
        },

        handleError(response) {
            // Error handling code :)
        },

        checkout: function() {
            var _this = this;
            this.values.email = this.elements.email.val();
            this.values.number = this.elements.ccnum.val();
            var expObject = $.payment.cardExpiryVal(this.elements.ccexp.val());
            this.values.exp_month = expObject.month;
            this.values.exp_year = expObject.year;
            this.values.cvc = this.elements.cvc.val();

            Stripe.card.createToken({
                number: this.values.number,
                cvc: this.values.cvc,
                exp_month: this.values.exp_month,
                exp_year: this.values.exp_year
            }, function(status, response) {
                if (response.error) {
                    _this.handleError(response);
                } else {
                    _this.elements.customer_token.val(response.id);
                    _this.elements.form.submit();
                }
            });
        }

    }

}());
