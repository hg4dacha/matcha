import React from 'react';
import { Link } from 'react-router-dom'


import selfie22 from '../../images/selfie22.jpg'






const Card = () => {

    return (
        <Link to="/MemberProfile">
            <div className='card-container'>
                <div className='card-picture-content'>
                    <img src={selfie22} alt='user' className='card-picture'/>
                </div>
            </div>
        </Link>
    )
}

export default Card;