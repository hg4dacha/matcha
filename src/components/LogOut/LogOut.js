import React from 'react'
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
                <span className='logout-text'>Déconnexion</span>
        </button>
    )
}

export default LogOut