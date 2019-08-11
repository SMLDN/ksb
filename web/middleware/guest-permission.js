export default function({ store, redirect }) {
    /**
     * Kiểm tra xem người dùng có phải chưa đăng nhập hay không?
     */
    if (store.getters["auth/authenticated"]) {
        return redirect("/");
    }
}
