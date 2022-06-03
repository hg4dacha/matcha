import React, { useState, Fragment, useEffect, useContext } from 'react';
import { UserContext } from '../UserContext/UserContext';
import Navbar from '../NavBar/NavBar';
import NotificationAlert from './NotificationAlert';
import AlertMsg from '../AlertMsg/AlertMsg';
import { v4 as uuidv4 } from 'uuid';
import { RiHistoryFill } from 'react-icons/ri';
import { BiNotification } from 'react-icons/bi';
import { CgSmileSad } from 'react-icons/cg';
import { GoInfo } from 'react-icons/go';
import axios from 'axios';




import selfie22 from '../../images/selfie22.jpg'
import jeanma1 from '../../images/jeanma1.jpg'
import jeanma2 from '../../images/jeanma2.jpg'
import jeanma3 from '../../images/jeanma3.jpg'
import selfie from '../../images/selfie.jpg'


const newNotificationList = [
    {
        notificationId : uuidv4(),
        userImage: selfie22,
        userName: "Toto-27",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit',
        notificationAge: 'new'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma1,
        userName: "Jean-luc",
        notificationDate: '2021-12-20T14:01:00',
        notificationType: 'message',
        notificationAge: 'new'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma2,
        userName: "warrior",
        notificationDate: '2021-08-12T22:59:00',
        notificationType: 'match',
        notificationAge: 'new'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma3,
        userName: "Ketur00",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'like',
        notificationAge: 'new'
    },
    {
        notificationId : uuidv4(),
        userImage: selfie,
        userName: "Momo-du-nord",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit',
        notificationAge: 'new'
    },
    {
        notificationId : uuidv4(),
        userImage: selfie22,
        userName: "Bilout-bilout",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'dislike',
        notificationAge: 'new'
    }
]

const oldNotificationList = [
    {
        notificationId : uuidv4(),
        userImage: selfie22,
        userName: "Toto-27",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma1,
        userName: "Jean-luc",
        notificationDate: '2021-12-20T14:01:00',
        notificationType: 'message',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma2,
        userName: "warrior",
        notificationDate: '2021-08-12T22:59:00',
        notificationType: 'match',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma3,
        userName: "Ketur00",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'like',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: selfie,
        userName: "Momo-du-nord",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: selfie22,
        userName: "Bilout-bilout",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'dislike',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma1,
        userName: "User-404",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'like',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: jeanma2,
        userName: "Doudou",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'message',
        notificationAge: 'old'
    },
    {
        notificationId : uuidv4(),
        userImage: selfie,
        userName: "Arnaud",
        notificationDate: '2021-06-17T03:24:00',
        notificationType: 'visit',
        notificationAge: 'old'
    }
]



const Notifications = () => {

    const { load } = useContext(UserContext);
    const loading = load[0];

    useEffect( () => {

        if(!loading) {

            axios.get(`/notifications/data`)
            .then( (response) => {
                if (response.status === 200)
                {
                    console.log(response.data);
                }
            })
            .catch( () => {})

            document.title = 'Notifications - Matcha';
        }

    }, [loading])


    const [newNotifications, setNewNotifications] = useState(newNotificationList)

    const [oldNotifications, setOldNotifications] = useState(oldNotificationList)



// _-_-_-_-_-_-_-_-_- ALERT -_-_-_-_-_-_-_-_-_


    const [alertMessages, setAlertMessages] = useState([])


    const handleNewAlert = (newAlert) => {

        setAlertMessages(prevState => prevState.slice(1));
        setAlertMessages(prevState => [...prevState, newAlert]);
    }

    const successAlert = () => {
        handleNewAlert({id: uuidv4(),
                        variant: "info",
                        information: "Supprimée"})
    }

    const errorAlert = () => {
        handleNewAlert({id: uuidv4(),
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
                        newNotifications.length < 1
                        ?
                        <span className='notifications-empty'>
                            <CgSmileSad className='new-notif-empty-logo' />
                            Pas de nouvelles notifications pour le moment
                        </span>
                        :
                        newNotifications.map( data => {
                            return (
                                <NotificationAlert
                                    key={data.notificationId}
                                    notificationId={data.notificationId}
                                    userImage={data.userImage}
                                    userName={data.userName}
                                    notificationDate={data.notificationDate}
                                    notificationType={data.notificationType}
                                    notificationAge={data.notificationAge}
                                    notificationList={newNotifications}
                                    setNotificationList={setNewNotifications}
                                    successAlert={successAlert}
                                    errorAlert={errorAlert}
                                />
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
                            oldNotifications.length < 1
                            ?
                            <span className='notifications-empty'>
                                <GoInfo className='historical-empty-logo' />
                                Historique des notifications vide
                            </span>
                            :
                            oldNotifications.map( data => {
                                return (
                                <NotificationAlert
                                    key={data.notificationId}
                                    notificationId={data.notificationId}
                                    userImage={data.userImage}
                                    userName={data.userName}
                                    notificationDate={data.notificationDate}
                                    notificationType={data.notificationType}
                                    notificationAge={data.notificationAge}
                                    notificationList={oldNotifications}
                                    setNotificationList={setOldNotifications}
                                    successAlert={successAlert}
                                    errorAlert={errorAlert}
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