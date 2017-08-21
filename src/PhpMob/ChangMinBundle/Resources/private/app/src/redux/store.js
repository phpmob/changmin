import { createStore, applyMiddleware, compose } from 'redux';
import thunk from 'redux-thunk';
import reducer from './reducer';
import state from './state';

const middlewares = [
    thunk,
];

let devToolsExtension = f => f;

/* istanbul ignore if  */
if (process.env.NODE_ENV === 'dev') {
    const createLogger = require('redux-logger').createLogger;

    middlewares.push(createLogger({ collapsed: true }));

    if (window.devToolsExtension) {
        devToolsExtension = window.devToolsExtension();
    }
}

export default createStore(reducer, state, compose(
    applyMiddleware(...middlewares),
    devToolsExtension
));
