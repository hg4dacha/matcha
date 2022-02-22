import React from 'react';
import logobis from '../../images/logobis.png';

const LogoBis = (props) => {
    return <img src={logobis}
                alt='logobis'
                className='logobis'
                style={{width: props.width + 'px', pointerEvents: 'none'}}
                draggable="false"
            />
}

export default LogoBis