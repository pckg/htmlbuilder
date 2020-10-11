const pckgFormValidator = {
    methods: {
        validateAndSubmit: function (submit, invalid) {
            this.$validator.validateAll().then(function (ok) {
                if (ok) {
                    submit();
                    return;
                }

                var element = $(this.$el).find('.htmlbuilder-validator-error').first();
                if (element && typeof globalScrollTo == Function) {
                    globalScrollTo(element);
                }
                if (invalid) {
                    invalid();
                }
            }.bind(this));
        },
        clearErrorResponse: function () {
            this.errors.clear();
        },
        hydrateErrorResponse: function (response) {
            /**
             * Clear existing errors.
             */
            this.clearErrorResponse();

            /**
             * Skip if no JSON response.
             */
            if (!response.responseJSON) {
                return;
            }

            /**
             * Populate errors.
             */
            $.each(response.responseJSON.descriptions || [], function (name, message) {
                this.errors.remove(name);
                this.errors.add({field: name, msg: message});
            }.bind(this));

            /**
             * Scroll to error.
             */
            this.$nextTick(function () {
                let e = $(this.$el).find('.htmlbuilder-validator-error').first();
                if (!e) {
                    return;
                }

                if (typeof globalScrollTo == Function) {
                    globalScrollTo(e);
                }
            }.bind(this));
        }
    }
};

export {pckgFormValidator};