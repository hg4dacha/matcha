import React, { useEffect } from 'react';
import Navbar from '../NavBar/NavBar';
import { TiHome } from 'react-icons/ti';

const Main = () => {

    useEffect( () => {
        document.title = 'Acceuil - Matcha'
    }, [])

    return (
        <div className='BackgroundFirst'>
            <div className='BackgroundSecond'>
                <Navbar />
                <div className='tittleDiv'>
                    
                    <h1 className='FormsTittle center'><TiHome size='23' className='iconsFormsTittles' />Acceuil</h1>
                </div>
            </div>
        </div>
    )
}

export default Main