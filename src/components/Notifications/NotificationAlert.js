import React, { Fragment, useState } from 'react';
import { Link } from 'react-router-dom'
import { IoClose } from 'react-icons/io5';
import { IoMdHeart, IoIosMail, IoMdHeartDislike } from 'react-icons/io';
import { WiFire } from 'react-icons/wi';
import { VscEye } from 'react-icons/vsc';






const NotificationAlert = ({
    notificationId, userImage, userName, notificationDate, notificationType,
    notificationAge, notificationList, setNotificationList }) => {


// _-_-_-_-_-_-_-_-_- HIDE AND DELETE NOTIFICATION -_-_-_-_-_-_-_-_-_


    const [hideNotif, setHideNotif] = useState(false)
    const [deleteNotif, setDeleteNotif] = useState(false)

    const onHideNotif = () => {
        setHideNotif(true)
        setTimeout( () => {
            setDeleteNotif(true);
            setNotificationList( (notificationList.filter( notification => notification.notificationId !== notificationId)) );
        } , 200)
    }


// _-_-_-_-_-_-_-_-_- NOTIFICATION DATE AND HOUR -_-_-_-_-_-_-_-_-_

    const newDate = new Date(notificationDate)


// _-_-_-_-_-_-_-_-_- ICON TYPE -_-_-_-_-_-_-_-_-_

    function IconType() {
        if (notificationType === 'like') {
            return <div className='notification-logo-content like'>
                        <IoMdHeart className='notification-logo' color='darkred' />
                </div>
        }
        else if (notificationType === 'visit') {
            return <div className='notification-logo-content visit'>
                        <VscEye className='notification-logo' color='#27ae60' />
                </div>
        }
        else if (notificationType === 'message') {
            return <div className='notification-logo-content message'>
                        <IoIosMail className='notification-logo' color='#007bff' />
                </div>
        }
        else if (notificationType === 'match') {
            return <div className='notification-logo-content match'>
                        <WiFire className='notification-logo match' color='rgb(226, 88, 34)' />
                </div>
        }
        else if (notificationType === 'dislike') {
            return <div className='notification-logo-content dislike'>
                        <IoMdHeartDislike className='notification-logo' color='#95a5a6' />
                </div>
        }
        else
            return null
    }


// _-_-_-_-_-_-_-_-_- MESSAGE TYPE -_-_-_-_-_-_-_-_-_

    function MessageType() {
        if (notificationType === 'like') {
            return <Fragment>
                        &nbsp;a aimé votre profil&nbsp;
                   </Fragment>
        }
        else if (notificationType === 'visit') {
            return <Fragment>
                        &nbsp;a visité votre profil&nbsp;
                   </Fragment>
        }
        else if (notificationType === 'message') {
            return <Fragment>
                        &nbsp;vous a envoyé un message&nbsp;
                   </Fragment>
        }
        else if (notificationType === 'match') {
            return <Fragment>
                        &nbsp;a également aimé votre profil - MATCHA !&nbsp;
                   </Fragment>
        }
        else if (notificationType === 'dislike') {
            return <Fragment>
                        &nbsp;a retiré le j'aime de votre profil&nbsp;
                   </Fragment>
        }
        else
            return null
    }



    return (
        <div className={`notification-alert-container-div
                         ${hideNotif ? "notification-hide" : ""}
                         ${deleteNotif ? "notification-delete" : ""}`}
        >
            <div className={`notification-alert-container ${notificationAge === 'new' ? "new-notif" : "old-notif"}`}>
                <IconType/>
                <div className='notification-message-content'>
                    <div className='notification-alert-picture-div'>
                        <img src={userImage} alt='user' className='notification-alert-picture'/>
                    </div>
                    <div className='notification-text'>
                        <Link to={`/MemberProfile`} className='notification-user-link'>
                            {userName}
                        </Link>
                        <MessageType/>
                    </div>
                </div>
                <small className='notification-date'>
                    {`${newDate.toLocaleDateString('fr-FR', {day: '2-digit', month: 'short', year: 'numeric'})} - ${newDate.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}`}
                </small>
                <button className='notification-alert-close' onClick={onHideNotif}>
                    <IoClose className='notification-alert-close-logo' />
                </button>
            </div>
        </div>
    )
}

export default NotificationAlert