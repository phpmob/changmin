import React, { Component } from 'react';
import PropTypes from 'prop-types';
//import cls from 'classnames';

export default class Menubar extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
    };

    render() {
        const title = this.props.data.get('title');

        return (
            <div className="nav-menubar">
                <h1 dangerouslySetInnerHTML={{ __html: title }}/>
            </div>
        );
    }
}
