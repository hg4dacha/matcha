import React, { useState } from 'react';
import { Link } from 'react-router-dom';
import { getDistance, convertDistance } from 'geolib';
import differenceInYears from 'date-fns/differenceInYears';
import { AiFillStar } from 'react-icons/ai';
import { MdLocationOn } from 'react-icons/md';





// const username = 'Abdelrahman';
// const age = '1992-06-01T08:59:24.000Z';
// const popularity = '1367';
// const userLocation = { latitude: 45.764043, longitude: 4.835659 };
// const currentUserLocation = { latitude: 48.856614, longitude: 2.3522219 };



const Card = (username, age, popularity, location, thumbnail, currentUserLocation) => {



    const [cardZoom, setCardZoom] = useState(false)

    const handleZoom = () => { setCardZoom(true); }

    const handleZoomOut = () => { setCardZoom(false); }



    return (
        <Link to="/MemberProfile">
            <div className={`card-container ${cardZoom ? "zoom" : ""}`} onMouseOver={handleZoom} onMouseOut={handleZoomOut}>
                <div className='card-picture-content'>
                    <img src={thumbnail} alt='user' className={`card-picture ${cardZoom ? "zoom" : ""}`}/>
                </div>
                <div className='card-user-info'>
                    <div className='card-username-and-age'>{`${username}, ${differenceInYears(new Date(), new Date(age))} ans`}</div>
                    <div className='card-distance-and-popularity'>
                        <span className='card-popularity'>
                            <MdLocationOn className='card-logo' />
                            {`${Math.round(convertDistance(getDistance(currentUserLocation, location), "km"))} km`}
                        </span>
                        &nbsp;&nbsp;&nbsp;
                        <span className='card-popularity'>
                            <AiFillStar className='card-logo' />{`${popularity}`}
                        </span>
                    </div>
                </div>
            </div>
        </Link>
    )
}

export default Card;