import React, { Fragment, useEffect, useState } from 'react';
import Navbar from '../NavBar/NavBar';
import SearchOption from './SearchOption';
import Card from '../Card/Card';
import { IoClose, IoOptions, IoCalendarClear } from 'react-icons/io5';
import { AiFillStar } from 'react-icons/ai';
import { FaSlackHash, FaMapMarkedAlt } from "react-icons/fa";



import { USERS_LIST } from "../../other/USERS_LIST";
const currentUserLocation = { latitude: 48.856614, longitude: 2.3522219 };






const Main = () => {


    useEffect( () => {
        document.title = 'Acceuil - Matcha'
    }, [])

    
// _-_-_-_-_-_-_-_-_- OFF CANVAS -_-_-_-_-_-_-_-_-_

    const [offcanvasVisibility, setOffcanvasVisibility] = useState(false)

    const handleOffcanvasChange = () => {
        setOffcanvasVisibility(!offcanvasVisibility);
    }



// _-_-_-_-_-_-_-_-_- OPTIONS STATES -_-_-_-_-_-_-_-_-_

    const [ageRange, setAgeRange] = useState({ minimumValue: '18', maximumValue: '99' })

    const [popularityRange, setPopularityRange] = useState({ minimumValue: '0', maximumValue: '5000' })
    
    const [gapRange, setGapRange] = useState({ minimumValue: '0', maximumValue: '1000' })

    const [tagsRange, setTagsRange] = useState({ minimumValue: '0', maximumValue: '5' })





// _-_-_-_-_-_-_-_-_- IMPLEMENTING OPTIONS -_-_-_-_-_-_-_-_-_

    const handleImplementingOptions = () => {

        const optionsSelected = {
            ageRangeSelected : { min: ageRange.minimumValue, max: ageRange.maximumValue },
            popularityRangeSelected : { min: popularityRange.minimumValue, max: popularityRange.maximumValue },
            gapRangeSelected : { min: gapRange.minimumValue, max: gapRange.maximumValue },
            tagsRangeSelected : { min: tagsRange.minimumValue, max: tagsRange.maximumValue }
        }

        console.log(optionsSelected);
    }





// _-_-_-_-_-_-_-_-_- SEARCH OPTIONS LIST -_-_-_-_-_-_-_-_-_

    const searchOptionsList = [
        {
            key: '1',
            optionTitle: <><IoCalendarClear className='range-logo age'/>Âge (ans)</>,
            basicMinValue: "18",
            basicMaxValue: "99",
            minValueID: "minimumAge",
            maxValueID: "maximumAge",
            step: '1',
            values: ageRange,
            setValues: setAgeRange
        },
        {
            key: '2',
            optionTitle: <><AiFillStar className='range-logo pop'/>Popularité</>,
            basicMinValue: "0",
            basicMaxValue: "5000",
            minValueID: "minimumPopularity",
            maxValueID: "maximumPopularity",
            step: '50',
            values: popularityRange,
            setValues: setPopularityRange
        },
        {
            key: '3',
            optionTitle: <><FaMapMarkedAlt className='range-logo gap'/>Distance (km)</>,
            basicMinValue: "0",
            basicMaxValue: "1000",
            minValueID: "minimumGap",
            maxValueID: "maximumGap",
            step: '10',
            values: gapRange,
            setValues: setGapRange
        },
        {
            key: '4',
            optionTitle: <><FaSlackHash className='range-logo tag'/>Tags en commun</>,
            basicMinValue: "0",
            basicMaxValue: "5",
            minValueID: "minimumTags",
            maxValueID: "maximumTags",
            step: '1',
            values: tagsRange,
            setValues: setTagsRange
        },
    ]



    return (
        <Fragment>
            <Navbar />
            <div className={`range-filter-offcanvas ${offcanvasVisibility ? "offcanvas-display" : "offcanvas-hide"}`}>
                <h2 className='tittle-offcanvas'><IoOptions className='mr-1' />Filtrer les profils</h2>
                <hr className='hr-offcanvas' />
                {searchOptionsList.map( data => {
                    return (
                        <SearchOption
                            key={data.key}
                            optionTitle={data.optionTitle}
                            basicMinValue={data.basicMinValue}
                            basicMaxValue={data.basicMaxValue}
                            minValueID={data.minValueID}
                            maxValueID={data.maxValueID}
                            step={data.step}
                            values={data.values}
                            setValues={data.setValues}
                        />
                    )
                })}
                <button className='apply-filters-button' onClick={handleImplementingOptions}>Appliquer</button>
                <button className='filter-button' onClick={handleOffcanvasChange}>
                    {offcanvasVisibility ?
                    <IoClose className='filter-logo' /> :
                    <IoOptions className='filter-logo' />}
                </button>
            </div>
            <div className='main-container'>
                {
                    USERS_LIST.map( data => {
                        return (
                            <Card
                                key={data.id}
                                userid={data.id}
                                username={data.username}
                                age={data.age}
                                popularity={data.popularity}
                                location={data.location}
                                thumbnail={data.thumbnail}
                                currentUserLocation={currentUserLocation}
                            />
                        )
                    })
                }
            </div>
        </Fragment>
    )
}

export default Main