import React, { Fragment, useEffect, useState, useContext } from 'react';
import Navbar from '../NavBar/NavBar';
import SearchOption from './SearchOption';
import Card from '../Card/Card';
import { UserContext } from '../UserContext/UserContext';
import { IoClose, IoOptions, IoCalendarClear } from 'react-icons/io5';
import { AiFillStar } from 'react-icons/ai';
import { FaSlackHash, FaMapMarkedAlt } from "react-icons/fa";
import Spinner from 'react-bootstrap/Spinner';
import { useNavigate } from 'react-router-dom';
import axios from 'axios';










const Main = () => {


    const { value, load } = useContext(UserContext);

    const loading = load[0];

    const [userData, setUserData] = useState(null);
    const [users, setUsers] = useState([]);

    const navigate = useNavigate();


    useEffect( () => {

        if(!loading) {

            setUserData(value[0].user);

            axios.get('/users/users')
                .then( (response) => {
                    if (response.status === 200)
                    {
                        setUsers(response.data);
                        document.title = 'Acceuil - Matcha';
                    }
                })
                .catch( (error) => {
                    if(error.request.statusText && error.request.statusText === 'incomplete profile') {
                        navigate("/complete-profile");
                    }
                    else {
                        navigate("/signin");
                    }
                })
        }

    }, [loading, value, navigate])


    
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

        // const optionsSelected = {
        //     ageRangeSelected : { min: ageRange.minimumValue, max: ageRange.maximumValue },
        //     popularityRangeSelected : { min: popularityRange.minimumValue, max: popularityRange.maximumValue },
        //     gapRangeSelected : { min: gapRange.minimumValue, max: gapRange.maximumValue },
        //     tagsRangeSelected : { min: tagsRange.minimumValue, max: tagsRange.maximumValue }
        // }

        // console.log(optionsSelected);

        axios.get(`/users/filter/options?minAge=${ageRange.minimumValue}&maxAge=${ageRange.maximumValue}&minPop=${popularityRange.minimumValue}&maxPop=${popularityRange.maximumValue}&minGap=${gapRange.minimumValue}&maxGap=${gapRange.maximumValue}&minTag=${tagsRange.minimumValue}&maxTag=${tagsRange.maximumValue}`)
        .then( (response) => {
            if (response.status === 200)
            {
                console.log(response.data);
            }
        })
        .catch( (error) => {

        })
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
                    users.length ?
                    users.map( data => {
                        return (
                            <Card
                                key={data.userid}
                                userid={data.userid}
                                username={data.username}
                                age={data.birthdate}
                                popularity={data.popularity}
                                location={{ latitude: data.lat, longitude: data.lng }}
                                thumbnail={data.thumbnail}
                                currentUserLocation={{ latitude: userData.lat, longitude: userData.lng }}
                            />
                        )
                    }) :
                    <div className='loading-cards'>
                        <Spinner animation="border" variant="primary" className='loading-cards-spinner'/>
                        Chargement...
                    </div>
                }
            </div>
        </Fragment>
    )
}

export default Main