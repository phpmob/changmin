import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { Provider } from 'react-redux';

class Root extends Component {
    static propTypes = {
        store: PropTypes.object.isRequired,
    };

    render() {
        return (
            <Provider store={this.props.store}>
                {this.props.children}
            </Provider>
        );
    }
}

export default Root;
