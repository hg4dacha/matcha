import React from 'react';



const MsgOut = (props) => {
    return (
        <div className='msg-div msg-div-out'>
            <div className='msg-content-div msg-out-content-div'>
                <div className='msg-content out'>{props.msgContent}</div>
            </div>
        </div>
    )
}

export default MsgOut;