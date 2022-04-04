import React, { useState, useEffect, Fragment } from 'react';
import FormsHeader from '../FormsHeader/FormsHeader';
import { Link } from 'react-router-dom'
import { NAMES_REGEX, USERNAME_REGEX, EMAIL_REGEX, PASSWORD_REGEX } from '../../other/Regex';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { FaIdCard } from 'react-icons/fa';
import { RiUserFill } from 'react-icons/ri';
import { MdEmail } from 'react-icons/md';
import { BsFillShieldLockFill } from 'react-icons/bs';
import { FiEdit } from 'react-icons/fi';
import { RiErrorWarningLine } from 'react-icons/ri';
import { TiInfoOutline } from 'react-icons/ti';
import { IoShieldCheckmarkOutline } from 'react-icons/io5';
import Spinner from 'react-bootstrap/Spinner'
import axios from 'axios';


const SignUp = () => {

    useEffect( () => {
        document.title = 'Inscription - Matcha'
    }, [])


    const loginData = {
        lastname: '',
        firstname: '',
        username: '',
        email: '',
        password: '',
        passwordConfirmation: ''
    }

    const [data, setData] = useState(loginData);
    
    const { lastname, firstname, username, email, password, passwordConfirmation } = data

    useEffect( () => {
        const btn = document.querySelector('.submitBtnSignUp');
        
        lastname !== '' && firstname !== '' && username !== '' &&
        email !== '' && password !== '' && passwordConfirmation !== '' ?
        btn.removeAttribute('disabled') :
        btn.setAttribute('disabled', 'true') ;
    })


    const handleChange = e => {
        setData({...data, [e.target.id]: e.target.value});
    }

    const [spinner, setSpinner] = useState(false)


    const [errorMessage, setErrorMessage] = useState({ display: false, msg: "" })
    const [successMessage, setSuccessMessage] = useState(false)

    const handleSubmit = e => {
        e.preventDefault()
        setSuccessMessage(false);

        if (lastname !== '' && firstname !== '' && username !== '' && email !== '' && password !== '' && passwordConfirmation !== '') {

            if (EMAIL_REGEX.test(email)) {

                setErrorMessage({ display: false, msg: "" })

                if (NAMES_REGEX.test(lastname) && NAMES_REGEX.test(firstname) && USERNAME_REGEX.test(username) &&
                    PASSWORD_REGEX.test(password) && password === passwordConfirmation) {

                        setErrorMessage({ display: false, msg: "" })
                        setSpinner(true);

                        axios.post('/users', data)
                        .then( (response) => {
                            if (response.status === 200)
                            {
                                setData({
                                    lastname: '',
                                    firstname: '',
                                    username: '',
                                    email: '',
                                    password: '',
                                    passwordConfirmation: ''
                                })
                                setSpinner(false);
                                setSuccessMessage(true);
                                setErrorMessage({ display: true, msg: "Un email de confirmation vous a été envoyé" })

                            }
                        })
                        .catch( (error) => {
                            console.log(error);
                            if (error.request.statusText === 'reserved email')
                            {
                                setErrorMessage({ display: true, msg: "Cet email est déjà utilisé" })
                            }
                            else if (error.request.statusText === 'reserved username')
                            {
                                setErrorMessage({ display: true, msg: "Ce nom d'utilisateur est déjà utilisé" })
                            }
                            else
                            {
                                setErrorMessage({ display: true, msg: "Certaines de vos entrées ne sont pas valides" })
                            }
                        })

                }
                else {
                    setErrorMessage({ display: true, msg: "Certaines de vos entrées ne sont pas valides" })
                }
            }
            else {
                setErrorMessage({ display: true, msg: "Adresse e-mail non valide" })
            }
        }
        else {
            setErrorMessage({ display: true, msg: "Veuillez remplir tout les champs" })
        }
    }




    return (
        <Fragment>
            <FormsHeader />
            <section className='centerElementsInPage FormsSectionSignUp'>
                <div className='centerElementsInPage formContent signUpSizeContent'>
                    <div className='tittleDiv'>
                        <FiEdit size='21' className='iconsFormsTittles' />
                        <span className='FormsTittle'>Inscription</span>
                    </div>
                    <span className='center paragrInfoSignUp'>Vous avez déjà un compte?<Link to='/SignIn' style={{fontStyle: 'initial'}}> Connectez-vous</Link></span>
                    
                    <Form className='forms' autoComplete="off" onSubmit={handleSubmit} >

                        {/* lastname */}
                        <Form.Group controlId="lastname">
                            <Form.Control onChange={handleChange} value={lastname} type="text" maxLength="30" required />
                            <div className='label-group'>
                                <FaIdCard size='15' className='iconsFormsInputs' />
                                <Form.Label>Nom</Form.Label>
                            </div>
                        </Form.Group>

                        {/* firstname */}
                        <Form.Group controlId="firstname">
                            <Form.Control onChange={handleChange} value={firstname} type="text" maxLength="30" required />
                            <div className='label-group'>
                                <FaIdCard size='15' className='iconsFormsInputs' />
                                <Form.Label>Prenom</Form.Label>
                            </div>
                        </Form.Group>

                        {/* username */}
                        <Form.Group controlId="username">
                            <Form.Control onChange={handleChange} value={username} type="text" maxLength="15" required />
                            <div className='label-group'>
                                <RiUserFill size='16' className='iconsFormsInputs' />
                                <Form.Label>Nom d'utilisateur</Form.Label>
                            </div>
                            <Form.Text className='smallOnFocus'>ex: pseudo, pseudo46, pseudo-46, pseudo_46 (15 car. max).</Form.Text>
                        </Form.Group>

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
                            <Form.Text className='smallOnFocus'><TiInfoOutline style={{marginTop: '-2px', marginRight: '2px'}} />6 caract. min, 1 majusc., 1 chiffre et 1 caract. spécial.</Form.Text>
                        </Form.Group>

                        {/* passwordConfirmation */}
                        <Form.Group controlId="passwordConfirmation">
                            <Form.Control onChange={handleChange} value={passwordConfirmation} type="password" maxLength="250" required />
                            <div className='label-group'>
                                <BsFillShieldLockFill size='15' className='iconsFormsInputs' color='#2c3e50' />
                                <Form.Label style={{color: '#2c3e50'}}>Confirmer le mot de passe</Form.Label>
                            </div>
                        </Form.Group>

                        <div className='centerElementsInPage' style={{position:'relative', width: '100%'}}>
                            <Form.Text className={`signup-message ${errorMessage.display ? "display" : ""}`} style={{color: `${successMessage ? "#198754" : ""}`}}>
                                {successMessage ?
                                <IoShieldCheckmarkOutline className='mr-1' /> :
                                <RiErrorWarningLine />
                                }
                                {errorMessage.msg}
                            </Form.Text>
                            <Button variant="primary" type='submit' className='submitBtnSignUp' disabled={true}>
                                {spinner ? <Spinner className='mr-1' as="span" animation="border" size="sm" role="status" aria-hidden="true"/> : null}
                                S'inscrire
                            </Button>
                        </div>

                    </Form>
                </div>
            </section>
        </Fragment>
    )
}

export default SignUp