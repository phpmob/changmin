import React, { Component } from 'react';
import PropTypes from 'prop-types';
import cls from 'classnames';

export default class Breadcrumb extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
    };

    render() {
        const { data } = this.props;

        return (
            <div className="nav-breadcrumb" dangerouslySetInnerHTML={{ __html: data }}/>
        );
    }
}
