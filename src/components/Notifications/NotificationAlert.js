import React, { useState } from 'react';
import { Link } from 'react-router-dom'
import { IoClose } from 'react-icons/io5';
import { IoMdHeart } from 'react-icons/io';





const NotificationAlert = ({ userImage, userName, notificationDate }) => {



    const [overNotif, setOverNotif] = useState(false);

    const onMouseOverNotif = () => { setOverNotif(true) }
    const onMouseOutNotif = () => { setOverNotif(false) }



    const [hideNotif, setHideNotif] = useState(false)
    const [deleteNotif, setDeleteNotif] = useState(false)

    const onHideNotif = () => {
        setHideNotif(true)
        setTimeout( () => { setDeleteNotif(true) } , 200)
    }

// _-_-_-_-_-_-_-_-_- NOTIFICATION DATE AND HOUR -_-_-_-_-_-_-_-_-_

    const newDate = new Date(notificationDate)




    return (
        <div
            className={`notification-alert-container
                        ${overNotif ? "notification-alert-hover" : ""}
                        ${hideNotif ? "notification-hide" : ""}
                        ${deleteNotif ? "notification-delete" : ""}
                      `}
            onMouseOver={onMouseOverNotif}
            onMouseOut={onMouseOutNotif}
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
                &nbsp;a liké votre profil&nbsp;
                <IoMdHeart className='notification-logo' />
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