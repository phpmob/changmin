import { fromJS, Map, Record, Set, OrderedSet, OrderedMap } from 'immutable';

export const MenuItem = ({ key, label, link, icon, children = [] } = {}) => {
    return new Record({ key, label, link, icon, children: new Menu(children) })();
};

export const Menu = (menuItems = []) => {
    this.items = new Map();
    this.items = this.items.withMutations(menu => {
        menuItems.forEach(item => {
            if (!item.children instanceof Menu) {
                item.children = new Menu(item.children);
            }

            menu.set(item.key, item);
        });
    });

    this.items.addItem = (item) => {
        return this.items.set(item.key, MenuItem(item));
    };

    return this.items;
};

export default new Map({
    content: '',
    breadcrumb: '',
    sidebar: new Map({
        menus: new Menu([
            MenuItem({ key: 'favorite', label: 'Favorites' }),
        ]),
    }),
    toolbar: new Map({
        title: '',
        actions: new Menu([
            MenuItem({ key: 'favorite', label: 'Favorites' }),
        ]),
    }),
})
