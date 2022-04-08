import React, { useState, useEffect, Fragment } from 'react';
import FormsHeader from '../FormsHeader/FormsHeader';
import { PASSWORD_REGEX } from '../../other/Regex';
import { Link } from 'react-router-dom';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import { BsFillShieldLockFill } from 'react-icons/bs';
import { IoLockOpen } from 'react-icons/io5';
import { RiErrorWarningLine } from 'react-icons/ri';
import { TiInfoOutline } from 'react-icons/ti'
import { useParams, useNavigate } from 'react-router-dom';
import axios from 'axios';
import Spinner from 'react-bootstrap/Spinner';





const NewPassword = () => {

    useEffect( () => {
        document.title = 'Nouveau mot de passe - Matcha'
    }, [])

    const params = useParams();
    const navigate = useNavigate();

    
    const loginData = {
        password: '',
        passwordConfirmation: ''
    }
    
    const [data, setData] = useState(loginData);
    
    const { password, passwordConfirmation } = data
    
    useEffect( () => {
        const btn = document.querySelector('.submitBtnLarge');
        
        password !== '' && passwordConfirmation !== '' ?
        btn.removeAttribute('disabled') :
        btn.setAttribute('disabled', 'true') ;
    })
    
    
    const handleChange = e => {
        setData({...data, [e.target.id]: e.target.value});
    }
    
    const [spinner, setSpinner] = useState(false)

    const [errorMessage, setErrorMessage] = useState({ display: false, msg: "" })

    
    const handleSubmit = e => {
        e.preventDefault()
        setErrorMessage({ display: false, msg: "" })

        if (password !== '' && passwordConfirmation !== '' && PASSWORD_REGEX.test(password) && password === passwordConfirmation)
        {
            setSpinner(true);
            const newPasswordData = {
                userID: params.userID,
                token: params.token,
                newPassword: password,
                newPasswordConfirm: passwordConfirmation
            } 
            // axios
            axios.patch('/users/reset', newPasswordData)
            .then( (response) => {
                if (response.status === 200)
                {
                    console.log(response)
                    navigate("/SignIn", {state: true});
                }
            })
            .catch( (error) => {
                if (error.request.statusText === 'error password')
                {
                    setErrorMessage({ display: true, msg: "Vos entrées ne sont pas valides" })
                }
                else {
                    navigate("/NotFound");
                }
            })
        }
        else {
            setErrorMessage({ display: true, msg: "Vos entrées ne sont pas valides" })
        }
    }


    return (
        <Fragment>
            <FormsHeader />
            <section className='centerElementsInPage FormsSection'>
                <div className='centerElementsInPage formContent sectionContentSize'>
                    <div className='tittleDiv'>
                        <IoLockOpen size='23' className='iconsFormsTittles' />
                        <span className='FormsTittle'>Nouveau mot de passe</span>
                    </div>
                    <span className='center paragrInfo'>Entrer un nouveau mot de passe.</span>

                    <Form className='forms' autoComplete="off" onSubmit={handleSubmit}>

                        {/* password */}
                        <Form.Group controlId="password">
                            <Form.Control onChange={handleChange} value={password} type="password" maxLength="250" required />
                            <div className='label-group'>
                                <BsFillShieldLockFill size='15' className='iconsFormsInputs' />
                                <Form.Label>Nouveau mot de passe</Form.Label>
                            </div>
                            <Form.Text className='smallOnFocus'><TiInfoOutline style={{marginTop: '-2px', marginRight: '2px'}} />6 caract. min, 1 majusc., 1 chiffre et 1 caract. spécial.</Form.Text>
                        </Form.Group>

                        {/* passwordConfirmation */}
                        <Form.Group controlId="passwordConfirmation">
                            <Form.Control onChange={handleChange} value={passwordConfirmation} type="password" maxLength="250" required />
                            <div className='label-group'>
                                <BsFillShieldLockFill size='15' className='iconsFormsInputs' color='#2c3e50' />
                                <Form.Label style={{color: '#2c3e50'}}>Confirmez le nouveau mot de passe</Form.Label>
                            </div>
                        </Form.Group>

                        <div className='centerElementsInPage' style={{position:'relative', width: '100%'}}>
                            <Form.Text className={`signin-message error ${errorMessage.display ? "display" : ""}`}>
                                <RiErrorWarningLine />
                                {errorMessage.msg}
                            </Form.Text>
                            <Link to='/SignIn' className='forgotPassword' >Annuler</Link>
                        </div>

                        <Button variant="primary" type='submit' className='submitBtnLarge' disabled={true}>
                            {spinner ? <Spinner className='mr-1' as="span" animation="border" size="sm" role="status" aria-hidden="true"/> : null}
                            Réinitialiser le mot de passe
                        </Button>

                    </Form>
                </div>
            </section>
        </Fragment>
    )
}

export default NewPassword