export default function({ $axios, store }) {
    /**
     * OnError
     */
    $axios.onError(error => {
        if (error.response.status === 401) {
            store.dispatch("serverError/setErrors", error.response.data);
        }
        return Promise.reject(error);
    });

    /**
     * OnRequest
     */
    $axios.onRequest(() => {
        store.dispatch("serverError/clearErrors");
    });
}
