import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';

import Sidebar from './component/Sidebar'
import Toolbar from './component/Toolbar'

class App extends Component {
    static propTypes = {
        state: PropTypes.object,
    };

    render() {
        const content = this.props.state.get('content');
        const sidebar = this.props.state.get('sidebar');
        const toolbar = this.props.state.get('toolbar');

        return (
            <div className="window">
                <div className="window-content">
                    <div className="pane-group">
                        <div className="pane pane-sm sidebar">
                            <Sidebar data={sidebar}/>
                        </div>
                        <div className="pane">
                            <Toolbar data={toolbar}/>
                            <div className="pane-content" dangerouslySetInnerHTML={{ __html: content }}/>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

function mapStateToProps(state) {
    return {
        state
    };
}

export default connect(
    mapStateToProps,
)(App);
