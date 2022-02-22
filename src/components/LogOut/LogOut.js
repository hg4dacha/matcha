import React from 'react'
import { AiOutlinePoweroff } from 'react-icons/ai';

const LogOut = () => {

    const handleLogout = e => {
        e.preventDefault()
        
        console.log('Déconnexion')
    }

    return (
        <button
            onClick={handleLogout}
            className='dropdown-log-out'>
                <AiOutlinePoweroff className='icons-dropdown'/>
                Déconnexion
        </button>
    )
}

export default LogOut