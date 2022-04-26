import React from 'react';
import { BiLogOutCircle } from 'react-icons/bi';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';



const LogOut = () => {

    const navigate = useNavigate();

    const handleLogout = e => {
        e.preventDefault()
        
        axios.post('/users/logout')
        .then( (response) => {
            if (response.status === 200)
            {
                localStorage.clear();
                navigate("/signin", {state: 'logout'});
            }
        })
        .catch( () => {
            return null;
        })
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