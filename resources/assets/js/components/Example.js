import React, { Component } from 'react';

import { Container,  Row,  Col } from 'react-bootstrap';

import Button from 'react-bootstrap/Button';

export default class Example extends Component {
    render() {
        return (
            <div className="container">
                <div className="row justify-content-center">
                    <div className="col-md-8">
                        <div className="card">
                            <div className="card-header">Example Component</div>

                            <div className="card-body">
                                I'm an example component!
                            </div>
                            <Button variant="primary">Primary</Button>
                        </div>
                    </div>
                </div>
            </div>
        );
    }
}
