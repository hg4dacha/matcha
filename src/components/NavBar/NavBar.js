import React, { Fragment, useEffect, useState } from 'react';
import Navbar from 'react-bootstrap/Navbar';
import Nav from 'react-bootstrap/Nav';
import { Link, NavLink } from 'react-router-dom';
import Logo from '../Logo/Logo';
import LogOut from '../LogOut/LogOut';
import { RiUser3Line, RiHistoryFill } from 'react-icons/ri';
import { CgHome } from 'react-icons/cg';
import { AiFillStar } from 'react-icons/ai';
import { IoNotificationsOutline } from 'react-icons/io5';
import { RiHeart3Line } from 'react-icons/ri';
import { BiMenu } from 'react-icons/bi';

import NavDropdown from 'react-bootstrap/NavDropdown';



import selfie22 from '../../images/selfie22.jpg'





const Navbar$ = () => {

    const numberOfNotif = 0;


    const [windowSize, setWindowSize] = useState(window.screen.width)

    useEffect( () => {

        window.onresize = () => {
            setWindowSize(window.innerWidth);
        }

        return () => {
            window.onresize = () => null
        }
    })





    return (
        <Navbar collapseOnSelect bg="white" variant="light" expand={true}>
            <Link to="/Main" className='navbar-brand'><Logo width='150' /></Link>
            <Navbar.Toggle aria-controls="responsive-navbar-nav"/>
            <Navbar.Collapse id="responsive-navbar-nav"  className='navlink-content'>
                <Nav className="mr-auto">
                    {windowSize > 950 ?
                    <Fragment>
                        <NavLink to="/Main" className='nav-link'>
                            <CgHome size={14} className='iconsNavbar'/>
                            Acceuil
                        </NavLink>
                        <NavLink to="/Notifications" className='nav-link'>
                            <IoNotificationsOutline size={16} className='iconsNavbar'/>
                            Notifications
                            <span className={`nb-notifications ${numberOfNotif > 0 ? "notifs-true" : "notifs-false"}`}>{numberOfNotif}</span>
                        </NavLink>
                        <NavLink to="/Favorites" className='nav-link'>
                            <RiHeart3Line size={16} className='iconsNavbar'/>
                            Favoris
                        </NavLink>
                        <NavLink to="/History" className='nav-link'>
                            <RiHistoryFill size={16} className='iconsNavbar'/>
                            Historique
                        </NavLink>
                        <NavLink to="/Profile" className='nav-link'>
                            <RiUser3Line size={16} className='iconsNavbar'/>
                            Profil
                        </NavLink>
                    </Fragment>
                    :
                    <NavDropdown title={<BiMenu className='dropdown-small-width-logo'/>} id="basic-nav-dropdown" className='dropdown-small-width'>
                        <NavLink to="/Main" className='nav-link-small-width'>
                            <CgHome size={14} className='iconsNavbar'/>
                            Acceuil
                        </NavLink>
                        <NavLink to="/Notifications" className='nav-link-small-width'>
                            <IoNotificationsOutline size={16} className='iconsNavbar'/>
                            Notifications
                        </NavLink>
                        <NavLink to="/Favorites" className='nav-link-small-width'>
                            <RiHeart3Line size={16} className='iconsNavbar'/>
                            Favoris
                        </NavLink>
                        <NavLink to="/History" className='nav-link-small-width'>
                            <RiHistoryFill size={16} className='iconsNavbar'/>
                            Historique
                        </NavLink>
                        <NavLink to="/Profile" className='nav-link-small-width'>
                            <RiUser3Line size={16} className='iconsNavbar'/>
                            Profil
                        </NavLink>
                    </NavDropdown>
                    }
                </Nav>
                <Nav>
                    <LogOut/>
                    <div className='navbar-popularity-user-div'>
                        <span className='popularity'><AiFillStar className='star'/>1425°</span>
                        <div className='navbar-user-image-name-div'>
                            <div className='profile-picture-navbar-div'>
                                <img src={selfie22} alt='user' className='profile-picture-navbar'/>
                            </div>
                            <span className='navbar-username'>username-269428</span>
                        </div>
                    </div>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    )
}

export default Navbar$