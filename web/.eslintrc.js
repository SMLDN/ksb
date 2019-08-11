module.exports = {
    root: true,
    env: {
        browser: true,
        node: true
    },
    parserOptions: {
        parser: "babel-eslint"
    },
    extends: ["@nuxtjs", "plugin:nuxt/recommended", "prettier"],
    // add your custom rules here
    rules: {
        "vue/singleline-html-element-content-newline": "off",
        "vue/multiline-html-element-content-newline": "off",
        "vue/html-self-closing": "off"
    }
};
