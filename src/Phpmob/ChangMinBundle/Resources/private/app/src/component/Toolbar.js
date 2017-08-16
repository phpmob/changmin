import React, { Component } from 'react';
import PropTypes from 'prop-types';

export default class Toolbar extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
        type: PropTypes.string.isRequired,
    };

    render() {
        const { type } = this.props;
        const content = this.props.data.get(type);
        const className = `pane-toolbar pane-toolbar-${type}`;

        if (!content) return null;

        return (
            <div className={className} dangerouslySetInnerHTML={{ __html: content }}/>
        );
    }
}
