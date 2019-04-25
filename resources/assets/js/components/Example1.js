import React, { Component } from 'react';
//import ReactDOM from 'react-dom';

//import { Container, Row, Col } from 'bootstrap-4-react';
import { Container,  Row,  Col } from 'react-bootstrap';

export default class Example1 extends Component {
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">1. Example Component</div>

                            <div className="card-body">
                                1. I'm an example component!
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}

//if (document.getElementById('example')) {
//    ReactDOM.render(<Example1 />, document.getElementById('example'));
//}
