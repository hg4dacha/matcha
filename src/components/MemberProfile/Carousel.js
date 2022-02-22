import React, { Fragment, useState } from 'react';




const Carousel$ = ({UserPhotos, forPictureSize}) => {


    const [photo, setPhoto] = useState(0)

    const previousImg = () => {
        photo > 0 && photo <= (UserPhotos.length - 1) ?
        setPhoto(photo - 1) :
        setPhoto(UserPhotos.length - 1) ;
    }

    const nextImg = () => {
        photo >= 0 && photo < (UserPhotos.length - 1) ?
        setPhoto(photo + 1) :
        setPhoto(0) ;
    }

    const buttons = UserPhotos.length === 1 ?
                    null :
                    <Fragment>
                        <button onClick={previousImg} className="carousel-control-prev btn-prev-nxt btn-left" type="button" data-bs-target="#carouselUserImage" data-bs-slide="prev">
                            <span className="carousel-control-prev-icon" aria-hidden="true"></span>
                        </button>
                        <button onClick={nextImg} className="carousel-control-next btn-prev-nxt btn-right" type="button" data-bs-target="#carouselUserImage" data-bs-slide="next">
                            <span className="carousel-control-next-icon" aria-hidden="true"></span>
                        </button>
                    </Fragment> ;

    // DISPLAY AND HIDE BUTTONS ↓↓↓
    const displayButtons = () => {
        if (UserPhotos.length > 1) {
            document.querySelector('.btn-left').style.visibility = 'visible'
            document.querySelector('.btn-right').style.visibility = 'visible'
        }
    }
    const hideButtons = () => {
        if (UserPhotos.length > 1) {
                document.querySelector('.btn-left').style.visibility = 'hidden'
                document.querySelector('.btn-right').style.visibility = 'hidden'
        }
    }

    // FOR PICTURE SIZE ↓↓↓    
    const sizeOfImage = {
        maxWidth: '100%',
        maxHeight: (forPictureSize / 100) * 90
    }


    return (
        <div id="carouselUserImage" className="carousel slide carousel-div" onMouseOver={displayButtons} onMouseOut={hideButtons} data-bs-ride="carousel" data-interval="2000">
            <div className="carousel-inner">
                <div className="carousel-item active">
                    <img src={UserPhotos[photo]} className="d-block img-fluid carousel-images" style={sizeOfImage} alt="user"/>
                </div>
            </div>
            {buttons}
        </div>
    )
}


export default Carousel$;