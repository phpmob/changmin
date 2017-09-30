import React from 'react';
import ReactDOM from 'react-dom';
//import registerServiceWorker from './registerServiceWorker';

import store from './redux/store';
import App from './App';
import Root from './Root';

const ReactROOT = document.getElementById('root');

if (ReactROOT) {
    ReactDOM.render(<Root store={store}><App /></Root>, ReactROOT);
}

//registerServiceWorker();
