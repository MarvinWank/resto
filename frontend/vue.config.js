const path = require("path");


module.exports = {
    pwa: {
        name: 'resto',
        themeColor: '#3c9026',
        msTileColor: '#000000',
        appleMobileWebAppCapable: 'yes',
        appleMobileWebAppStatusBarStyle: 'black',

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
                }
            ],
            "orientation": "portrait"
        },
    },

}
