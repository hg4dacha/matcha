import React, { useEffect, useState } from 'react';
import Alert from 'react-bootstrap/Alert'
import { AiFillCheckCircle } from 'react-icons/ai';
import { BsInfoCircleFill } from 'react-icons/bs';
import { TiWarning } from 'react-icons/ti';





const AlertMsg = ({variant, information}) => {

    function Icon() {
        if (variant === 'success') {
            return <AiFillCheckCircle size='23' className='mr-2' />
        }
        else if (variant === 'info') {
            return <BsInfoCircleFill size='19' className='mr-2' />
        }
        else if (variant === 'error') {
            return <TiWarning size='21' className='mr-2' />
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