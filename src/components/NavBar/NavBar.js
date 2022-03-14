import React from 'react';
import Navbar from 'react-bootstrap/Navbar'
import Nav from 'react-bootstrap/Nav'
import NavDropdown from 'react-bootstrap/NavDropdown'
import { Link, NavLink } from 'react-router-dom'
import Logo from '../Logo/Logo'
import LogOut from '../LogOut/LogOut'
import { RiUser3Line, RiHistoryFill } from 'react-icons/ri';
import { CgHome } from 'react-icons/cg';
import { AiFillStar } from 'react-icons/ai';
import { IoNotificationsOutline } from 'react-icons/io5';
import { IoMdHeartEmpty } from 'react-icons/io';
import { RiHeart3Line } from 'react-icons/ri';




import selfie22 from '../../images/selfie22.jpg'





const Navbar$ = () => {

    const numberOfNotif = 0;

    return (
        <Navbar collapseOnSelect bg="white" variant="light" expand={true}>
            <Link to="/Main" className='navbar-brand'><Logo width='150' /></Link>
            <Navbar.Toggle aria-controls="responsive-navbar-nav" />
            <Navbar.Collapse id="responsive-navbar-nav">
                <Nav className="mr-auto">
                    <NavLink to="/Main" className='nav-link'>
                        <CgHome size={14} className='iconsNavbar'/>
                        Acceuil
                    </NavLink>
                    <NavLink to="/Notifications" className='nav-link'>
                        <IoNotificationsOutline size={16} className='iconsNavbar'/>
                        Notifications
                        <span className={`nb-notifications ${numberOfNotif > 0 ? "notifs-true" : "notifs-false"}`}>{numberOfNotif}</span>
                    </NavLink>
                    <NavLink to="/Profile" className='nav-link'>
                        <RiHeart3Line size={16} className='iconsNavbar'/>
                        Favoris
                    </NavLink>
                    <NavLink to="/Profile" className='nav-link'>
                        <RiHistoryFill size={16} className='iconsNavbar'/>
                        Historique
                    </NavLink>
                    <NavLink to="/Profile" className='nav-link'>
                        <RiUser3Line size={16} className='iconsNavbar'/>
                        Profil
                    </NavLink>
                </Nav>
                <Nav>
                    <LogOut/>
                    <div className='navbar-popularity-user-div'>
                        <span className='popularity'><AiFillStar className='star'/>1425°</span>
                        <div className='navbar-user-image-name-div'>
                            <div className='profile-picture-navbar-div-div'>
                                <div className='profile-picture-navbar-div'>
                                    <img src={selfie22} alt='user' className='profile-picture-navbar'/>
                                </div>
                            </div>
                            <span className='navbar-username'>username-269428</span>
                        </div>
                        {/* <NavDropdown title="username-269428" id="collasible-nav-dropdown">
                            <NavLink to="/Profile" className='dropdown-profile'>
                                <RiUser3Line className='icons-dropdown'/>Profil
                            </NavLink>
                            <NavDropdown.Divider />
                            <LogOut/>
                        </NavDropdown> */}
                    </div>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    )
}

export default Navbar$