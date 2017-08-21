import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Map } from 'immutable';
import cls from 'classnames';
import Badge from './Badge';

const Link = (props) => {
    const { item, ...cProps } = props;

    let badge = item.get('badge');

    if (badge instanceof Map) {
        badge = badge.toJS();
    }

    return (
        <li {...cProps}>
            <a href={item.get('link')}>
                {item.get('icon') ? <i className={item.get('icon')}/> : null} {item.get('label')}
                <Badge {...badge}/>
            </a>
        </li>
    );
};

const Avatar = (props) => {
    const { user, ...cProps } = props;

    return (
        <div {...cProps}>
            <img src={user.get('avatar')} className="avatar avatar-sm" alt={user.get('name')}/> {user.get('name')}
        </div>
    );
};

export default class Menubar extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
    };

    render() {
        const title = this.props.data.get('title');
        const user = this.props.data.get('user');
        const userMenu = user.get('menu');
        const navbar = this.props.data.get('navbar');

        return (
            <header className="navbar navbar-expand chang-menubar flex-row">
                <h1 dangerouslySetInnerHTML={{ __html: title }}/>
                <ul className="navbar-nav flex-row ml-md-auto d-none d-md-flex">
                    {navbar.size ? navbar.map((nav, key) => {
                        const menu = nav.get('menu');

                        if (menu && menu.size) {
                            return (
                                <li className="nav-item p-2 dropdown" key={key}>
                                    <a href={nav.get('link')} className="dropdown-toggle" data-toggle="dropdown"
                                       style={{ cursor: 'default' }}>
                                        {nav.get('icon') ? <i className={nav.get('icon')}/> : null} {nav.get('label')}
                                    </a>
                                    <div className="dropdown-menu dropdown-menu-right">
                                        {menu.map((m, k) => {
                                            return (<Link className="nav-item p-2" key={k} item={m}/>);
                                        })}
                                    </div>
                                </li>
                            );
                        } else {
                            return (<Link className="nav-item p-2" key={key} item={nav}/>);
                        }
                    }) : null}
                </ul>

                {userMenu && userMenu.size ? (<div className="nav-user d-none d-lg-inline-block ml-3 dropdown">
                    <Avatar user={user} className="dropdown-toggle" data-toggle="dropdown"
                            style={{ cursor: 'default' }}/>
                    <div className="dropdown-menu dropdown-menu-right">
                        {userMenu.map((menu, key) => {
                            return (
                                <a className={cls(`dropdown-item ${key}`)} key={key} href={menu.link}>
                                    {menu.icon ? <i className={menu.icon}/> : null} {menu.label}
                                </a>
                            );
                        })}
                    </div>
                </div>) : (<div className="nav-user d-none d-lg-inline-block ml-3">
                    <Avatar user={user}/>
                </div>)}
            </header>
        );
    }
}
