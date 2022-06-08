import React, { Fragment, useEffect, useState, useContext } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
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
    const navigate = useNavigate();

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
                .catch( (error) => {
                    if(error.request.status === 401) {
                        navigate("/signin");
                    }
                })

        }

    }, [loading, params, navigate])
    

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
                <BlockedUser
                    onCurrentUserDeblocked={currentUserDeblocked}
                />
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
                    onCurrentUserBlocked={currentUserBlocked}
                    errorAlert={errorAlert}
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
        axios.delete('/blocked/delete', { data: params.userid })
        .then( (response) => {
            if (response.status === 200)
            {
                if(response.data.toString() === '200') {
                    setProfileStatus('200');
                }
                else if(response.data.toString() === '403') {
                    setProfileStatus('403');
                }
                handleNewAlert({
                    variant: "success",
                    information: "Le profil a été débloqué."
                });
            }
        })
        .catch( () => {})
    }

    const blockConfirmation = () => {
        axios.post('/blocked/add', params.userid)
        .then( (response) => {
            if (response.status === 200)
            {
                setProfileStatus('302')
                handleNewAlert({
                    variant: "info",
                    information: "Le profil a été bloqué."
                });
            }
        })
        .catch( (error) => {
            errorAlert();
        })
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

    const currentUserBlocked = () => {
        setProfileStatus('403')
        handleNewAlert({
            variant: "info",
            information: "Vous avez été bloqué par l'utilisateur."
        });
    }

    const currentUserDeblocked = () => {
        setProfileStatus('200')
        handleNewAlert({
            variant: "success",
            information: "Vous avez été débloqué par l'utilisateur."
        });
    }

    const errorAlert = () => {
        handleNewAlert({
            variant: "error",
            information: "Oups ! Erreur..."
        });
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