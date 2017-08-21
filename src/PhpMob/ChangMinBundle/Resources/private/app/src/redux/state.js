import { Map } from 'immutable';

export default new Map({
    content: '',
    breadcrumb: '',
    flash: '',
    sidebar: new Map({
        menus: new Map(),
        brand: new Map({
            logo: 'data:image/png;base64,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',
            name: 'Changmin',
            link: '/',
        }),
    }),
    menubar: new Map({
        title: '',
        navbar: new Map(),
        user: new Map({
            avatar: '',
            name: '',
            menu: new Map(),
        })
    }),
    toolbar: new Map({
        header: '',
        footer: '',
    }),
})
