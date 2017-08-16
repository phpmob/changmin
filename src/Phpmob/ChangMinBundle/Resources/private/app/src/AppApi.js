import Immutable from 'immutable';
import { MenuItem } from './redux/state';

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

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

    set(props) {
        if (arguments.length > 1) {
            props = { [arguments[0]]: arguments[1] }
        }

        Object.keys(props).map(k => {
            this[`update${ucfirst(k)}`](props[k])
        })
    }

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
        this.update(['menubar', 'title'], title);
    };

    updateToolbar(type, content) {
        this.update(['toolbar', type], content);
    };

    updateToolbarHeader(content) {
        this.update(['toolbar', 'header'], content);
    };

    updateToolbarFooter(content) {
        this.update(['toolbar', 'footer'], content);
    };

    updateBreadcrumb(breadcrumb) {
        this.update(['breadcrumb'], breadcrumb);
    };

    updateFlash(flash) {
        this.update(['flash'], flash);
    };

    updateContent(content) {
        this.update('content', content);
    };
};

AppApi.Immutable = Immutable;
AppApi.MenuItem = MenuItem;
