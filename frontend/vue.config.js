const path = require("path");


module.exports = {
    pwa: {
        name: 'resto',
        themeColor: '#3c9026',
        msTileColor: '#000000',
        appleMobileWebAppCapable: 'yes',
        appleMobileWebAppStatusBarStyle: 'black',

        workboxOptions: {
            navigateFallback: 'index.html'
        },

        manifestOptions: {
            "short_name": "resto",
            "name": "resto - recipe storage",
            "start_url": "/",
            "background_color": "#f8fafc",
            "display": "standalone",
            "scope": "/",
            "theme_color": "#3367D6",
            "icons": [
                {
                    "src": "img/icons/android-chrome-192x192.png",
                    "type": "img/png",
                    "sizes": "48x48"
                },
                {
                    "src": "img/resto_logo.png",
                    "type": "img/png",
                    "sizes": "48x48"
                }
            ],
            "orientation": "portrait"
        },
    },
    css: {
        loaderOptions: {
            sass: {
                additionalData: `@import "./src/assets/scss/_variables.scss";`
            }
        }
    },
    configureWebpack:{
        module:{
            rules: [
                {
                    test: /\.ts$/,
                    exclude: /node_modules|vue\/src/,
                    loader: "ts-loader",
                    options: {
                        appendTsSuffixTo: [/\.vue$/]
                    }
                },
                {
                    test: /\.vue$/,
                    loader: 'vue-loader',
                    options: { // 2.5 UPDATE: vue-cli handles all this stuff for you now, it bundles an external config called vue-loader.conf.js and imports it as vueLoderConfig
                        // no need to worry about any of it
                        esModule: true, // TK Make sure this is added and true
                                        // 2.5 UPDATE: this is not needed in Vue 2.5 and above
                        loaders: {
                            // Since sass-loader (weirdly) has SCSS as its default parse mode, we map
                            // the "scss" and "sass" values for the lang attribute to the right configs here.
                            // other preprocessors should work out of the box, no loader config like this necessary.
                            'scss': 'vue-style-loader!css-loader!sass-loader',
                            'sass': 'vue-style-loader!css-loader!sass-loader?indentedSyntax'
                        }
                        // other vue-loader options go here
                    }
                }
            ]
        }
    }
}
