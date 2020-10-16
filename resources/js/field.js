Nova.booting((Vue, router, store) => {
    Vue.component('index-reactive-boolean-field', Vue.component('index-boolean-field'));
    Vue.component('detail-reactive-boolean-field', Vue.component('detail-boolean-field'));
    Vue.component('form-reactive-boolean-field', require('./components/form/ReactiveBooleanField').default);

    Vue.component('index-reactive-text-field', Vue.component('index-text-field'));
    Vue.component('detail-reactive-text-field', Vue.component('detail-text-field'));
    Vue.component('form-reactive-text-field', require('./components/form/ReactiveTextField').default);

    Vue.component('index-reactive-number-field', Vue.component('index-text-field'));
    Vue.component('detail-reactive-number-field', Vue.component('detail-text-field'));
    Vue.component('form-reactive-number-field', require('./components/form/ReactiveTextField').default);

    Vue.component('index-reactive-belongs-to-field', require('./components/index/ReactiveBelongsToField').default);
    Vue.component('detail-reactive-belongs-to-field', Vue.component('detail-belongs-to-field'));
    Vue.component('form-reactive-belongs-to-field', require('./components/form/ReactiveBelongsToField').default);

    Vue.component('index-reactive-select-field', Vue.component('index-select-field'));
    Vue.component('detail-reactive-select-field', Vue.component('detail-select-field'));
    Vue.component('form-reactive-select-field', require('./components/form/ReactiveSelectField').default);

    Vue.component('reactive-has-many-field', require('./components/form/ReactiveHasManyField').default);
    Vue.component('detail-reactive-has-many-field', require('./components/form/ReactiveHasManyField').default);

    Vue.component('index-reactive-currency-field', Vue.component('index-currency-field'))
    Vue.component('detail-reactive-currency-field', Vue.component('detail-currency-field'))
    Vue.component('form-reactive-currency-field', require('./components/form/ReactiveCurrencyField').default)

    Vue.component('detail-reactive-key-value-field', Vue.component('detail-key-value-field'))
    Vue.component('form-reactive-key-value-field', require('./components/form/ReactiveKeyValueField/ReactiveKeyValueField').default)
});
