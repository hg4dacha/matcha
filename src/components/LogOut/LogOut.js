import React, { useContext } from 'react';
import { UserContext } from '../UserContext/UserContext';
import { BiLogOutCircle } from 'react-icons/bi';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';



const LogOut = ({ setUser }) => {


    const navigate = useNavigate();
    const { load } = useContext(UserContext);
    const setLoading = load[1];

    const handleLogout = e => {
        e.preventDefault()
        setLoading(true); // to avoid that the requests in the 'useEffect' are retriggered
        
        axios.post('/users/logout')
        .then( (response) => {
            if (response.status === 200)
            {
                delete axios.defaults.headers.common["Authorization"];
                setUser(null);
                navigate("/signin", {state: 'logout'});
                setLoading(false); // to allow requests to be triggered again
            }
        })
        .catch( () => {})
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