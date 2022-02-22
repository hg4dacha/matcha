import React, { Fragment, useEffect, useState } from 'react';
import { v4 as uuidv4 } from 'uuid';
import Navbar from '../NavBar/NavBar';
import BlockedProfile from './BlockedProfile';
import BlockedUser from './BlockedUser';
import AccessProfile from './AccessProfile';
import AlertMsg from '../AlertMsg/AlertMsg';






const MemberProfile = () => {
    
    useEffect( () => {
        document.title = 'Profil membre - Matcha'
    }, [])
    
    // --------------------------------------------------------
    
    
    // PROFILE DISPLAY ↓↓↓
    const [profileStatus, setProfileStatus] = useState('200')
    
    const [componentDisplay, setComponentDisplay] = useState(null)
    

    // ALERT ↓↓↓
    const [alertMessages, setAlertMessages] = useState([])
    

    useEffect( () => {

        const handleNewAlert = (newAlert) => {

            setAlertMessages(prevState => prevState.slice(1));
            setAlertMessages(prevState => [...prevState, newAlert]);
        }


        const unblockConfirmation = () => {
            setProfileStatus('200')
            handleNewAlert({variant: "success",
                            information: "Le profil a été débloqué."})
        }

        const blockConfirmation = () => {
            setProfileStatus('302')
            handleNewAlert({variant: "info",
                            information: "Le profil a été bloqué."})
        }

        const reportConfirmation = () => {
            handleNewAlert({variant: "info",
                            information: "Le compte de cet utilisateur sera vérifié."})
        }
    
        const onLike = () => {
            handleNewAlert({variant: "success",
                            information: "J'aime !"})
        }

        const onDislike = () => {
            handleNewAlert({variant: "info",
                            information: "Le j'aime a été retiré."})
        }

        const deleteDiscussionConfirmation = () => {
            handleNewAlert({variant: "info",
                            information: "La discussion a été supprimée."})
        }

        if (profileStatus === '302') {
            setComponentDisplay(
                <BlockedProfile
                    onUnblockConfirmation={unblockConfirmation}
                />
            )
        }
        else if (profileStatus === '403') {
            setComponentDisplay(
                <BlockedUser />
            )
        }
        else if (profileStatus === '200') {
            setComponentDisplay(
                <AccessProfile
                    onLike={onLike}
                    onDislike={onDislike}
                    onBlockingConfirmation={blockConfirmation}
                    onReportConfirmation={reportConfirmation}
                    onDeleteDiscussionConfirmation={deleteDiscussionConfirmation}
                />
            )
        }
        else {
            setComponentDisplay(null)
        }

        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [profileStatus])




    return (
        <Fragment>
            <Navbar />
            {alertMessages.map( alert => {
                return (
                    <AlertMsg
                        key={uuidv4()}
                        variant={alert.variant}
                        information={alert.information}
                    />
                )
            })}
            {componentDisplay}
        </Fragment>
    )
}

export default MemberProfile;