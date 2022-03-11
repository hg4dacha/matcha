import React from 'react';
import Button from 'react-bootstrap/Button'
import { IoReturnUpBack } from "react-icons/io5";

import selfie22 from '../../images/selfie22.jpg'




const BlockedUser = () => {
    
    const previousPage = () => {
        window.history.back()
        return false
    }


    return (
        <div className='blocked-profile-div'>
            <div className='blocked-profile-contain b-user'>
                <div className='blocked-user-image-div-div'>
                    <div className='blocked-user-image-div'>
                        <img src={selfie22} alt='interlocutor' className='blocked-user-image'/>
                    </div>
                </div>
                <span className='blocked-user-username'>username-269428</span>
                <div className='info-deblocked'>
                    <span className='blocking-information'>username-269428 vous a bloqué, vous ne pouvez pas accéder à son profil.</span>
                    <Button  onClick={previousPage} variant="primary" className='centerElementsInPage blocked' style={{width: 'fit-content'}}>
                        <IoReturnUpBack style={{marginRight: '3px'}}/>Retour
                    </Button>
                </div>
            </div>
        </div>
    )
}

export default BlockedUser;