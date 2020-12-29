export const pckgFormValidator = {
    methods: {
        patchForm: function (url, data, onSuccess, onError) {
            http.patch(url, data, (data) => {
                this.clearErrorResponse();
                onSuccess && onSuccess(data);
            }, (response) => {
                this.hydrateErrorResponse(response);
                onError && onError(response);
            });
        },
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
        syncErrors: function (task) {
            return (new Promise(async (resolve, reject) => {
                try {
                    resolve(await task());
                } catch (e) {
                    reject(e);
                }
            })).then((resolved) => {
                console.log('clearing because of success response', resolved);
                this.clearErrorResponse();
                return resolved;
            }).catch((e) => {
                console.log('hydrating error response', e);
                this.hydrateErrorResponse(e);
                return e;
            });
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