import React, { useEffect, useState } from 'react';
import Card from '../Card/Card';
import { IoClose } from 'react-icons/io5';
import axios from 'axios';









const ProfileHistory = ({ id, username, age, popularity, location, thumbnail, currentUserLocation, visitDate,
                          visitedProfilesHistory, setVisitedProfilesHistory, successAlert, errorAlert }) => {



    const [hideProfile, setHideProfile] = useState(false)
    const [deleteProfile, setDeleteProfile] = useState(false)


    let deleteTimeOut = null;

    const handleDeleteProfil = e => {

        axios.delete(`/history/delete/${id}`)
        .then( (response) => {
            if (response.status === 200)
            {
                setHideProfile(true)
                deleteTimeOut = setTimeout( () => {
                    setDeleteProfile(true);
                    setVisitedProfilesHistory( (visitedProfilesHistory.filter(profile => profile.id !== id)) );
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
            <div className='history-date-and-close-content'>
                <span className='history-date'>{`${new Date(visitDate).toLocaleDateString('fr-FR', {day: '2-digit', month: 'short', year: 'numeric'})} - ${new Date(visitDate).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}`}</span>
                <button id={id} className='history-close' onClick={handleDeleteProfil}>
                    <IoClose className='history-close-logo'/>
                </button>
            </div>
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

export default ProfileHistory;