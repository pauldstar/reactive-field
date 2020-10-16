let mix = require('laravel-mix')

mix
    .setPublicPath('dist')
    .js('resources/js/field.js', 'js')
    .sass('resources/sass/field.scss', 'css')
    .webpackConfig({
        resolve: {
            alias: {
                '@nova': path.resolve(__dirname, '../../vendor/laravel/nova/resources/js/'),
                '@ui': path.resolve(__dirname, '../nova-compact-ui/resources/js/'),
                'laravel-nova': path.resolve(__dirname, './node_modules/laravel-nova/dist/index.js'),
                '@': path.resolve(__dirname, '../../vendor/laravel/nova/resources/js/')
            },
        },
    });
