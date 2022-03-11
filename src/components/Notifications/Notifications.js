import React, { Fragment } from 'react';
import Navbar from '../NavBar/NavBar';
import NotificationAlert from './NotificationAlert';
import { RiHistoryFill } from 'react-icons/ri';
import { BiNotification } from 'react-icons/bi';
import { CgSmileSad } from 'react-icons/cg';
import { GoInfo } from 'react-icons/go';



import selfie22 from '../../images/selfie22.jpg'
const userName = 'User-934'



const Notifications = () => {

    return (
        <Fragment>
            <Navbar />
            <div className='notifications-container'>
                <div>
                    <div className='notifications-tittle-div'>
                        <hr className='notification-hr' />
                        <div className='notifications-tittle'>
                            <BiNotification />
                            Nouvelles notifications
                        </div>
                    </div>
                    <div className='notifications-tittle-container'>
                        <NotificationAlert
                            userImage={selfie22}
                            userName={userName}
                            notificationDate='2021-06-17T03:24:00'
                        />
                        <NotificationAlert
                            userImage={selfie22}
                            userName={userName}
                            notificationDate='2022-11-02T09:01:00'
                        />
                        <span className='notifications-empty'>
                            <CgSmileSad className='new-notif-empty-logo' />
                            Pas de nouvelles notifications pour le moment
                        </span>
                    </div>
                </div>
                <div>
                    <div className='notifications-tittle-div'>
                        <hr className='notification-hr' />
                        <div className='notifications-tittle'>
                            <RiHistoryFill />
                            Historique
                        </div>
                    </div>
                    <div className='notifications-tittle-container'>
                        <NotificationAlert
                            userImage={selfie22}
                            userName={userName}
                            notificationDate='1995-12-17T03:24:00'
                        />
                        <span className='notifications-empty'>
                            <GoInfo className='historical-empty-logo' />
                            Historique de notifications vide
                        </span>
                    </div>
                </div>
            </div>
        </Fragment>
    )
}

export default Notifications