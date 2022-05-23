import React, { Fragment, useEffect, useState, useContext } from 'react';
import { useParams } from 'react-router-dom';
import { v4 as uuidv4 } from 'uuid';
import Navbar from '../NavBar/NavBar';
import BlockedProfile from './BlockedProfile';
import BlockedUser from './BlockedUser';
import AccessProfile from './AccessProfile';
import { UserContext } from '../UserContext/UserContext';
import AlertMsg from '../AlertMsg/AlertMsg';
import axios from 'axios';






const MemberProfile = () => {

    const { load } = useContext(UserContext);

    const loading = load[0];

    const params = useParams();

    // PROFILE DISPLAY ↓↓↓
    const [profileStatus, setProfileStatus] = useState('')

    const [componentDisplay, setComponentDisplay] = useState(null)
    
    // ALERT ↓↓↓
    const [alertMessages, setAlertMessages] = useState([])
    

    useEffect( () => {

            if(!loading) {

            document.title = 'Profil membre - Matcha';

            axios.get(`/users/status/${params.userid}`)
            .then( (response) => {
                if (response.status === 200)
                {
                    setProfileStatus(response.data.toString());
                }
            })
            .catch( () => {

            })

        }

    }, [loading, params])
    

    useEffect( () => {


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