import React, { Fragment, useState, useEffect } from 'react';
import Navbar from '../NavBar/NavBar';
import ProfileHistory from './ProfileHistory';
import { RiHistoryFill } from 'react-icons/ri';
import { GoInfo } from 'react-icons/go';

import { USERS_LIST } from "../../other/USERS_LIST";
const currentUserLocation = { latitude: 48.856614, longitude: 2.3522219 };








const History = () => {

    useEffect( () => {
        document.title = 'Historique - Matcha'
    }, [])


    const [visitedProfilesHistory, setVisitedProfilesHistory] = useState(USERS_LIST)




    return (
        <Fragment>
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
                visitedProfilesHistory.map( data => {
                    return (
                        <ProfileHistory
                            key={data.id}
                            id={data.id}
                            username={data.username}
                            age={data.age}
                            popularity={data.popularity}
                            location={data.location}
                            thumbnail={data.thumbnail}
                            currentUserLocation={currentUserLocation}
                            visitedProfilesHistory={visitedProfilesHistory}
                            setVisitedProfilesHistory={setVisitedProfilesHistory}
                        />
                    )
                })
                }
                </div>
        </Fragment>
    )
}

export default History;