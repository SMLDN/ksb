export const getters = {
  /**
   * Người dùng đã đăng nhập hay chưa
   *
   * @param {*} state
   */
  authenticated(state) {
    return state.loggedIn;
  },

  /**
   * Thông tin người dùng hiện tại
   *
   * @param {*} state
   */
  user(state) {
    return state.user;
  }
};
