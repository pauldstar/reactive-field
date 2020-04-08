Nova.booting((Vue, router, store) => {
    Vue.component('index-broadcaster-belongs-to-field', Vue.component('index-belongs-to-field'));
    Vue.component('detail-broadcaster-belongs-to-field', Vue.component('detail-belongs-to-field'));
    Vue.component('form-broadcaster-belongs-to-field',
        Vue.component('form-belongs-to-field').extend(
            require('./components/broadcaster-belongs-to-field/FormField').default
        )
    );

    Vue.component('index-broadcaster-boolean-field', Vue.component('index-boolean-field'));
    Vue.component('detail-broadcaster-boolean-field', Vue.component('detail-boolean-field'));
    Vue.component('form-broadcaster-boolean-field',
        Vue.component('form-boolean-field').extend(
            require('./components/broadcaster-boolean-field/FormField').default
        )
    );

    Vue.component('index-broadcaster-text-field', Vue.component('index-text-field'));
    Vue.component('detail-broadcaster-text-field', Vue.component('detail-text-field'));
    Vue.component('form-broadcaster-text-field',
        Vue.component('form-text-field').extend(
            require('./components/broadcaster-text-field/FormField').default
        )
    );

    Vue.component('index-listener-text-field', Vue.component('index-text-field'));
    Vue.component('detail-listener-text-field', Vue.component('detail-text-field'));
    Vue.component('form-listener-text-field',
        Vue.component('form-text-field').extend(
            require('./components/listener-text-field/FormField').default
        )
    );

    Vue.component('index-broadcaster-number-field', Vue.component('index-text-field'));
    Vue.component('detail-broadcaster-number-field', Vue.component('detail-text-field'));
    Vue.component('form-broadcaster-number-field',
        Vue.component('form-text-field').extend(
            require('./components/broadcaster-text-field/FormField').default
        )
    );

    Vue.component('index-listener-number-field', Vue.component('index-text-field'));
    Vue.component('detail-listener-number-field', Vue.component('detail-text-field'));
    Vue.component('form-listener-number-field',
        Vue.component('form-text-field').extend(
            require('./components/listener-text-field/FormField').default
        )
    );

    Vue.component('index-listener-belongs-to-field', Vue.component('index-belongs-to-field'));
    Vue.component('detail-listener-belongs-to-field', Vue.component('detail-belongs-to-field'));
    Vue.component('form-listener-belongs-to-field',
        Vue.component('form-belongs-to-field').extend(
            require('./components/listener-belongs-to-field/FormField').default
        )
    );
});
