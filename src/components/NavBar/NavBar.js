import React, { Fragment, useEffect, useState, useContext } from 'react';
import Navbar from 'react-bootstrap/Navbar';
import Nav from 'react-bootstrap/Nav';
import NavDropdown from 'react-bootstrap/NavDropdown';
import { Link, NavLink } from 'react-router-dom';
import Logo from '../Logo/Logo';
import LogOut from '../LogOut/LogOut';
import { UserContext } from '../UserContext/UserContext';
import { RiUser3Line, RiHistoryFill } from 'react-icons/ri';
import { CgHome } from 'react-icons/cg';
import { AiFillStar } from 'react-icons/ai';
import { IoNotificationsOutline } from 'react-icons/io5';
import { RiHeart3Line } from 'react-icons/ri';
import { BiMenu } from 'react-icons/bi';
import axios from 'axios';







const Navbar$ = () => {

    const numberOfNotif = 0;

    const { load } = useContext(UserContext);

    const loading = load[0];

    const [dashboardData, setDashboardData] = useState({
        popularity: '',
        thumbnail: '',
        username: ''
    });

    const [windowSize, setWindowSize] = useState(window.screen.width)


    useEffect( () => {

        if(!loading) {
            axios.get('/users/dashboard')
            .then( (response) => {
                if (response.status === 200)
                {
                    setDashboardData({
                        popularity: response.data.popularity,
                        thumbnail: response.data.thumbnail,
                        username: response.data.username
                    })
                }
            })
            .catch( () => {

            })

            window.onresize = () => {
                setWindowSize(window.innerWidth);
            }

            return () => {
                window.onresize = () => null
            }
        }
    }, [loading])





    return (
        <Navbar collapseOnSelect bg="white" variant="light" expand={true}>
            <Link to="/users" className='navbar-brand'><Logo width='150' /></Link>
            <Navbar.Toggle aria-controls="responsive-navbar-nav"/>
            <Navbar.Collapse id="responsive-navbar-nav"  className='navlink-content'>
                <Nav className="mr-auto">
                    {windowSize > 950 ?
                    <Fragment>
                        <NavLink to="/users" className='nav-link'>
                            <CgHome size={14} className='iconsNavbar'/>
                            Acceuil
                        </NavLink>
                        <NavLink to="/notifications" className='nav-link'>
                            <IoNotificationsOutline size={16} className='iconsNavbar'/>
                            Notifications
                            <span className={`nb-notifications ${numberOfNotif > 0 ? "notifs-true" : "notifs-false"}`}>{numberOfNotif}</span>
                        </NavLink>
                        <NavLink to="/favorites" className='nav-link'>
                            <RiHeart3Line size={16} className='iconsNavbar'/>
                            Favoris
                        </NavLink>
                        <NavLink to="/history" className='nav-link'>
                            <RiHistoryFill size={16} className='iconsNavbar'/>
                            Historique
                        </NavLink>
                        <NavLink to="/profile" className='nav-link'>
                            <RiUser3Line size={16} className='iconsNavbar'/>
                            Profil
                        </NavLink>
                    </Fragment>
                    :
                    <NavDropdown title={<BiMenu className='dropdown-small-width-logo'/>} id="basic-nav-dropdown" className='dropdown-small-width'>
                        <NavLink to="/users" className='nav-link-small-width'>
                            <CgHome size={14} className='iconsNavbar'/>
                            Acceuil
                        </NavLink>
                        <NavLink to="/notifications" className='nav-link-small-width'>
                            <IoNotificationsOutline size={16} className='iconsNavbar'/>
                            Notifications
                        </NavLink>
                        <NavLink to="/favorites" className='nav-link-small-width'>
                            <RiHeart3Line size={16} className='iconsNavbar'/>
                            Favoris
                        </NavLink>
                        <NavLink to="/history" className='nav-link-small-width'>
                            <RiHistoryFill size={16} className='iconsNavbar'/>
                            Historique
                        </NavLink>
                        <NavLink to="/profile" className='nav-link-small-width'>
                            <RiUser3Line size={16} className='iconsNavbar'/>
                            Profil
                        </NavLink>
                    </NavDropdown>
                    }
                </Nav>
                <Nav>
                    <LogOut/>
                    <div className='navbar-popularity-user-div'>
                        <span className='popularity'><AiFillStar className='star'/>{`${dashboardData.popularity}°`}</span>
                        <div className='navbar-user-image-name-div'>
                            <div className='profile-picture-navbar-div'>
                                <img src={dashboardData.thumbnail} alt='user' className='profile-picture-navbar'/>
                            </div>
                            <span className='navbar-username'>{dashboardData.username}</span>
                        </div>
                    </div>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    )
}

export default Navbar$