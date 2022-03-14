import React from 'react'
import { AiOutlinePoweroff } from 'react-icons/ai';
import { BiLogOutCircle } from 'react-icons/bi';



const LogOut = () => {

    const handleLogout = e => {
        e.preventDefault()
        
        console.log('Déconnexion')
    }

    return (
        <button
            onClick={handleLogout}
            className='log-out-button'>
                <BiLogOutCircle className='log-out-logo'/>
                Déconnexion
        </button>
    )
}

export default LogOut