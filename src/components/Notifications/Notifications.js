import React, { Fragment } from 'react';
import Navbar from '../NavBar/NavBar';
import NotificationAlert from './NotificationAlert';
import { v4 as uuidv4 } from 'uuid';
import { RiHistoryFill } from 'react-icons/ri';
import { BiNotification } from 'react-icons/bi';
import { CgSmileSad } from 'react-icons/cg';
import { GoInfo, GoPrimitiveDot } from 'react-icons/go';



import selfie22 from '../../images/selfie22.jpg'
import jeanma1 from '../../images/jeanma1.jpg'
import jeanma2 from '../../images/jeanma2.jpg'
import jeanma3 from '../../images/jeanma3.jpg'
import selfie from '../../images/selfie.jpg'


const notificationList = [
    {
        userImage: selfie22,
        userName: "Toto-27",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit'
    },
    {
        userImage: jeanma1,
        userName: "Jean-luc",
        notificationDate: '2021-12-20T14:01:00',
        notificationType: 'message'
    },
    {
        userImage: jeanma2,
        userName: "warrior",
        notificationDate: '2021-08-12T22:59:00',
        notificationType: 'match'
    },
    {
        userImage: jeanma3,
        userName: "Ketur00",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'like'
    },
    {
        userImage: selfie,
        userName: "Momo-du-nord",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit'
    },
    {
        userImage: selfie22,
        userName: "Bilout-bilout",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'dislike'
    },
    {
        userImage: jeanma1,
        userName: "User-404",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'like'
    },
    {
        userImage: jeanma2,
        userName: "Doudou",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'message'
    },
    {
        userImage: selfie,
        userName: "Arnaud",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit'
    }
]



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
                        {
                        notificationList.length < 1
                        ?
                        <span className='notifications-empty'>
                            <CgSmileSad className='new-notif-empty-logo' />
                            Pas de nouvelles notifications pour le moment
                        </span>
                        :
                        notificationList.map( data => {
                            return (
                                <div key={uuidv4()} className='new-notif-div'>
                                    <GoPrimitiveDot className='new-notif-dot' />
                                    <NotificationAlert
                                        userImage={data.userImage}
                                        userName={data.userName}
                                        notificationDate={data.notificationDate}
                                        notificationType={data.notificationType}
                                    />
                                </div>
                            )
                        })
                        }
                    </div>
                </div>
                <div>
                    <div className='notifications-tittle-div'>
                        <hr className='notification-hr' />
                        <div className='notifications-tittle'>
                            <RiHistoryFill />
                            Historique des notifications
                        </div>
                    </div>
                    <div className='notifications-tittle-container'>
                        {
                            notificationList.length < 1
                            ?
                            <span className='notifications-empty'>
                                <GoInfo className='historical-empty-logo' />
                                Historique des notifications vide
                            </span>
                            :
                            notificationList.map( data => {
                                return (
                                    <NotificationAlert
                                        key={uuidv4()}
                                        userImage={data.userImage}
                                        userName={data.userName}
                                        notificationDate={data.notificationDate}
                                        notificationType={data.notificationType}
                                    />
                                )
                            })
                            }
                    </div>
                </div>
            </div>
        </Fragment>
    )
}

export default Notifications