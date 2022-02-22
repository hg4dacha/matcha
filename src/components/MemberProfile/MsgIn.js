import React from 'react';



const MsgIn = (props) => {
    return (
        <div className='msg-div msg-div-in'>
            <div className='msg-content-div msg-in-content-div'>
                <div className='msg-content in'>{props.msgContent}</div>
            </div>
        </div>
    )
}

export default MsgIn;