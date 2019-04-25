import React, { Component } from 'react';
import { NavLink } from 'react-router-dom';

import LinkContainer from 'react-router-bootstrap/lib/LinkContainer';

import Navbar from 'react-bootstrap/Navbar'
import Nav from 'react-bootstrap/Nav'
import NavDropdown from 'react-bootstrap/NavDropdown'

/* https://habr.com/ru/post/310284/ */

export default class Navigation extends Component {
    render() {
        return (

          <Navbar bg="light" expand="lg">
            <Navbar.Brand href="#home">React-Bootstrap</Navbar.Brand>
            <Navbar.Toggle aria-controls="basic-navbar-nav" />

            <Navbar.Collapse id="basic-navbar-nav">

              <Nav className="mr-auto">

                <LinkContainer to='/admin'>
                  <Nav.Link>0.Home</Nav.Link>
                </LinkContainer>

                <LinkContainer to='/admin/test'>
                  <Nav.Link>0.Test</Nav.Link>
                </LinkContainer>

                <Nav.Link href="/">Home</Nav.Link>
                <Nav.Link href="#link">Link</Nav.Link>
                <NavDropdown title="Dropdown" id="basic-nav-dropdown">
                  <NavDropdown.Item href="#action/3.1">Action</NavDropdown.Item>
                  <NavDropdown.Item href="#action/3.2">Another action</NavDropdown.Item>
                  <NavDropdown.Item href="#action/3.3">Something</NavDropdown.Item>
                  <NavDropdown.Divider />
                  <NavDropdown.Item href="#action/3.4">Separated link</NavDropdown.Item>
                </NavDropdown>
              </Nav>

            </Navbar.Collapse>
          </Navbar>

          /*
          <div>
            <NavLink to="/admin">Home|</NavLink>
            <NavLink to="/admin/test">Test|</NavLink>
            <NavLink to="/admin/blog/create">Post Article</NavLink>
          </div>
          */

        );
    }
}
