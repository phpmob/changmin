import { Map } from 'immutable';
import { combineReducers } from 'redux';

const reducerMap = {
    menus: function (state = {}, action) {
        console.log(state);
        return state;
    },
};

export default function (state = {}, action) {
    return state;
};
