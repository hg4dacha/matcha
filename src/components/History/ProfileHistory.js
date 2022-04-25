import React, { useEffect, useState } from 'react';
import Card from '../Card/Card';
import { IoClose } from 'react-icons/io5';









const ProfileHistory = ({ id, username, age, popularity, location, thumbnail, currentUserLocation,
                          visitedProfilesHistory, setVisitedProfilesHistory, successAlert, errorAlert }) => {



    const [hideProfile, setHideProfile] = useState(false)
    const [deleteProfile, setDeleteProfile] = useState(false)


    let deleteTimeOut = null;

    const handleDeleteProfil = e => {

        const currentProfileID = e.currentTarget.id;

        setHideProfile(true)

        deleteTimeOut = setTimeout( () => {
            setDeleteProfile(true);
            setVisitedProfilesHistory( (visitedProfilesHistory.filter(profile => profile.id !== currentProfileID)) );
            successAlert(currentProfileID);
        } , 200)
    }

    useEffect( () => {
        return () => clearTimeout(deleteTimeOut);
    }, [deleteTimeOut])




    return (
        <div className={`history-card-content ${hideProfile ? "profile-hide" : ""} ${deleteProfile ? "profile-delete" : ""}`}>
            <div className='history-date-and-close-content'>
                <span className='history-date'>{`${new Date('2021-01-17T03:24:00').toLocaleDateString('fr-FR', {day: '2-digit', month: 'short', year: 'numeric'})} - ${new Date('2021-06-17T03:24:00').toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}`}</span>
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