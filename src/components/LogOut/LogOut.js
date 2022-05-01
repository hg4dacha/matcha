import React, { useContext } from 'react';
import { BiLogOutCircle } from 'react-icons/bi';
import { useNavigate } from 'react-router-dom';
import { UserContext } from '../UserContext/UserContext';
import axios from 'axios';



const LogOut = () => {

    const { value } = useContext(UserContext);

    const setUser = value[1];

    const navigate = useNavigate();

    const handleLogout = e => {
        e.preventDefault()
        
        axios.post('/users/logout')
        .then( (response) => {
            if (response.status === 200)
            {
                localStorage.clear();
                setUser(null);
                delete axios.defaults.headers.common["Authorization"];
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