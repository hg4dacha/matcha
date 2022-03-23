import React, { Fragment, useState, useEffect } from 'react';
import Navbar from '../NavBar/NavBar';
import Card from '../Card/Card';
import { IoMdHeartDislike } from 'react-icons/io';
import { RiHeart3Line } from 'react-icons/ri';
import { CgSmileSad } from 'react-icons/cg';

import { USERS_LIST } from "../../other/USERS_LIST";
const currentUserLocation = { latitude: 48.856614, longitude: 2.3522219 };








const Favorites = () => {

    useEffect( () => {
        document.title = 'Favoris - Matcha'
    }, [])


    const [favoriteProfiles, setFavoriteProfiles] = useState(USERS_LIST)

    const [hideProfile, setHideProfile] = useState(false)
    const [deleteProfile, setDeleteProfile] = useState(false)


    const handleDeleteProfil = e => {

        setHideProfile(true)
        setTimeout( () => {
            setDeleteProfile(true);
            setFavoriteProfiles( (favoriteProfiles.filter( profil => profil.id !== e.currentTarget.id)) );
        } , 200)
    }



    return (
        <Fragment>
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
                favoriteProfiles.map( data => {
                    return (
                        <div key={data.id} className='history-card-content'>
                            <button id={data.id} className='favorites-dislike' onClick={handleDeleteProfil}>
                                <IoMdHeartDislike className='favorites-dislike-logo' />
                            </button>
                            <Card
                                username={data.username}
                                age={data.age}
                                popularity={data.popularity}
                                location={data.location}
                                thumbnail={data.thumbnail}
                                currentUserLocation={currentUserLocation}
                            />
                        </div>
                    )
                })
                }
            </div>
        </Fragment>
    )
}

export default Favorites;