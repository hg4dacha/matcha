import React, { useState, useEffect, Fragment } from 'react';
import FormsHeader from '../FormsHeader/FormsHeader';
import { EMAIL_REGEX } from '../../other/Regex';
import { Link } from 'react-router-dom'
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { MdEmail } from 'react-icons/md';
import { IoLockClosed, IoShieldCheckmarkOutline } from 'react-icons/io5';
import { RiErrorWarningLine } from 'react-icons/ri';
import Spinner from 'react-bootstrap/Spinner';
import axios from 'axios';


const ForgotPassword = () => {

    useEffect( () => {
        document.title = 'Mot de passe oublié - Matcha'
    }, [])


    const loginData = {
        email: ''
    }
    
    const [data, setData] = useState(loginData);
    
    const { email } = data

    useEffect( () => {
        const btn = document.querySelector('.submitBtnLarge');
        
        email !== '' ?
        btn.removeAttribute('disabled') :
        btn.setAttribute('disabled', 'true') ;
    })


    const handleChange = e => {
        setData({email: e.target.value});
    }

    
    const [spinner, setSpinner] = useState(false)


    const [errorMessage, setErrorMessage] = useState({ display: false, msg: "" })
    const [successMessage, setSuccessMessage] = useState(false)

    const handleSubmit = e => {
        e.preventDefault()
        setSuccessMessage(false);


        if (email !== '' && EMAIL_REGEX.test(email))
        {
            setErrorMessage({ display: false, msg: "" })
            setSpinner(true);
            axios.patch('/users/omission', data)
            .then( (response) => {
                if (response.status === 200)
                {
                    setData({email: ''})
                    setSpinner(false);
                    setSuccessMessage(true);
                    setErrorMessage({ display: true, msg: "Un e-mail de réinitialisation a été envoyé" });
                }
            })
            .catch( (error) => {
                setSpinner(false);
                if (error.request.statusText === 'invalid email')
                {
                    setErrorMessage({ display: true, msg: "L'adresse e-mail n'est lié à aucun un compte" })
                }
            })
        }
        else
        {
            setErrorMessage({ display: true, msg: "Adresse e-mail non valide" })
        }
    }


    return (
        <Fragment>
            <FormsHeader />
            <section className='centerElementsInPage FormsSection'>
                <div className='centerElementsInPage formContent sectionContentSize'>
                    <div className='tittleDiv'>
                        <IoLockClosed size='23' className='iconsFormsTittles' />
                        <span className='FormsTittle'>Mot de passe oublié</span>
                    </div>
                    <span className='center paragrInfo'>Entrer l'adresse email de votre compte,<br />un mail de réinitialisation vous sera envoyé.</span>
                    
                    <Form className='forms' autoComplete="off" onSubmit={handleSubmit} >

                        {/* email */}
                        <Form.Group controlId="email">
                            <Form.Control onChange={handleChange} value={email} type="text" maxLength="250" required />
                            <div className='label-group'>
                                <MdEmail size='16' className='iconsFormsInputs' />
                                <Form.Label>Adresse e-mail</Form.Label>
                            </div>
                            <div className='centerElementsInPage' style={{position:'relative', width: '100%'}}>
                                <Form.Text className={`forgot-message ${successMessage ? "success" : "error"} ${errorMessage.display ? "display" : ""}`}>
                                    {successMessage ? <IoShieldCheckmarkOutline className='mr-1' /> : <RiErrorWarningLine />}
                                    {errorMessage.msg}
                                </Form.Text>
                            </div>
                        </Form.Group>
                        <Link to='/signin' className='forgotPassword' >Retour à la connexion</Link>
                        <Button variant="primary" type='submit' className='submitBtnLarge' disabled={true}>
                            {spinner ? <Spinner className='mr-1' as="span" animation="border" size="sm" role="status" aria-hidden="true"/> : null}
                            Envoyer le mail de réinitialisation
                        </Button>

                    </Form>
                </div>
            </section>
        </Fragment>
    )
}

export default ForgotPassword