import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Badge extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
        type: PropTypes.string,
        pill: PropTypes.bool,
    };

    render() {
        const { type, data, pill } = this.props;

        if (data === '' || data === null) return null;

        const cls = `badge badge-${type || 'danger'}${pill === false ? '' : ' badge-pill'}`;

        return (
            <span className={cls}>{data}</span>
        );
    }
}
