import React, { Fragment, useState } from 'react';
import { Link } from 'react-router-dom'
import { IoClose } from 'react-icons/io5';
import { IoMdHeart, IoIosMail, IoMdHeartDislike } from 'react-icons/io';
import { MdVisibility } from 'react-icons/md';
import { RiFireFill } from 'react-icons/ri';







const NotificationAlert = ({ userImage, userName, notificationDate, notificationType }) => {


// _-_-_-_-_-_-_-_-_- HIDE AND DELETE NOTIFICATION -_-_-_-_-_-_-_-_-_


    const [hideNotif, setHideNotif] = useState(false)
    const [deleteNotif, setDeleteNotif] = useState(false)

    const onHideNotif = () => {
        setHideNotif(true)
        setTimeout( () => { setDeleteNotif(true) } , 200)
    }


// _-_-_-_-_-_-_-_-_- NOTIFICATION DATE AND HOUR -_-_-_-_-_-_-_-_-_

    const newDate = new Date(notificationDate)


// _-_-_-_-_-_-_-_-_- NOTIFICATION TYPE -_-_-_-_-_-_-_-_-_

    function NotificationType() {
        if (notificationType === 'like') {
            return <Fragment>
                        &nbsp;a aimé votre profil&nbsp;
                        <IoMdHeart className='notification-logo' color='darkred' />
                   </Fragment>
        }
        else if (notificationType === 'visit') {
            return <Fragment>
                        &nbsp;a visité votre profil&nbsp;
                        <MdVisibility className='notification-logo' color='#006266' />
                   </Fragment>
        }
        else if (notificationType === 'message') {
            return <Fragment>
                        &nbsp;vous a envoyé un message&nbsp;
                        <IoIosMail className='notification-logo' color='#007bff' />
                   </Fragment>
        }
        else if (notificationType === 'match') {
            return <Fragment>
                        &nbsp;a également aimé votre profil - MATCHA !&nbsp;
                        <RiFireFill className='notification-logo' color='#e25822' />
                   </Fragment>
        }
        else if (notificationType === 'dislike') {
            return <Fragment>
                        &nbsp;a retiré le j'aime de votre profil&nbsp;
                        <IoMdHeartDislike className='notification-logo' color='#636e72' />
                   </Fragment>
        }
        else
            return null
    }



    return (
        <div
            className={`notification-alert-container
                        ${hideNotif ? "notification-hide" : ""}
                        ${deleteNotif ? "notification-delete" : ""}
                      `}
        >
            <div className='notification-alert-picture-div-div'>
                <div className='notification-alert-picture-div'>
                    <img src={userImage} alt='user' className='notification-alert-picture'/>
                </div>
            </div>
            <div className='notification-text'>
                <Link to={`/MemberProfile`} className='notification-user-link'>
                    {userName}
                </Link>
                <NotificationType/>
            </div>
            <small className='notification-date'>
                {`${newDate.toLocaleDateString('fr-FR', {day: '2-digit', month: 'short', year: 'numeric'})} - ${newDate.toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}`}
            </small>
            <button className='notification-alert-close' onClick={onHideNotif}>
                <IoClose className='notification-alert-close-logo' />
            </button>
        </div>
    )
}

export default NotificationAlert