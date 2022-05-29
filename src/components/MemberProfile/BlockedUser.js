import React, { useEffect, useState, useRef, useCallback } from 'react';
import { useParams } from 'react-router-dom';
import Button from 'react-bootstrap/Button'
import { IoReturnUpBack } from "react-icons/io5";
import axios from 'axios';





const BlockedUser = (props) => {
    

    const params = useParams();

    const [userData, setUserData] = useState({
        username: '',
        thumbnail: ''
    });


    let requestTimeOut = useRef();
    const currentUserDeblocked = props.onCurrentUserDeblocked;

    const getDisplayData = useCallback( () => {

        axios.get(`/users/profile-refresh/${params.userid}`)
        .then( (response) => {
            if(response.status === 200) {
                if(!response.data.currentUserBlocked) {
                    currentUserDeblocked();
                    return;
                }
            }
        })
        .catch( () => {})

    }, [currentUserDeblocked, params.userid])


    useEffect( () => {

        axios.get(`/blocked/data/${params.userid}`)
        .then( (response) => {
            if (response.status === 200)
            {
                setUserData({
                    username: response.data.username,
                    thumbnail: response.data.thumbnail
                });
            }
        })
        .catch( () => {})

        requestTimeOut.current = setInterval( () => {
            getDisplayData();
        }, 5000);

        return () => {
            clearInterval(requestTimeOut.current);
        }

    }, [params.userid, getDisplayData])


    const previousPage = () => {
        window.history.back()
        return false
    }


    return (
        <div className='blocked-profile-div'>
            <div className='blocked-profile-contain b-user'>
                <div className='blocked-user-image-div'>
                    {userData.thumbnail && <img src={userData.thumbnail} alt='interlocutor' className='blocked-user-image'/>}
                </div>
                <span className='blocked-user-username'>{userData.username}</span>
                <div className='info-deblocked'>
                    <span className='blocking-information'>{`${userData.username} vous a bloqué, vous ne pouvez pas accéder à son profil.`}</span>
                    <Button  onClick={previousPage} variant="primary" className='centerElementsInPage blocked' style={{width: 'fit-content'}}>
                        <IoReturnUpBack style={{marginRight: '3px'}}/>Retour
                    </Button>
                </div>
            </div>
        </div>
    )
}

export default BlockedUser;