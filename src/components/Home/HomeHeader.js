import React, { useState } from 'react';
import { Link } from 'react-router-dom'
import { AiOutlineMenu } from "react-icons/ai"
import LogoBis from '../Logo/LogoBis';




const HomeHeader = () => {

    const AiOutlineMenuSizeBase = window.screen.width <= 600 ? '18' : '25'
    const [AiOutlineMenuSize, setAiOutlineMenuSize] = useState(AiOutlineMenuSizeBase)


    const logoWidthBase = window.screen.width <= 600 ? '110' : '200'
    const [logoWidth, setlogoWidth] = useState(logoWidthBase)

    
    document.querySelector('body').onresize = () => {
        if (window.screen.width <= 600) {
            setAiOutlineMenuSize('18');
            setlogoWidth('110');
        } else {
            setAiOutlineMenuSize('25');
            setlogoWidth('200');
        }
    };

 

    return (
        <header className='mw-100 HomeHeader'>
            <div className='sidesDivWidth'>
                <AiOutlineMenu color='white' size={AiOutlineMenuSize} />
            </div>
            <LogoBis width={logoWidth} />
            <div className='sidesDivWidth'>
                <Link to="/SignIn" className="btn btn-outline-light sign-in" role="button">Se connecter</Link>
            </div>
        </header>
    );
}

export default HomeHeader