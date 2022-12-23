let mix = require('laravel-mix');
mix.setPublicPath('src');

mix.sass('src/admin/css/admin-sale-booster.scss', 'src/admin/css/admin-sale-booster.css');
mix.sass('src/public/css/sale-booster.scss', 'src/public/css/sale-booster.css');
