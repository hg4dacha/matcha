import React, { useState } from 'react'
import Logo from '../Logo/Logo';

const FormsHeader = () => {

    const logoWidthBase = window.screen.width <= 600 ? '110' : '150'
    const [logoWidth, setlogoWidth] = useState(logoWidthBase)

    
    document.querySelector('body').onresize = () => {
        if (window.screen.width <= 600) {
            setlogoWidth('110');
        } else {
            setlogoWidth('150');
        }
    }

    return (
        <header className='FormsHeader'>
            <Logo width={logoWidth} />
        </header>
    )
}

export default FormsHeader