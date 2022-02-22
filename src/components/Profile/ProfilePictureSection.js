import React, { Fragment } from 'react';
import { MdEdit } from "react-icons/md";
import Spinner from 'react-bootstrap/Spinner';
import { FaUserCircle } from "react-icons/fa";





const ProfilePictureSection = ({ picture, id, handlePictureChange, pictureLoading }) => {

    return (
        <Fragment>
            <div className='profile-picture-avatar-div-div'>
                <div className='profile-picture-avatar-div'>
                    {
                    picture
                    ?
                    <img src={picture} alt={id} className='profile-picture-avatar-img' />
                    :
                    <FaUserCircle className='profile-picture-avatar-icon' />
                    }
                </div>
                <label className="profile-picture-label" htmlFor={id}>
                    <MdEdit className='profile-picture-label-icon' />
                    <input onChange={handlePictureChange} type="file" id={id} className="user-photo-input" />
                </label>
                {
                pictureLoading &&
                <Spinner className='profile-picture-spinner' animation="border" variant="primary" />
                }
            </div>
        </Fragment>
    )

}

export default ProfilePictureSection;