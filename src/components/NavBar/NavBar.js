import React, { Fragment, useEffect, useState, useContext, useMemo, useRef, useCallback } from 'react';
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


    const { value, load } = useContext(UserContext);
    const [user, setUser] = value;
    const loading = load[0];
    const [dashboardData, setDashboardData] = useState(null);
    // const dash = useMemo( () => ({dashboardData, setDashboardData}), [dashboardData, setDashboardData]);
    const [windowSize, setWindowSize] = useState(window.screen.width)
    const [notifNumber, setNotifNumber] = useState(null);
    // const notif = useMemo( () => ({notifNumber, setNotifNumber}), [notifNumber, setNotifNumber]);
    const [initialRequest, setInitialRequest] = useState(false);


    // let requestTimeOut = useRef();

    // const getnotificationsNumber = useCallback( () => {

    //     axios.get(`/notifications/check`)
    //     .then( (response) => {
    //         if(response.status === 200) {
    //             setNotifNumber(response.data);
    //         }
    //     })
    //     .catch( () => {})

    // }, [])


    useEffect( () => {

        if(!loading) {

            user &&
            setDashboardData({
                popularity: user.user.popularity,
                thumbnail: user.user.thumbnail,
                username: user.user.username
            });

            window.onresize = () => {
                setWindowSize(window.innerWidth);
            }

            if(!initialRequest) {

                axios.get('/notifications/check')
                .then( (response) => {
                    if (response.status === 200)
                    {
                        setNotifNumber(response.data);
                    }
                })
                .catch( () => {

                })

            }

            setInitialRequest(true);

            return () => {
                window.onresize = () => null
            }
            
        }

    }, [loading, user, initialRequest])





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
                            {notifNumber !== null && <span className={`nb-notifications ${notifNumber > 0 ? "notifs-true" : "notifs-false"}`}>{notifNumber}</span>}
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
                    <LogOut setUser={setUser} />
                    <div className='navbar-popularity-user-div'>
                        {dashboardData && <span className='popularity'><AiFillStar className='star'/>{`${dashboardData.popularity}°`}</span>}
                        <div className='navbar-user-image-name-div'>
                            {dashboardData &&
                            <div className='profile-picture-navbar-div'>
                                <img src={dashboardData.thumbnail} alt='user' className='profile-picture-navbar'/>
                            </div>}
                            {dashboardData && <span className='navbar-username'>{dashboardData.username}</span>}
                        </div>
                    </div>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    )
}

export default Navbar$