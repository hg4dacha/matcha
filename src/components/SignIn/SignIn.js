import React, { useState, useEffect, Fragment } from 'react';
import { useLocation } from 'react-router-dom';
import FormsHeader from '../FormsHeader/FormsHeader';
import { Link } from 'react-router-dom'
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { EMAIL_REGEX, PASSWORD_REGEX } from '../../other/Regex';
import { MdEmail } from 'react-icons/md';
import { BsFillShieldLockFill } from 'react-icons/bs';
import { BiNetworkChart } from 'react-icons/bi';
import { RiErrorWarningLine } from 'react-icons/ri';
import { IoShieldCheckmarkOutline } from 'react-icons/io5';








const SignIn = () => {

    useEffect( () => {
        document.title = 'Connexion - Matcha'
    }, [])

    const location = useLocation();

    useEffect( () => {
            if(location.state === 'confirm')
            {
                setSuccessMessage(true);
                setErrorMessage({ display: true, msg: "Felicitations ! Vous pouvez desormais vous connecter" });
            }
            else if(location.state === 'password')
            {
                setSuccessMessage(true);
                setErrorMessage({ display: true, msg: "Le mot de passe a été modifié" });
            }
    }, [location.state])
    

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


    const [errorMessage, setErrorMessage] = useState({ display: false, msg: "" })
    const [successMessage, setSuccessMessage] = useState(false)

    const handleSubmit = e => {
        e.preventDefault()

        if (email !== '' && password !== '' && EMAIL_REGEX.test(email) && PASSWORD_REGEX.test(password))
        {
            setErrorMessage({ display: false, msg: "" })
        }
        else
        {
            setErrorMessage({ display: true, msg: "Vos entrées ne sont pas valides" })
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
                    <span className='center paragrInfo'>Pas encore de compte?
                        <Link to='/SignUp' style={{fontStyle: 'initial', marginLeft: '8px'}}>
                            Inscrivez-vous
                        </Link>
                    </span>
                    
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
                            <Form.Text className={`signin-message ${successMessage ? "success" : "error"} ${errorMessage.display ? "display" : ""}`}>
                                {successMessage ? <IoShieldCheckmarkOutline className='mr-1' /> : <RiErrorWarningLine />}
                                {errorMessage.msg}
                            </Form.Text>
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