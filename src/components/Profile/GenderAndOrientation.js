import React, { Fragment } from 'react';
import { Form } from 'react-bootstrap'
import Row from 'react-bootstrap/Row'
import Col from 'react-bootstrap/Col'



const GenderAndOrientation = (props) => {

    return (
        <Fragment>
            <Form.Group as={Row} className="mb-3 d-flex align-items-center">
                <Form.Label column sm="2">
                    Je suis
                </Form.Label>
                <Col sm="6" className='d-flex justify-content-around'>
                    <label className='gender-and-orientation'>
                        <input
                            type="checkbox"
                            className='old-gender-check'
                            onChange={() => {
                                if (props.genderChecked.maleGender === false &&
                                    props.genderChecked.femaleGender === false)
                                {
                                    props.setGenderChecked({
                                        maleGender: true,
                                        femaleGender: false
                                    })
                                }
                                else if (props.genderChecked.maleGender === false)
                                {                                    
                                    props.setGenderChecked({
                                        maleGender: !props.genderChecked.maleGender,
                                        femaleGender: !props.genderChecked.femaleGender
                                    })
                                }
                            }}
                        />
                        <svg
                            className={`gender-check ${props.genderChecked.maleGender ? "gender-check--active" : ""}`}
                            fill={props.genderChecked.maleGender ? "#F5F5F5" : "none"}
                            stroke={props.genderChecked.maleGender ? "#F5F5F5" : "none"}
                            strokeWidth="2"
                            aria-hidden="true"
                            viewBox="0 0 512 512"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M256 76c48.1 0 93.3 18.7 127.3 52.7S436 207.9 436 256s-18.7 93.3-52.7 127.3S304.1 436 256 436c-48.1 0-93.3-18.7-127.3-52.7S76 304.1 76 256s18.7-93.3 52.7-127.3S207.9 76 256 76m0-28C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"
                            />
                            <path d="M363.5 148.5C334.8 119.8 296.6 104 256 104c-40.6 0-78.8 15.8-107.5 44.5C119.8 177.2 104 215.4 104 256s15.8 78.8 44.5 107.5C177.2 392.2 215.4 408 256 408c40.6 0 78.8-15.8 107.5-44.5C392.2 334.8 408 296.6 408 256s-15.8-78.8-44.5-107.5z"
                            />
                        </svg>
                        Un homme
                    </label>
                    <label className='gender-and-orientation'>
                        <input
                            type="checkbox"
                            className='old-gender-check'
                            onChange={() => {
                                if (props.genderChecked.maleGender === false &&
                                    props.genderChecked.femaleGender === false)
                                {
                                    props.setGenderChecked({
                                        maleGender: false,
                                        femaleGender: true
                                    })
                                }
                                else if (props.genderChecked.femaleGender === false)
                                {                                    
                                    props.setGenderChecked({
                                        maleGender: !props.genderChecked.maleGender,
                                        femaleGender: !props.genderChecked.femaleGender
                                    })
                                }
                            }}
                        />
                        <svg
                            className={`gender-check ${props.genderChecked.femaleGender ? "gender-check--active" : ""}`}
                            fill={props.genderChecked.femaleGender ? "#F5F5F5" : "none"}
                            stroke={props.genderChecked.femaleGender ? "#F5F5F5" : "none"}
                            strokeWidth="2"
                            aria-hidden="true"
                            viewBox="0 0 512 512"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path d="M256 76c48.1 0 93.3 18.7 127.3 52.7S436 207.9 436 256s-18.7 93.3-52.7 127.3S304.1 436 256 436c-48.1 0-93.3-18.7-127.3-52.7S76 304.1 76 256s18.7-93.3 52.7-127.3S207.9 76 256 76m0-28C141.1 48 48 141.1 48 256s93.1 208 208 208 208-93.1 208-208S370.9 48 256 48z"
                            />
                            <path d="M363.5 148.5C334.8 119.8 296.6 104 256 104c-40.6 0-78.8 15.8-107.5 44.5C119.8 177.2 104 215.4 104 256s15.8 78.8 44.5 107.5C177.2 392.2 215.4 408 256 408c40.6 0 78.8-15.8 107.5-44.5C392.2 334.8 408 296.6 408 256s-15.8-78.8-44.5-107.5z"
                            />
                        </svg>
                        Une femme
                    </label>
                </Col>
            </Form.Group>
            <Form.Group as={Row} className="mb-1 d-flex align-items-center">
                <Form.Label column sm="2">
                    Je cherche
                </Form.Label>
                <Col sm="6" className='d-flex justify-content-around'>
                    <label className='gender-and-orientation'>
                        <input
                            type="checkbox"
                            className='old-orientation-check'
                            onChange={() => {
                                if (props.orientationChecked.maleOrientation === true &&
                                    props.orientationChecked.femaleOrientation === false)
                                {
                                    return;
                                }
                                else
                                {
                                    props.setOrientationChecked({...props.orientationChecked, maleOrientation: !props.orientationChecked.maleOrientation});
                                }
                            }}
                        />
                        <svg
                            className={`orientation-check ${props.orientationChecked.maleOrientation ? "orientation-check--active" : ""}`}
                            fill={props.orientationChecked.maleOrientation ? "#F5F5F5" : "none"}
                            stroke={props.orientationChecked.maleOrientation ? "#F5F5F5" : "none"}
                            strokeWidth="2"
                            aria-hidden="true"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"
                                fillRule="evenodd"
                            />
                        </svg>
                        Un homme
                    </label>
                    <label className='gender-and-orientation'>
                        <input
                            type="checkbox"
                            className='old-orientation-check'
                            onChange={() => {
                                if (props.orientationChecked.femaleOrientation === true &&
                                    props.orientationChecked.maleOrientation === false)
                                {
                                    return;
                                }
                                else
                                {
                                    props.setOrientationChecked({...props.orientationChecked, femaleOrientation: !props.orientationChecked.femaleOrientation});
                                }
                            }}
                        />
                        <svg
                            className={`orientation-check ${props.orientationChecked.femaleOrientation ? "orientation-check--active" : ""}`}
                            fill={props.orientationChecked.femaleOrientation ? "#F5F5F5" : "none"}
                            stroke={props.orientationChecked.femaleOrientation ? "#F5F5F5" : "none"}
                            strokeWidth="2"
                            aria-hidden="true"
                            viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg"
                        >
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clipRule="evenodd"
                                fillRule="evenodd"
                            />
                        </svg>
                        Une femme
                    </label>
                </Col>
            </Form.Group>
        </Fragment>

    )

}

export default GenderAndOrientation