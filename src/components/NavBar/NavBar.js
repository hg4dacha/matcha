import React from 'react';
import Navbar from 'react-bootstrap/Navbar'
import Nav from 'react-bootstrap/Nav'
import NavDropdown from 'react-bootstrap/NavDropdown'
import { Link, NavLink } from 'react-router-dom'
import Logo from '../Logo/Logo'
import LogOut from '../LogOut/LogOut'
import { RiUser3Line } from 'react-icons/ri';
import { CgHome } from 'react-icons/cg';
import { AiFillStar } from 'react-icons/ai';



import selfie22 from '../../images/selfie22.jpg'





const Navbar$ = () => {

    return (
        <Navbar collapseOnSelect bg="white" variant="light" expand="lg">
            <Link to="/Main" className='navbar-brand'><Logo width='150' /></Link>
            <Navbar.Toggle aria-controls="responsive-navbar-nav" />
            <Navbar.Collapse id="responsive-navbar-nav">
                <Nav className="mr-auto">
                    <NavLink to="/Main" className='nav-link'><CgHome size={14} className='iconsNavbar'/>Acceuil</NavLink>
                    <NavLink to="/Profile" className='nav-link'><RiUser3Line size={16} className='iconsNavbar'/>Profil</NavLink>
                </Nav>
                <Nav>
                    <div className='centerElementsInPage' style={{flexDirection: 'row'}}>
                        <span className='popularity'><AiFillStar className='star'/>1425°</span>
                        <div className='profile-picture-navbar-div-div'>
                            <div className='profile-picture-navbar-div'>
                                <img src={selfie22} alt='user' className='profile-picture-navbar'/>
                            </div>
                        </div>
                        <NavDropdown title="username-269428" id="collasible-nav-dropdown">
                            <NavLink to="/Profile" className='dropdown-profile'>
                                <RiUser3Line className='icons-dropdown'/>Profil
                            </NavLink>
                            <NavDropdown.Divider />
                            <LogOut/>
                        </NavDropdown>
                    </div>
                </Nav>
            </Navbar.Collapse>
        </Navbar>
    )
}

export default Navbar$