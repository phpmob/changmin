const UPDATE_STATE = '@changmin/update-state';

export const actions = {
    update: (state) => {
        return {
            type: UPDATE_STATE,
            state
        }
    }
};

export default function (state, action) {
    switch (action.type) {
        case UPDATE_STATE:
            return action.state;
        default:
            return state;
    }
};
