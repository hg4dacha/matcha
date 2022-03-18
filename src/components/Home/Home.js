import React, { useState, useEffect } from 'react'
import { Link } from 'react-router-dom'
import LogoBis from '../Logo/LogoBis';






const Home = () => {


    const [logoWidth, setLogoWidth] = useState(window.screen.width <= 600 ? "100" : "150" )

    useEffect( () => {

        window.onresize = () => {
            if (window.screen.width <= 600) {
                setLogoWidth('100');
            } else {
                setLogoWidth('150');
            }
        }

        return () => {
            window.onresize = () => null
        }

    }, [window.screen.width])



    return (
            <div className='home-content'>
                <header className='home-header'>
                    <LogoBis width={logoWidth} />
                    <div className='signup-signin-buttons'>
                        <Link to="/SignUp" className="btn btn-outline-light signup-button" role="button">S'inscrire</Link>
                        <Link to="/SignIn" className="btn btn-light signin-button" role="button">Se connecter</Link>
                    </div>
                </header>
            </div>
    );
}

export default Home;