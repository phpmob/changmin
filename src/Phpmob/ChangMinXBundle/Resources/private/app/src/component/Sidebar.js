import React, { Component } from 'react';
import PropTypes from 'prop-types';
import cls from 'classnames';

export default class Sidebar extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
    };

    render() {
        const { data } = this.props;
        const menus = data.get('menus').valueSeq();

        return (
            <div className="chang-sidebar">
                <nav className="nav-group">
                    {menus.map(item => {

                        if (!item.children.size) return null;

                        return (
                            <span key={item.key}>
                                <h5 className="nav-group-title">{item.label}</h5>
                                {item.children.valueSeq().map(child => {
                                    const className = cls('nav-group-item', { active: child.active });

                                    return (
                                        <a className={className} key={child.key}>
                                            <span className="icon icon-home"/>
                                            {child.label}
                                        </a>
                                    )
                                })}
                            </span>
                        )
                    })}
                </nav>
            </div>
        );
    }
}
