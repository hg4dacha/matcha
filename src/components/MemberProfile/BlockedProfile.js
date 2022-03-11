import React, { Fragment, useState } from 'react';
import ConfirmWindow from '../ConfirmWindow/ConfirmWindow';
import Button from 'react-bootstrap/Button'
import { BiLockOpenAlt } from "react-icons/bi";


import selfie22 from '../../images/selfie22.jpg'





const BlockedProfile = (props) => {

    const unblockProfile = () => {
        props.onUnblockConfirmation()
    }

    // CONFIRMATION WINDOW ↓↓↓
    const [confirmWindow, setConfirmWindow] = useState(false)

    const displayConfirmWindow = () => {
        setConfirmWindow(true)
    }

    const confirmationWindow = confirmWindow ?
                               <ConfirmWindow
                                    act="Débloquer l'utilisateur"
                                    quest="débloquer l'utilisateur"
                                    onCancel={setConfirmWindow}
                                    onConfirm={unblockProfile}
                               /> :
                               null ;

    return (
        <Fragment>
            {confirmationWindow}
            <div className='blocked-profile-div'>
                <div className='blocked-profile-contain b-profile'>
                    <div className='blocked-user-image-div-div'>
                        <div className='blocked-user-image-div'>
                            <img src={selfie22} alt='interlocutor' className='blocked-user-image'/>
                        </div>
                    </div>
                    <span className='blocked-user-username'>username-269428</span>
                    <div className='info-deblocked'>
                        <span className='blocking-information'>username-269428 est bloqué, vous ne pouvez pas accéder à son profil.</span>
                        <Button onClick={displayConfirmWindow} variant="secondary" className='centerElementsInPage blocked' style={{width: 'fit-content'}}>
                            <BiLockOpenAlt/>Débloquer
                        </Button>
                    </div>
                </div>
            </div>
        </Fragment>
    )
}

export default BlockedProfile;