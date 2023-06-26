module.exports = {
    preset: '@vue/cli-plugin-unit-jest/presets/typescript',
    "moduleFileExtensions": [
        "js",
        "json",
        // tell Jest to handle `*.vue` files
        "vue",
        "ts",
    ],
    "transform": {
        // process `*.vue` files with `vue-jest`
        // ".*\\.(vue)$": "vue-jest",
        ".*(vue)$": "vue-jest",
        // ".+\\.(css|styl|less|sass|scss|png|jpg|ttf|woff|woff2)$":
        //     "jest-transform-stub",
    },
    transformIgnorePatterns: [
        "/node_modules/"
    ],
    testEnvironment: "jsdom",
}

