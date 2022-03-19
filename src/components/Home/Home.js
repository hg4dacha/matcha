import React from 'react'
import { Link } from 'react-router-dom'
import LogoBis from '../Logo/LogoBis';






const Home = () => {

    return (
            <div className='home-content'>
                <header className='home-header'>
                    <LogoBis width='150' />
                    <div className='signup-signin-buttons'>
                        <Link to="/SignUp" className="btn btn-outline-light signup-button" role="button">S'inscrire</Link>
                        <Link to="/SignIn" className="btn btn-light signin-button" role="button">Se connecter</Link>
                    </div>
                </header>
            </div>
    );
}

export default Home;