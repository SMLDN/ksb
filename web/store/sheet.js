const defaultSheet = {
  title: "",
  tags: null,
  tagsText: "",
  content: ""
};

export const state = () => ({
  sheet: defaultSheet
});

/**
 * Getter
 */
export const getters = {
  sheet(state) {
    return state.sheet;
  }
};

/**
 * Mutation
 */
export const mutations = {
  SET_SHEET(state, sheet) {
    if (sheet.tags) {
      let tagsText = " ";
      const tags = sheet.tags;
      tags.forEach(sheetTag => {
        tagsText += sheetTag.tag.name + " ";
      });
      sheet.tagsText = tagsText.trim();
    }
    state.sheet = sheet;
  },

  SET_PROP(state, props) {
    for (const prop in props) {
      state.sheet[prop] = props[prop];
    }
  }
};

/**
 * Action
 */
export const actions = {
  setSheet({ commit }, sheet) {
    commit("SET_SHEET", sheet);
  },

  resetSheet({ commit }) {
    commit("SET_SHEET", defaultSheet);
  },

  setTitle({ commit }, title) {
    commit("SET_PROP", {
      title
    });
  },

  setTagsText({ commit }, tagsText) {
    commit("SET_PROP", {
      tagsText
    });
  },

  setContent({ commit }, content) {
    commit("SET_PROP", {
      content
    });
  }
};
