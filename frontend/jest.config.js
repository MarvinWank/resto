module.exports = {
    preset: '@vue/cli-plugin-unit-jest/presets/typescript',
    "moduleFileExtensions": [
        "js",
        "json",
        // tell Jest to handle `*.vue` files
        "vue"
    ],
    "transform": {
        // process `*.vue` files with `vue-jest`
        ".*\\.(vue)$": "vue-jest"
    },
}
