import React from 'react'
import { Link } from 'react-router-dom'
import HomeHeader from './HomeHeader'

const Home = () => {
    return (
            <div className='HomeContent'>
                <HomeHeader />
                <section className='HomeSection'>
                    <p className='slogan bold center'>L'amour à quelques clics...</p>
                    <Link to="/SignUp" className="btn btn-success sign-up" role="button">S'inscrire</Link>
                </section>
            </div>
    );
}

export default Home