import React, { Fragment, useState, useEffect, useContext } from 'react';
import { useNavigate } from 'react-router-dom';
import { UserContext } from '../UserContext/UserContext';
import Navbar from '../NavBar/NavBar';
import ProfileFavorite from './ProfileFavorite';
import AlertMsg from '../AlertMsg/AlertMsg';
import { RiHeart3Line } from 'react-icons/ri';
import { CgSmileSad } from 'react-icons/cg';
import Spinner from 'react-bootstrap/Spinner';
import axios from 'axios';








const Favorites = () => {


    const { value, load } = useContext(UserContext);
    const loading = load[0];
    const [userLocation, setUserLocation] = useState({lat: '', lng: ''});
    const navigate = useNavigate();


    useEffect( () => {

        document.title = 'Favoris - Matcha';

        if(!loading) {
        
            axios.get(`/favorites/data`)
            .then( (response) => {
                if (response.status === 200)
                {
                    setUserLocation({lat: value[0].user.lat, lng: value[0].user.lng});
                    setFavoriteProfiles(response.data);
                }
            })
            .catch( (error) => {
                if(error.request.status === 401) {
                    navigate("/signin");
                }
            })

        }

    }, [loading, value, navigate])


    const [favoriteProfiles, setFavoriteProfiles] = useState(false)



// _-_-_-_-_-_-_-_-_- ALERT -_-_-_-_-_-_-_-_-_


    const [alertMessages, setAlertMessages] = useState([])


    const handleNewAlert = (newAlert) => {

        setAlertMessages(prevState => prevState.slice(1));
        setAlertMessages(prevState => [...prevState, newAlert]);
    }

    const successAlert = (id) => {
        handleNewAlert({id: id,
                        variant: "info",
                        information: "J'aime retiré"})
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
                        <RiHeart3Line className='mr-1' />
                        Profils favoris
                    </div>
                </div>
                {
                    favoriteProfiles.length < 1 ?
                    <div className='notifications-empty'>
                        <CgSmileSad className='historical-empty-logo' />
                        Pas de profils favoris pour le moment
                    </div> :
                    favoriteProfiles !== false ?
                    favoriteProfiles.map( data => {
                        return (
                            <ProfileFavorite
                                key={data.id}
                                id={data.id}
                                username={data.username}
                                age={data.birthdate}
                                popularity={data.popularity}
                                location={{ latitude: data.lat, longitude: data.lng }}
                                thumbnail={data.thumbnail}
                                currentUserLocation={{ latitude: userLocation.lat, longitude: userLocation.lng }}
                                favoriteProfiles={favoriteProfiles}
                                setFavoriteProfiles={setFavoriteProfiles}
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

export default Favorites;