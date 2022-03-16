import React, { Fragment, useEffect, useState } from 'react';
import Navbar from '../NavBar/NavBar';
import { IoFilter } from 'react-icons/io5';








const Main = () => {

    useEffect( () => {
        document.title = 'Acceuil - Matcha'
    }, [])


    const [ageRange, setAgeRange] = useState({ minimumAge: '18', maximumAge: '100' })

    const handleValueChange = (e) => {
        setAgeRange({ ...ageRange, [e.target.id]: e.target.value })
    }



    return (
        <Fragment>
            <Navbar />
            <div className='main-container'>
                <div className='range-filter-offcanvas'>
                    <div className='range-filter-container'>
                        <div>Âge</div>
                        <div className='slider-track'></div>
                        <input
                            type="range"
                            className='range-filter'
                            id="minimumAge"
                            name="minimumAge"
                            min="18"
                            max="100"
                            value={ageRange.minimumAge}
                            onChange={handleValueChange}
                        />
                        <input
                            type="range"
                            className='range-filter'
                            id="maximumAge"
                            name="maximumAge"
                            min="18"
                            max="100"
                            value={ageRange.maximumAge}
                            onChange={handleValueChange}
                        />
                    </div>
                    {/* <div>
                        Popularité
                        <input type="range" />
                        <input type="range" />
                    </div>
                    <div>
                        Localisation
                        <input type="range" />
                        <input type="range" />
                    </div>
                    <div>
                        Tags en commun
                        <input type="range" />
                        <input type="range" />
                    </div> */}
                    <button className='filter-button'><IoFilter className='filter-logo' /></button>
                </div>
            </div>
        </Fragment>
    )
}

export default Main