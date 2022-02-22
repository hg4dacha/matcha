import React, { useState, useEffect, Fragment } from 'react';
import FormsHeader from '../FormsHeader/FormsHeader';
import { Link } from 'react-router-dom'
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { MdEmail } from 'react-icons/md';
import { BsFillShieldLockFill } from 'react-icons/bs';
import { BiNetworkChart } from 'react-icons/bi';
import { RiErrorWarningLine } from 'react-icons/ri';


const SignIn = () => {

    useEffect( () => {
        document.title = 'Connexion - Matcha'
    }, [])
    

    const loginData = {
        email: '',
        password: ''
    }
    
    const [data, setData] = useState(loginData);
    
    const { email, password } = data
    
    useEffect( () => {
        const btn = document.querySelector('.submitBtnSmall');
        
        email !== '' && password !== '' ?
        btn.removeAttribute('disabled') :
        btn.setAttribute('disabled', 'true') ;
    })
    
    
    const handleChange = e => {
        
        setData({...data, [e.target.id]: e.target.value});
    }

    let EMAIL_REGEX = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,})){1,255}$/;
    let PASSWORD_REGEX = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{6,255}$/;
    
    const handleSubmit = e => {
        e.preventDefault()

        let genErrSmall = document.querySelector('#generalError');

        if (email !== '' && password !== '' && EMAIL_REGEX.test(email) && PASSWORD_REGEX.test(password)) {

            genErrSmall.classList.contains('generalErrorDisplay2') &&
            genErrSmall.classList.remove('generalErrorDisplay2')
        }
        else {
            genErrSmall.classList.add('generalErrorDisplay2')
        }
    }
    

    return (
        <Fragment>
            <FormsHeader />
            <section className='centerElementsInPage FormsSection'>
                <div className='centerElementsInPage formContent sectionContentSize'>
                    <div className='tittleDiv'>
                        <BiNetworkChart size='28' className='iconsFormsTittles' />
                        <span className='FormsTittle'>Connexion</span>
                    </div>
                    <span className='center paragrInfo'>Pas encore de compte?<Link to='/SignUp' style={{fontStyle: 'initial'}}> Inscrivez-vous</Link></span>
                    
                    <Form className='forms' autoComplete="off" onSubmit={handleSubmit} >

                        {/* email */}
                        <Form.Group controlId="email">
                            <Form.Control onChange={handleChange} value={email} type="text" maxLength="250" required />
                            <div className='label-group'>
                                <MdEmail size='16' className='iconsFormsInputs' />
                                <Form.Label>Adresse e-mail</Form.Label>
                            </div>
                        </Form.Group>

                        {/* password */}
                        <Form.Group controlId="password">
                            <Form.Control onChange={handleChange} value={password} type="password" maxLength="250" required />
                            <div className='label-group'>
                                <BsFillShieldLockFill size='15' className='iconsFormsInputs' />
                                <Form.Label>Mot de passe</Form.Label>
                            </div>
                        </Form.Group>

                        <div className='centerElementsInPage' style={{position:'relative', width: '100%'}}>
                            <Form.Text className='generalError' id='generalError'><RiErrorWarningLine style={{marginTop: '-2px', marginRight: '2px'}} />Vos entrées ne sont pas valides</Form.Text>
                            <Link to='/ForgotPassword' className='forgotPassword' >Mot de passe oubllié?</Link>
                        </div>
                        <Button variant="primary" type='submit' className='submitBtnSmall' disabled={true}>Connexion</Button>

                    </Form>
                </div>
            </section>
        </Fragment>
    )
}

export default SignIn