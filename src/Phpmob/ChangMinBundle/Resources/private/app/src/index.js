import React from 'react';
import ReactDOM from 'react-dom';
//import registerServiceWorker from './registerServiceWorker';

import store from './redux/store';
import App from './App';
import Root from './Root';

ReactDOM.render(
    <Root store={store}><App /></Root>,
    document.getElementById('root')
);

//registerServiceWorker();
