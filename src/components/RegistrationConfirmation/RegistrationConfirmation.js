import React, { Fragment, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';
import Spinner from 'react-bootstrap/Spinner'






const RegistrationConfirmation = () => {


    const params = useParams();

    
    useEffect( () => {

        if( params.username && params.token )
        {
            axios.post('/users/confirm', params)
            .then( (response) => {
                console.log(response);
                if (response.status === 200)
                {
                    console.log(response);
                }
            })
            .catch( (error) => {

            })
        }

    }, [params])


    return (
        <div className='registr-confirm-content'>
            <div className='registr-confirm-wait'>
                <Spinner className='registr-confirm-spinner' animation="border" variant="primary" />
                <div style={{fontWeight: "500"}}>Quelques secondes...</div>
            </div>
        </div>
    )
}

export default RegistrationConfirmation