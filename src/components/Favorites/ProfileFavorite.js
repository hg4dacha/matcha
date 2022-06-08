import React, { useState, useEffect } from 'react';
import Card from '../Card/Card';
import { IoMdHeartDislike } from 'react-icons/io';
import axios from 'axios';








const ProfileFavorite = ({ id, username, age, popularity, location, thumbnail, currentUserLocation,
                           favoriteProfiles, setFavoriteProfiles, successAlert, errorAlert }) => {



    const [hideProfile, setHideProfile] = useState(false)
    const [deleteProfile, setDeleteProfile] = useState(false)


    let deleteTimeOut = null;

    const handleDeleteProfil = e => {

        axios.delete(`/favorites/delete/${id}`)
        .then( (response) => {
            if (response.status === 200)
            {
                setHideProfile(true)
                deleteTimeOut = setTimeout( () => {
                    setDeleteProfile(true);
                    setFavoriteProfiles( (favoriteProfiles.filter( profil => profil.id !== id)) );
                    successAlert(id);
                } , 200)
            }
        })
        .catch( () => {
            errorAlert();
        })

    }

    useEffect( () => {
        return () => clearTimeout(deleteTimeOut);
    }, [deleteTimeOut])


    return (
        <div className={`history-card-content ${hideProfile ? "profile-hide" : ""} ${deleteProfile ? "profile-delete" : ""}`}>
            <button id={id} className='favorites-dislike' onClick={handleDeleteProfil}>
                <IoMdHeartDislike className='favorites-dislike-logo' />
            </button>
            <Card
                userid={`/users/${id}`}
                username={username}
                age={age}
                popularity={popularity}
                location={location}
                thumbnail={thumbnail}
                currentUserLocation={currentUserLocation}
            />
        </div>
    )
}

export default ProfileFavorite;