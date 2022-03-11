import React, { Fragment } from 'react';
import { MdEdit, MdDelete } from "react-icons/md";
import Spinner from 'react-bootstrap/Spinner';
import { BiImageAdd } from "react-icons/bi";





const UserPhotosSection = ({ picture, id, number, handleDeletePicture, handlePictureChange, pictureLoading }) => {

    return (
        <Fragment>
            {
                picture ?

                <div className='user-photo-img-div'>
                    <img src={picture} alt={id} className='user-photo-img' />
                    <label className="user-photo-label" htmlFor={id}>
                        <MdEdit className='user-photo-edit' />
                        <input onChange={handlePictureChange} type="file" id={id} className="user-photo-input" />
                    </label>
                    <div className='user-photo-number-and-delete-div'>
                        <span className='user-photo-number'>{`#${number}`}</span>
                        <button
                            onClick={handleDeletePicture}
                            name={id}
                            className='user-photo-delete'
                            disabled={pictureLoading ? true : false}
                        >
                            <MdDelete className='user-photo-delete-icon' />
                        </button>
                    </div>
                    {
                    pictureLoading &&
                    <Spinner className='user-photo-spinner1' animation="border" variant="primary" />
                    }
                </div>

                :

                <div className='user-photo-img-div-empty'>
                    <label className="user-photo-label-empty" htmlFor={id}>
                        <BiImageAdd className='user-photo-add-empty' />
                        <input onChange={handlePictureChange} type="file" id={id} className="user-photo-input" />
                    </label>
                    <span className='user-photo-number-empty'>{`#${number}`}</span>
                    {
                    pictureLoading &&
                    <Spinner className='user-photo-spinner2' animation="border" variant="primary" />
                    }
                </div>
            }
        </Fragment>
    )

}

export default UserPhotosSection;