import React, { Fragment, useState, useEffect, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import { UserContext } from '../UserContext/UserContext';
import Navbar from '../NavBar/NavBar';
import ProfileHistory from './ProfileHistory';
import AlertMsg from '../AlertMsg/AlertMsg';
import { RiHistoryFill } from 'react-icons/ri';
import { GoInfo } from 'react-icons/go';
import Spinner from 'react-bootstrap/Spinner';
import axios from 'axios';









const History = () => {


    const { value, load } = useContext(UserContext);
    const loading = load[0];
    const [userLocation, setUserLocation] = useState({lat: '', lng: ''});
    const navigate = useNavigate();
    const [initialRequest, setInitialRequest] = useState(false);
    const [visitedProfilesHistory, setVisitedProfilesHistory] = useState(false);

    useEffect( () => {

        document.title = 'Historique - Matcha';

        if(!loading) {

            if(!initialRequest) {
                axios.get(`/history/data`)
                .then( (response) => {
                    if (response.status === 200)
                    {
                        setUserLocation({lat: value[0].user.lat, lng: value[0].user.lng});
                        setVisitedProfilesHistory(response.data);
                    }
                })
                .catch( (error) => {
                    if(error.request.status === 401) {
                        navigate("/signin");
                    }
                })
            }

            setInitialRequest(true);

        }

    }, [loading, value, initialRequest, navigate])




// _-_-_-_-_-_-_-_-_- ALERT -_-_-_-_-_-_-_-_-_


    const [alertMessages, setAlertMessages] = useState([])


    const handleNewAlert = (newAlert) => {

        setAlertMessages(prevState => prevState.slice(1));
        setAlertMessages(prevState => [...prevState, newAlert]);
    }

    const successAlert = (id) => {
        handleNewAlert({id: id,
                        variant: "info",
                        information: "Supprimé"})
    }

    const errorAlert = (id) => {
        handleNewAlert({id: id,
                        variant: "error",
                        information: "Oups ! Erreur..."})
    }




    return (
        <Fragment>
            {
                alertMessages.map( alert => {
                    return (
                        <AlertMsg
                            key={alert.id}
                            variant={alert.variant}
                            information={alert.information}
                        />
                    )
                })
            }
            <Navbar />
            <div className='history-container'>
                <div className='history-tittle-div'>
                    <hr className='history-hr' />
                    <div className='history-tittle'>
                        <RiHistoryFill style={{marginRight: '2px'}} />
                        Historique des profils visités
                    </div>
                </div>
                {
                    visitedProfilesHistory.length < 1 ?
                    <div className='notifications-empty'>
                        <GoInfo className='historical-empty-logo' />
                        Historique des profils visités vide
                    </div> :
                    visitedProfilesHistory !== false ?
                    visitedProfilesHistory.map( data => {
                        return (
                            <ProfileHistory
                                key={data.id}
                                id={data.id}
                                username={data.username}
                                age={data.birthdate}
                                popularity={data.popularity}
                                location={{ latitude: data.lat, longitude: data.lng }}
                                thumbnail={data.thumbnail}
                                currentUserLocation={{ latitude: userLocation.lat, longitude: userLocation.lng }}
                                visitDate={data.visitDate}
                                visitedProfilesHistory={visitedProfilesHistory}
                                setVisitedProfilesHistory={setVisitedProfilesHistory}
                                successAlert={successAlert}
                                errorAlert={errorAlert}
                            />
                        )
                    }) :
                    <div className='loading-cards'>
                        <Spinner animation="border" variant="primary" className='loading-cards-spinner'/>
                        Chargement...
                    </div>
                }
                </div>
        </Fragment>
    )
}

export default History;