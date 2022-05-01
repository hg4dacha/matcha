import React, { useState, useEffect, Fragment, useContext } from 'react';
import { useLocation, useNavigate } from 'react-router-dom';
import { createBrowserHistory } from "history";
import FormsHeader from '../FormsHeader/FormsHeader';
import { Link } from 'react-router-dom'
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import AlertMsg from '../AlertMsg/AlertMsg';
import { EMAIL_REGEX, PASSWORD_REGEX } from '../../other/Regex';
import { MdEmail } from 'react-icons/md';
import { BsFillShieldLockFill } from 'react-icons/bs';
import { BiNetworkChart } from 'react-icons/bi';
import { RiErrorWarningLine } from 'react-icons/ri';
import { IoShieldCheckmarkOutline } from 'react-icons/io5';
import Spinner from 'react-bootstrap/Spinner';
import { UserContext } from '../UserContext/UserContext';
import axios from 'axios';







const SignIn = () => {


    const { value } = useContext(UserContext);

    const[user, setUser] = value;

    const location = useLocation();
    const navigate = useNavigate();
    const history = createBrowserHistory();


    useEffect( () => {

        if(user !== null) {
            navigate("/users");
        }
        else {
            document.title = 'Connexion - Matcha';

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
            else if(location.state === 'logout')
            {
                handleNewAlert({id: Math.random(), variant: "info", information: "Déconnexion"});
            }
            history.replace({...history.location, state: null })
        }

    // eslint-disable-next-line react-hooks/exhaustive-deps
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


    const [spinner, setSpinner] = useState(false)

    const [errorMessage, setErrorMessage] = useState({ display: false, msg: "" })
    const [successMessage, setSuccessMessage] = useState(false)


    const handleSubmit = e => {
        e.preventDefault()
        setSuccessMessage(false);

        if (email !== '' && password !== '' && EMAIL_REGEX.test(email) && PASSWORD_REGEX.test(password))
        {
            setErrorMessage({ display: false, msg: "" })
            setSpinner(true);

            axios.post('/users/identification', data)
            .then( (response) => {
                setData({
                    email: '',
                    password: ''
                })
                setSpinner(false);
                setUser(response.data);
                if (response.status === 200)
                {
                    navigate("/users");
                }
                else if (response.status === 206)
                {
                    navigate("/complete-profile");
                }
            })
            .catch( (error) => {
                setSpinner(false);
                if (error.request.statusText && error.request.statusText === 'registration invalidated')
                {
                    setErrorMessage({ display: true, msg: "Votre inscription n'as pas été validé par email" })
                }
                else
                {
                    setErrorMessage({ display: true, msg: "Certaines de vos entrées ne sont pas valides" })
                }
            })

        }
        else
        {
            setErrorMessage({ display: true, msg: "Vos entrées ne sont pas valides" })
        }
    }

    // ALERT ↓↓↓
    const [alertMessages, setAlertMessages] = useState([])
    const handleNewAlert = (newAlert) => {

        setAlertMessages(prevState => prevState.slice(1));
        setAlertMessages(prevState => [...prevState, newAlert]);
    }
    

    return (
        <Fragment>
            {alertMessages.map( alert => {
                return (
                    <AlertMsg
                        key={alert.id}
                        variant={alert.variant}
                        information={alert.information}
                    />
                )
            })}
            <FormsHeader />
            <section className='centerElementsInPage FormsSection'>
                <div className='centerElementsInPage formContent sectionContentSize'>
                    <div className='tittleDiv'>
                        <BiNetworkChart size='28' className='iconsFormsTittles' />
                        <span className='FormsTittle'>Connexion</span>
                    </div>
                    <span className='center paragrInfo'>Pas encore de compte?
                        <Link to='/signup' style={{fontStyle: 'initial', marginLeft: '8px'}}>
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
                            <Link to='/forgot-password' className='forgotPassword' >Mot de passe oubllié?</Link>
                        </div>
                        <Button variant="primary" type='submit' className='submitBtnSmall' disabled={true}>
                            {spinner ? <Spinner className='mr-1' as="span" animation="border" size="sm" role="status" aria-hidden="true"/> : null}
                            Connexion
                        </Button>

                    </Form>
                </div>
            </section>
        </Fragment>
    )
}

export default SignIn