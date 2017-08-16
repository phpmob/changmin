import Immutable from 'immutable';
import { MenuItem } from './redux/state';

let app;
export default class AppApi {
    constructor(c) {
        app = c;
    }

    static makeid() {
        let text = "";
        let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (let i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    get(state) {
        if (typeof state === 'string') {
            state = state.split('.');
        }

        return app.props.state.getIn(state);
    };

    update(key, state) {
        if (typeof state === 'undefined') {
            app.props.action.update(key)
        } else {
            if (typeof key === 'string') {
                key = key.split('.');
            }

            app.props.action.update(app.props.state.setIn(key, state));
        }
    };

    updateMenu(menuUpdater) {
        const key = ['sidebar', 'menus'];
        this.update(key, app.props.state.getIn(key).withMutations(menuUpdater));
    };

    updateTitle(title) {
        this.update(['toolbar', 'title'], title);
    };

    updateContent(content) {
        this.update('content', content);
    };
};

AppApi.Immutable = Immutable;
AppApi.MenuItem = MenuItem;
