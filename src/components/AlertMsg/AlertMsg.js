import React, { useEffect, useState } from 'react';
import Alert from 'react-bootstrap/Alert'
import { AiFillCheckCircle } from 'react-icons/ai';
import { BsInfoCircleFill } from 'react-icons/bs';
import { TiWarning } from 'react-icons/ti';





const AlertMsg = ({variant, information}) => {

    function Icon() {
        if (variant === 'success') {
            return <AiFillCheckCircle className='alertmsg-logo success' />
        }
        else if (variant === 'info') {
            return <BsInfoCircleFill className='alertmsg-logo info' />
        }
        else if (variant === 'error') {
            return <TiWarning className='alertmsg-logo error' />
        }
        else
            return null
    }

    const [show, setShow] = useState(true)

    useEffect( () => {

        let countDown = setTimeout( () => {
            setShow(false);
        } , 5000)

        return () => {
            clearTimeout(countDown)
        }

    }, [])


    return (
            <Alert show={show} transition={null} id='alert' className={`alert-msg ${variant}`}>
                <Icon/>
                {information}
            </Alert>
    )
}

export default AlertMsg