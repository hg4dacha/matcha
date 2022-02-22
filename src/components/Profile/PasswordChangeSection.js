import React from 'react';
import { Form } from 'react-bootstrap'
import Row from 'react-bootstrap/Row'
import Col from 'react-bootstrap/Col'





const PasswordChangeSection = (props) => {


    return (
        <Form.Group as={Row} className="mb-1" controlId={props.id}>
            <Form.Label column sm="2">
                {props.label}
            </Form.Label>
            <Col sm="10">
                <Form.Control
                    value={props.value}
                    onChange={props.handlePasswordChange}
                    placeholder={props.placeholder}
                    type="password"
                    autoComplete='off'
                    maxLength={props.maxLength}
                    className='form-control-profile'
                />
            </Col>
        </Form.Group>
    )

}

export default PasswordChangeSection