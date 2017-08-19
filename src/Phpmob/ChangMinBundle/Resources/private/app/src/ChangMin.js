import Immutable from 'immutable';

function ucfirst(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
}

let app;
export default class ChangMin {
    Immutable = Immutable;

    constructor(c) {
        app = c;
        this.state = c.props.state;
    }

    static makeid() {
        let text = "";
        let possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

        for (let i = 0; i < 5; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));

        return text;
    }

    update(updater) {
        if (updater) {
            app.props.action.update(this.state.withMutations(updater));
        } else {
            app.props.action.update(this.state);
        }
    }

    get(state) {
        if (typeof state === 'string') {
            state = state.split('.');
        }

        return this.state.getIn(state);
    };

    set(props) {
        if (arguments.length > 1) {
            props = { [arguments[0]]: arguments[1] }
        }

        Object.keys(props).map(k => {
            return this[`set${ucfirst(k)}`](props[k])
        });
        
        return this;
    }

    updater(key, state) {
        if (typeof key === 'string') {
            key = key.split('.');
        }

        this.state = this.state.setIn(key, state);
    };

    updateMenu(updater) {
        const key = ['sidebar', 'menus'];
        const menus = this.state.getIn(key) || new Immutable.Map();
        this.updater(key, menus.withMutations(updater));
    };

    updateBranding(updater) {
        const key = ['sidebar', 'brand'];
        const brand = this.state.getIn(key) || new Immutable.Map();
        this.updater(key, brand.withMutations(updater));
    };

    updateUser(updater) {
        const key = ['menubar', 'user'];
        this.updater(key, this.state.getIn(key).withMutations(updater));
    };

    updateNavbar(updater) {
        const key = ['menubar', 'navbar'];
        this.updater(key, this.state.getIn(key).withMutations(updater));
    };

    setTitle(title) {
        this.updater(['menubar', 'title'], title);
    };

    setToolbar(type, content) {
        this.updater(['toolbar', type], content);
    };

    setToolbarHeader(content) {
        this.updater(['toolbar', 'header'], content);
    };

    setToolbarFooter(content) {
        this.updater(['toolbar', 'footer'], content);
    };

    setBreadcrumb(breadcrumb) {
        this.updater(['breadcrumb'], breadcrumb);
    };

    setFlash(flash) {
        this.updater(['flash'], flash);
    };

    setContent(content) {
        this.updater('content', content);
    };

    createMap(items) {
        return Immutable.fromJS(items);
    }
};
