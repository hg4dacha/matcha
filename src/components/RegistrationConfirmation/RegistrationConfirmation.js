import React, { Fragment, useEffect } from 'react';
import { useParams } from 'react-router-dom';
import axios from 'axios';






const RegistrationConfirmation = () => {


    const params = useParams();

    
    useEffect( () => {

        axios.post('/users', params)
        .then( (response) => {
            console.log(response);
            if (response.status === 200)
            {
                
            }
        })
        .catch( (error) => {

        })

    }, [params])


    return <Fragment></Fragment>
}

export default RegistrationConfirmation