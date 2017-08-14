import React, { Component } from 'react';
import PropTypes from 'prop-types';
import cls from 'classnames';

export default class Toolbar extends Component {
    static propTypes = {
        data: PropTypes.object.isRequired,
    };

    render() {
        const { data } = this.props;
        const actions = data.get('actions').valueSeq();
        const title = data.get('title');

        return (
            <div>Toolbar</div>
        );
    }
}
