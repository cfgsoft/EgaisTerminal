import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import 'bootstrap/dist/css/bootstrap.min.css';

import Example from './components/Example';
import Example1 from './components/Example1';

import Navigation from './components/Nawigation';

import { BrowserRouter, Route, Switch } from 'react-router-dom';

export default class Index extends Component {
  render() {
    return (
        <BrowserRouter>
          <div>
            <Navigation/>
            <Switch>
              <Route path="/admin" exact component={Example} />
              <Route path="/admin/test" exact component={Example1} />
            </Switch>
          </div>
        </BrowserRouter>
    );
  }
}

if (document.getElementById('example')) {
  ReactDOM.render(<Index />, document.getElementById('example'));
}