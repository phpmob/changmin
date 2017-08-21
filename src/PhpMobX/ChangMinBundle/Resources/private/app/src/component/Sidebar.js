import React, { Component } from 'react';
import PropTypes from 'prop-types';
import cls from 'classnames';

export default class Sidebar extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
    };

    render() {
        const { data } = this.props;
        const menus = data.get('menus');
        const brand = data.get('brand');

        // todo url matcher for active
        return (
            <div className="chang-sidebar">
                <a className="branding" href={brand.get('link')}>
                    <img src={brand.get('logo')} alt={brand.get('name')}/>
                    <h2>{brand.get('name')}</h2>
                </a>
                <nav className="nav-group">
                    {menus.map((item, key) => {
                        const children = item.get('children');

                        return children && children.size ? (
                            <span key={key}>
                                <h5 className="nav-group-title">{item.get('label')}</h5>
                                {children.map((child, key) => {
                                    const className = cls('nav-group-item', { active: child.get('active') });

                                    return (
                                        <a className={className} key={key} href={child.get('link')}>
                                            <icon className={child.get('icon')}/> {child.get('label')}
                                        </a>
                                    )
                                })}
                            </span>
                        ) : null;
                    })}
                </nav>
            </div>
        );
    }
}
