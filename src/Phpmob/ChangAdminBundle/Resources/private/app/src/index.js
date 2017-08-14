import Immutable from 'immutable';
import React from 'react';
import ReactDOM from 'react-dom';
//import registerServiceWorker from './registerServiceWorker';

import store from './redux/store';
import { actions } from './redux/reducer';
import { MenuItem } from './redux/state';

import App from './App';
import Root from './Root';

(function (factory) {
    const ChangMin = ReactDOM.render(
        <Root store={store}><App /></Root>,
        document.getElementById('root')
    );

    const updater = (key, state) => {
        if (typeof state === 'undefined') {
            store.dispatch(actions.update(key))
        } else {
            if (typeof key === 'string') {
                key = key.split('.');
            }

            store.dispatch(actions.update(store.getState().setIn(key, state)));
        }
    };

    ChangMin.MenuItem = MenuItem;
    ChangMin.Immutable = Immutable;
    //ChangMin.store = store;

    ChangMin.get = (state) => {
        if (typeof state === 'string') {
            state = state.split('.');
        }

        return store.getState().getIn(state);
    };

    ChangMin.update = updater;

    ChangMin.updateMenu = (menuUpdater) => {
        const key = ['sidebar', 'menus'];
        const menu = store.getState().getIn(key);

        updater(key, store.getState().getIn(key).withMutations(menuUpdater));
    };

    ChangMin.content = (content) => {
        updater('content', content);
    };

    factory.ChangMin = ChangMin;
})(window);

//registerServiceWorker();
