import React, { Component } from 'react';
import PropTypes from 'prop-types';
import { connect } from 'react-redux';
import { bindActionCreators } from 'redux';
import $ from 'jquery';

import { actions } from './redux/reducer'
import AppApi from './AppApi'
import Sidebar from './component/Sidebar'
import Toolbar from './component/Toolbar'

class App extends Component {
    static propTypes = {
        state: PropTypes.object,
        action: PropTypes.object,
    };

    constructor(props) {
        super(props);

        window['ChangMin'] = this.api = new AppApi(this);
    }

    componentDidMount() {
        setTimeout(() => {
            const nonce = `_${AppApi.makeid()}`;

            // todo: componet context when support render as component type.
            window[nonce] = this;

            $('script', this.refs.content).each((i, tag) => {
                $('<script>(function(context){' + $(tag).text() + '})(' + nonce + ');</script>').appendTo('body')
            })
        }, 1)
    }

    render() {
        const content = this.props.state.get('content');
        const sidebar = this.props.state.get('sidebar');
        const toolbar = this.props.state.get('toolbar');

        return (
            <div className="window">
                <div className="window-content">
                    <div className="pane-group">
                        <div className="pane pane-sm pane-sidebar">
                            <Sidebar data={sidebar}/>
                        </div>
                        <div className="pane pane-body">
                            <Toolbar data={toolbar}/>
                            <div ref="content" className="pane-content" dangerouslySetInnerHTML={{ __html: content }}/>
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

function mapDispatchToProps(dispatch) {
    return {
        action: bindActionCreators({ ...actions }, dispatch)
    };
}

export default connect(
    mapStateToProps,
    mapDispatchToProps
)(App);
