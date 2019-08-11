export const state = () => ({
    errors: {}
});

/**
 * Getter
 */
export const getters = {
    errors(state) {
        return state.errors;
    }
};

/**
 * Mutation
 */
export const mutations = {
    SET_ERRORS(state, errors) {
        state.errors = errors;
    }
};

/**
 * Action
 */
export const actions = {
    setErrors({ commit }, errors) {
        commit("SET_ERRORS", errors);
    },
    clearErrors({ commit }) {
        commit("SET_ERRORS", {});
    }
};
