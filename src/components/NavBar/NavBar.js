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
    const [windowSize, setWindowSize] = useState(window.screen.width)
    const [notifNumber, setNotifNumber] = useState(null);
    const notif = useMemo( () => ({notifNumber, setNotifNumber}), [notifNumber, setNotifNumber]);
    const [initialRequest, setInitialRequest] = useState(false);


    let requestTimeOut = useRef();

    const getnotificationsNumber = useCallback( () => {

        axios.get(`/notifications/check`)
        .then( (response) => {
            if(response.status === 200) {
                if(window.location.pathname !== '/notifications') {
                    notif.setNotifNumber(response.data);
                }
                else {
                    notif.setNotifNumber(0);
                }
            }
        })
        .catch( () => {})

    }, [notif])


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

            if(window.location.pathname === '/notifications') {

                notif.setNotifNumber(0);

            }
            else if(!initialRequest) {

                axios.get('/notifications/check')
                .then( (response) => {
                    if (response.status === 200)
                    {
                        notif.setNotifNumber(response.data);
                    }
                })
                .catch( () => {

                })

            }

            requestTimeOut.current = setInterval( () => {
                getnotificationsNumber();
            }, 5000);

            setInitialRequest(true);

            return () => {
                clearInterval(requestTimeOut.current);
                window.onresize = () => null;
                setDashboardData(null);
            }
            
        }

    }, [loading, user, initialRequest, getnotificationsNumber, notif])





    return (
        <Navbar collapseOnSelect bg="white" variant="light" expand={true}>
            <Link to="/users" className='navbar-brand'><Logo width='150' /></Link>
            <Navbar.Toggle aria-controls="responsive-navbar-nav"/>
            <Navbar.Collapse id="responsive-navbar-nav"  className='navlink-content'>
                <Nav className="mr-auto">
                    {windowSize > 950 ?
                    <Fragment>
                        <NavLink to="/users" className={(navData) => navData.isActive && window.location.pathname === '/users' ? 'nav-link actived' : 'nav-link'}>
                            <CgHome size={14} className='iconsNavbar'/>
                            Accueil
                        </NavLink>
                        <NavLink to="/notifications" className={(navData) => navData.isActive ? 'nav-link actived' : 'nav-link'}>
                            <IoNotificationsOutline size={16} className='iconsNavbar'/>
                            Notifications
                            {notifNumber !== null && <span className={`nb-notifications ${notifNumber > 0 ? "notifs-true" : "notifs-false"}`}>{notifNumber}</span>}
                        </NavLink>
                        <NavLink to="/favorites" className={(navData) => navData.isActive ? 'nav-link actived' : 'nav-link'}>
                            <RiHeart3Line size={16} className='iconsNavbar'/>
                            Favoris
                        </NavLink>
                        <NavLink to="/history" className={(navData) => navData.isActive ? 'nav-link actived' : 'nav-link'}>
                            <RiHistoryFill size={16} className='iconsNavbar'/>
                            Historique
                        </NavLink>
                        <NavLink to="/profile" className={(navData) => navData.isActive ? 'nav-link actived' : 'nav-link'}>
                            <RiUser3Line size={16} className='iconsNavbar'/>
                            Profil
                        </NavLink>
                    </Fragment>
                    :
                    <NavDropdown title={<BiMenu className='dropdown-small-width-logo'/>} id="basic-nav-dropdown" className='dropdown-small-width'>
                        <NavLink to="/users" className={(navData) => navData.isActive && window.location.pathname === '/users' ? 'nav-link-small-width actived' : 'nav-link-small-width'}>
                            <CgHome size={14} className='iconsNavbar'/>
                            Acceuil
                        </NavLink>
                        <NavLink to="/notifications" className={(navData) => navData.isActive ? 'nav-link-small-width actived' : 'nav-link-small-width'}>
                            <IoNotificationsOutline size={16} className='iconsNavbar'/>
                            Notifications
                        </NavLink>
                        <NavLink to="/favorites" className={(navData) => navData.isActive ? 'nav-link-small-width actived' : 'nav-link-small-width'}>
                            <RiHeart3Line size={16} className='iconsNavbar'/>
                            Favoris
                        </NavLink>
                        <NavLink to="/history" className={(navData) => navData.isActive ? 'nav-link-small-width actived' : 'nav-link-small-width'}>
                            <RiHistoryFill size={16} className='iconsNavbar'/>
                            Historique
                        </NavLink>
                        <NavLink to="/profile" className={(navData) => navData.isActive ? 'nav-link-small-width actived' : 'nav-link-small-width'}>
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