export default {
    mode: "universal",

    server: {
        port: 80
    },

    /*
     ** Headers of the page
     */
    head: {
        title: process.env.npm_package_name || "",
        meta: [
            { charset: "utf-8" },
            {
                name: "viewport",
                content: "width=device-width, initial-scale=1"
            },
            {
                hid: "description",
                name: "description",
                content: process.env.npm_package_description || ""
            }
        ]
        // link: [{ rel: "icon", type: "image/x-icon", href: "/favicon.ico" }]
    },
    /*
     ** Customize the progress-bar color
     */
    loading: { color: "#fff" },
    /*
     ** Global CSS
     */
    css: [],
    /*
     ** Plugins to load before mounting the App
     */
    plugins: [
        "./plugins/mixin/auth.js",
        "./plugins/mixin/serverError.js",
        "./plugins/axios.js",
        "./plugins/directive.js"
    ],
    /*
     ** Nuxt.js dev-modules
     */
    devModules: [
        // Doc: https://github.com/nuxt-community/eslint-module
        "@nuxtjs/eslint-module"
    ],
    /*
     ** Nuxt.js modules
     */
    modules: [
        // Doc: https://github.com/nuxt-community/modules/tree/master/packages/bulma
        "@nuxtjs/bulma",
        // Doc: https://axios.nuxtjs.org/usage
        "@nuxtjs/axios",
        "@nuxtjs/auth"
    ],

    /*
     ** Axios module configuration
     ** See https://axios.nuxtjs.org/options
     */
    axios: {
        baseURL: "http://localhost:8080/api"
    },

    auth: {
        strategies: {
            local: {
                endpoints: {
                    login: {
                        url: "/auth/login",
                        method: "post",
                        propertyName: "token"
                    },
                    logout: {
                        url: "/auth/logout",
                        method: "post"
                    },
                    user: {
                        url: "/user/me",
                        method: "get",
                        propertyName: "user"
                    }
                },
                tokenRequired: true,
                tokenType: "Bearer"
            }
        },
        redirect: {
            login: "/auth/login"
        }
    },

    router: {
        middleware: [/* "auth",  */ "resetServerError"]
    },

    /*
     ** Build configuration
     */
    build: {
        postcss: {
            preset: {
                features: {
                    customProperties: false
                }
            }
        },
        /*
         ** You can extend webpack config here
         */
        extend(config, ctx) {
            if (ctx.isDev) {
                config.devtool = ctx.isClient
                    ? "source-map"
                    : "inline-source-map";
            }
        }
    }
};
