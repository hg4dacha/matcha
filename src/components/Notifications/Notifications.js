import React, { useState, Fragment, useEffect, useContext, useMemo, useRef, useCallback } from 'react';
import { UserContext } from '../UserContext/UserContext';
import Navbar from '../NavBar/NavBar';
import NotificationAlert from './NotificationAlert';
import AlertMsg from '../AlertMsg/AlertMsg';
import Spinner from 'react-bootstrap/Spinner';
import { v4 as uuidv4 } from 'uuid';
import { RiHistoryFill } from 'react-icons/ri';
import { BiNotification } from 'react-icons/bi';
import { CgSmileNeutral } from 'react-icons/cg';
import { GoInfo } from 'react-icons/go';
import axios from 'axios';







const Notifications = () => {

    const { load } = useContext(UserContext);
    const loading = load[0];

    const [newNotifications, setNewNotifications] = useState(false);
    const newNotif = useMemo( () => ({newNotifications, setNewNotifications}), [newNotifications, setNewNotifications]);
    const [oldNotifications, setOldNotifications] = useState(false);
    const [initialRequest, setInitialRequest] = useState(false);

    let requestTimeOut = useRef();

    const getNewNotifications = useCallback( () => {

        axios.get(`/notifications/notifications-refresh`)
        .then( (response) => {
            if(response.status === 200) {
                if(response.data.length > 0) {
                    newNotif.setNewNotifications(prevState =>
                        [...prevState, ...response.data]
                    );
                }
            }
        })
        .catch( () => {})

    }, [newNotif])


    useEffect( () => {

        document.title = 'Notifications - Matcha';

        if(!loading) {

            if(!initialRequest) {
                axios.get(`/notifications/data`)
                .then( (response) => {
                    if (response.status === 200)
                    {
                        newNotif.setNewNotifications(response.data.newNotifications);
                        setOldNotifications(response.data.oldNotifications);
                    }
                })
                .catch( () => {})
            }

            requestTimeOut.current = setInterval( () => {
                getNewNotifications();
            }, 5000);

            setInitialRequest(true);

            return () => {
                clearInterval(requestTimeOut.current);
            }

        }

    }, [loading, initialRequest, newNotif, getNewNotifications])



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
                            newNotif.newNotifications === false ?
                            <Spinner animation="border" variant="primary" size="sm" /> :
                            newNotif.newNotifications.length < 1
                            ?
                            <span className='notifications-empty'>
                                <CgSmileNeutral className='new-notif-empty-logo' />
                                Pas de nouvelles notifications pour le moment
                            </span>
                            :
                            newNotif.newNotifications.map( data => {
                                return (
                                    <NotificationAlert
                                        key={data.id}
                                        notificationId={data.id}
                                        trigger={data.triggerID}
                                        userImage={data.thumbnail}
                                        userName={data.username}
                                        notificationDate={data.notificationDate}
                                        notificationType={data.notificationType}
                                        notificationAge={data.age}
                                        notificationList={newNotif.newNotifications}
                                        setNotificationList={newNotif.setNewNotifications}
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
                            oldNotifications === false?
                            <Spinner animation="border" variant="primary" size="sm" /> :
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
                                    key={data.id}
                                    notificationId={data.id}
                                    trigger={data.triggerID}
                                    userImage={data.thumbnail}
                                    userName={data.username}
                                    notificationDate={data.notificationDate}
                                    notificationType={data.notificationType}
                                    notificationAge={data.age}
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