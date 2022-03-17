import React, { Fragment, useEffect, useState } from 'react';
import Navbar from '../NavBar/NavBar';
import { IoClose, IoOptions } from 'react-icons/io5';
import { IoMdOptions } from 'react-icons/io';








const Main = () => {


    useEffect( () => {
        document.title = 'Acceuil - Matcha'
    }, [])



    const [offcanvasVisibility, setOffcanvasVisibility] = useState(false)

    const handleOffcanvasChange = () => {
        setOffcanvasVisibility(!offcanvasVisibility);
    }



    // const [ageRange, setAgeRange] = useState({ minimumAge: '18', maximumAge: '100' })

    // const [sliderTrackBg, setSliderTrackBg] = useState({ minPercentage: ((ageRange.minimumAge - 18) / 100) * 100,
    //                                                      maxPercentage: (ageRange.maximumAge / 100) * 100 })



    // const handleMinValueChange = (e) => {

    //     if ( (parseInt(ageRange.maximumAge) - parseInt(e.target.value)) <= 0 )
    //     {
    //         setAgeRange({ ...ageRange, minimumAge: ageRange.maximumAge });
    //         setSliderTrackBg({
    //             minPercentage: ((ageRange.minimumAge -18) / 100) * 100,
    //             maxPercentage: (ageRange.maximumAge / 100) * 100
    //         });
    //     }
    //     else
    //     {
    //         setAgeRange({ ...ageRange, minimumAge: e.target.value });
    //         setSliderTrackBg({
    //             minPercentage: ((e.target.value - 18) / 100) * 100,
    //             maxPercentage: (ageRange.maximumAge / 100) * 100
    //         });
    //     }
    // }

    // const handleMaxValueChange = (e) => {

    //     if ( (parseInt(e.target.value) - parseInt(ageRange.maximumAge)) <= 0 )
    //     {
    //         setAgeRange({ ...ageRange, maximumAge: ageRange.minimumAge });
    //         setSliderTrackBg({
    //             minPercentage: ((ageRange.minimumAge - 18) / 100) * 100,
    //             maxPercentage: (ageRange.maximumAge / 100) * 100
    //         });
    //     }
    //     else
    //     {
    //         setAgeRange({ ...ageRange, maximumAge: e.target.value });
    //         setSliderTrackBg({
    //             minPercentage: ((ageRange.minimumAge - 18) / 100) * 100,
    //             maxPercentage: (e.target.value / 100) * 100
    //         });
    //     }
    // }


    const [ageRange, setAgeRange] = useState({ minimumAge: '0', maximumAge: '100' })

    const [sliderTrackBg, setSliderTrackBg] = useState({ minPercentage: (ageRange.minimumAge / 100) * 100,
                                                         maxPercentage: (ageRange.maximumAge / 100) * 100 })



    const handleMinValueChange = (e) => {

        if ( (parseInt(ageRange.maximumAge) - parseInt(e.target.value)) <= 0 )
        {
            setAgeRange({ ...ageRange, minimumAge: ageRange.maximumAge });
            setSliderTrackBg({
                minPercentage: (ageRange.minimumAge / 100) * 100,
                maxPercentage: (ageRange.maximumAge / 100) * 100
            });
        }
        else
        {
            setAgeRange({ ...ageRange, minimumAge: e.target.value });
            setSliderTrackBg({
                minPercentage: (e.target.value / 100) * 100,
                maxPercentage: (ageRange.maximumAge / 100) * 100
            });
        }
    }

    const handleMaxValueChange = (e) => {

        if ( (parseInt(e.target.value) - parseInt(ageRange.minimumAge)) <= 0 )
        {
            setAgeRange({ ...ageRange, maximumAge: ageRange.minimumAge });
            setSliderTrackBg({
                minPercentage: (ageRange.minimumAge / 100) * 100,
                maxPercentage: (ageRange.maximumAge / 100) * 100
            });
        }
        else
        {
            setAgeRange({ ...ageRange, maximumAge: e.target.value });
            setSliderTrackBg({
                minPercentage: (ageRange.minimumAge / 100) * 100,
                maxPercentage: (e.target.value / 100) * 100
            });
        }
    }





    return (
        <Fragment>
            <Navbar />
            <div className={`range-filter-offcanvas ${offcanvasVisibility ? "offcanvas-display" : "offcanvas-hide"}`}>
                <h2 className='tittle-offcanvas'><IoOptions />Filtres</h2>
                <hr className='hr-offcanvas' />
                <div className='range-filter-container-div'>
                    <div className='range-tittle'>Tranche d'âge</div>
                    <div className='range-value-display'>{ageRange.minimumAge}</div>
                    <span className='range-dash'>&nbsp;-</span>
                    <div className='range-filter-container'>
                    <div
                        className='slider-track'
                        style={{background:`linear-gradient(to right, #d5d5d5 ${sliderTrackBg.minPercentage}%, #008176 ${sliderTrackBg.minPercentage}%, #008176 ${sliderTrackBg.maxPercentage}%, #d5d5d5 ${sliderTrackBg.maxPercentage}%`}}
                    ></div>
                    <input
                        type="range"
                        className='range-filter'
                        id="minimumAge"
                        name="minimumAge"
                        min="0"
                        max="100"
                        value={ageRange.minimumAge}
                        onChange={handleMinValueChange}
                    />
                    <input
                        type="range"
                        className='range-filter'
                        id="maximumAge"
                        name="maximumAge"
                        min="0"
                        max="100"
                        value={ageRange.maximumAge}
                        onChange={handleMaxValueChange}
                    />
                </div>
                    <span className='range-dash'>-&nbsp;</span>
                    <div className='range-value-display'>{ageRange.maximumAge}</div>
                    </div>
                {/* <div>Popularité</div>
                <div>Localisation</div>
                <div>Tags en commun</div> */}
                <button className='filter-button' onClick={handleOffcanvasChange}>
                    {offcanvasVisibility ?
                    <IoClose className='filter-logo' /> :
                    <IoOptions className='filter-logo' />}
                </button>
            </div>
            <div className='main-container'>
            </div>
        </Fragment>
    )
}

export default Main