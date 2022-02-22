import React, { useState, useEffect, Fragment } from 'react';
import FormsHeader from '../FormsHeader/FormsHeader';
import { Link } from 'react-router-dom'
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { MdEmail } from 'react-icons/md';
import { IoLockClosed } from 'react-icons/io5';
import { RiErrorWarningLine } from 'react-icons/ri';


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

    let EMAIL_REGEX = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})){1,255}$/;
    
    const handleSubmit = e => {
        e.preventDefault()

        let mailInput = document.querySelector('#emailError');

        if (email !== '' && EMAIL_REGEX.test(email)) {

            mailInput.classList.contains('mailErrorDisplay') &&
            mailInput.classList.remove('mailErrorDisplay')
        }
        else {
            mailInput.classList.add('mailErrorDisplay')
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
                            <Form.Text className='mailError' id='emailError'><RiErrorWarningLine style={{marginTop: '-2px', marginRight: '2px'}} />Adresse e-mail non valide</Form.Text>
                        </Form.Group>

                        <Link to='/SignIn' className='forgotPassword' >Retour à la connexion</Link>
                        <Button variant="primary" type='submit' className='submitBtnLarge' disabled={true}>Envoyer le mail de réinitialisation</Button>

                    </Form>
                </div>
            </section>
        </Fragment>
    )
}

export default ForgotPassword