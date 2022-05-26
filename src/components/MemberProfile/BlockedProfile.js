import React, { Fragment, useEffect, useState } from 'react';
import { useParams } from 'react-router-dom';
import ConfirmWindow from '../ConfirmWindow/ConfirmWindow';
import Button from 'react-bootstrap/Button'
import { BiLockOpenAlt } from "react-icons/bi";
import axios from 'axios';






const BlockedProfile = (props) => {

    const params = useParams();

    const [userData, setUserData] = useState({
        username: '',
        thumbnail: ''
    });


    useEffect( () => {

        axios.get(`/blocked/data/${params.userid}`)
        .then( (response) => {
            if (response.status === 200)
            {
                setUserData({
                    username: response.data.username,
                    thumbnail: response.data.thumbnail
                });
            }
        })
        .catch( () => {})

    }, [params.userid])


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
                    <div className='blocked-user-image-div'>
                        {userData.thumbnail && <img src={userData.thumbnail} alt='interlocutor' className='blocked-user-image'/>}
                    </div>
                    <span className='blocked-user-username'>{userData.username}</span>
                    <div className='info-deblocked'>
                        <span className='blocking-information'>{`${userData.username} est bloqué, vous ne pouvez pas accéder à son profil.`}</span>
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