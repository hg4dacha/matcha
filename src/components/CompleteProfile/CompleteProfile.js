import React, { useState, useEffect, Fragment, useContext } from 'react';
import Alert from 'react-bootstrap/Alert';
import ProfilePictureSection from '../Profile/ProfilePictureSection';
import UserPhotosSection from '../Profile/UserPhotosSection';
import LogOut from '../LogOut/LogOut';
import Form from 'react-bootstrap/Form';
import Button from 'react-bootstrap/Button';
import Spinner from 'react-bootstrap/Spinner';
import DatePicker from 'react-datepicker';
import 'react-datepicker/dist/react-datepicker.css';
import fr from "date-fns/locale/fr";
import differenceInYears from 'date-fns/differenceInYears';
import ValidatedInfo from './ValidatedInfo'
import GenderAndOrientation from '../Profile/GenderAndOrientation'
import TagsBadge from '../MemberProfile/TagsBadge';
import Location from '../Profile/Location'
import AlertMsg from '../AlertMsg/AlertMsg';
import { UserContext } from '../UserContext/UserContext';
import { v4 as uuidv4 } from 'uuid';
import { RiErrorWarningLine, RiSaveFill } from 'react-icons/ri';
import { CgCardHearts } from 'react-icons/cg';
import { TiLocation, TiInfo } from 'react-icons/ti';
import { IoPinSharp, IoMaleFemaleSharp, IoCalendarOutline } from 'react-icons/io5';
import { IoIosCloseCircle } from 'react-icons/io';
import { FaSearchLocation, FaSlackHash } from "react-icons/fa";
import { BsInfoCircle, BsPersonCheck } from "react-icons/bs";
import { BiCalendarAlt } from "react-icons/bi";
import { MdPhotoFilter } from "react-icons/md";
import { useNavigate } from 'react-router-dom';
import axios from 'axios';





const CompleteProfile = () => {


    const navigate = useNavigate();

    const {user, setUser} = useContext(UserContext);


    useEffect( () => {
        console.log(user);
        document.title = 'Compléter profil - Matcha'
    }, [])


    // INFORMATION DATA ↓↓↓
    const infoData_ = [
        {
            label: 'Nom',
            info: ""
        },
        {
            label: 'Prénom',
            info: ""
        },
        {
            label: 'Nom d\'utilisateur',
            info: ""
        },
        {
            label: 'E-mail',
            info: ""
        }
    ]

    const [infoData, setInfoData] = useState(infoData_)


    useEffect( () => {

        axios.get('/users/conclude')
        .then( (response) => {
            if (response.status === 200)
            {
                setInfoData([
                    {
                        label: 'Nom',
                        info: response.data.lastname
                    },
                    {
                        label: 'Prénom',
                        info: response.data.firstname
                    },
                    {
                        label: 'Nom d\'utilisateur',
                        info: response.data.username
                    },
                    {
                        label: 'E-mail',
                        info: response.data.email
                    }
                ])
            }
        })
        .catch( (error) => {
            if (error.request.statusText === 'registration invalidated' || error.request.status === 401)
            {
                navigate("/signin");
            }
            else if (error.request.statusText === 'completed profile')
            {
                navigate("/users");
            }
            else
            {
                navigate("/notfound");
            }
        })

    }, [navigate])
    

// _-_-_-_-_-_-_-_-_- PROFILE PICTURE SECTION -_-_-_-_-_-_-_-_-_


    // PROFILE PICTURE ↓↓↓
    const _profilePicture = {
        profilePicture: null,
    }
    
    const [profilePicture, setProfilePicture] = useState(_profilePicture)


    // PICTURE LOADING ↓↓↓
    const [profilePictureLoading, setProfilePictureLoading] = useState({ profilePicture: false })


    // INCORRECT DATA ↓↓↓
    const [profilePictureDataError, setProfilePictureDataError] = useState({ error: false, msg: ''})


    // CHANGE PICTURE ↓↓↓
    const handleProfilePictureChange = e => {

        setProfilePictureLoading({ profilePicture: true });

        if (e.target.files && e.target.files[0])
        {
            if (e.target.files[0].type === "image/jpeg" ||
                e.target.files[0].type === "image/jpg" ||
                e.target.files[0].type === "image/png")
            {
                const reader = new FileReader();

                reader.addEventListener("load", () => {
                    setProfilePicture({ profilePicture: reader.result });
                    setProfilePictureLoading({ profilePicture: false});
                    setProfilePictureDataError({ error: false, msg: ""});
                }, false);

                reader.readAsDataURL(e.target.files[0]);
            }
            else
            {
                e.target.value = null;
                updateErrorAlert();
                setProfilePictureDataError({ error: true, msg: " Seul les fichiers 'jpeg', 'jpg' et 'png' sont acceptés"});
                setProfilePictureLoading({ profilePicture: false});
            }
        }
        else
        {
            setProfilePictureLoading({ profilePicture: false });
        }

    }





    // _-_-_-_-_-_-_-_-_- USER PICTURES SECTION -_-_-_-_-_-_-_-_-_


    // USER PICTURES ↓↓↓
    const _userPictures = {
        secondPicture: false,
        thirdPicture: false,
        fourthPicture: false,
        fifthPicture: false
    }
    
    const [userPictures, setUserPictures] = useState(_userPictures)


    // PICTURE LOADING ↓↓↓
    const [pictureLoading, setPictureLoading] = useState({
        secondPicture: false,
        thirdPicture: false,
        fourthPicture: false,
        fifthPicture: false
    })


    // INCORRECT DATA ↓↓↓
    const [pictureDataError, setPictureDataError] = useState({ error: false, msg: ''})


    // CHANGE PICTURE ↓↓↓
    const handlePictureChange = e => {

        setPictureLoading({...pictureLoading, [e.target.id]: true});

        if (e.target.files && e.target.files[0])
        {
            if (e.target.files[0].type === "image/jpeg" ||
                e.target.files[0].type === "image/jpg" ||
                e.target.files[0].type === "image/png")
            {
                const reader = new FileReader();

                reader.addEventListener("load", () => {
                    setUserPictures({...userPictures, [e.target.id]: reader.result});
                    setPictureLoading({...pictureLoading, [e.target.id]: false});
                    setPictureDataError({ error: false, msg: ""});
                }, false);

                reader.readAsDataURL(e.target.files[0]);
            }
            else
            {
                e.target.value = null;
                updateErrorAlert();
                setPictureDataError({ error: true, msg: " Seul les fichiers 'jpeg', 'jpg' et 'png' sont acceptés"});
                setPictureLoading({...pictureLoading, [e.target.id]: false});
            }
        }
        else
        {
            setPictureLoading({...pictureLoading, [e.target.id]: false});
        }

    }

    // DELETE PICTURE ↓↓↓
    const handleDeletePicture = (e) => {

        setUserPictures({...userPictures, [e.currentTarget.name]: false});

    }





// _-_-_-_-_-_-_-_-_- USER AGE SECTION -_-_-_-_-_-_-_-_-_


    // USER AGE ↓↓↓
    const [dateSelected, setDateSelected] = useState(null)

    const _userAge = '...';
    const [userAge, setUserAge] = useState(_userAge)

    const handleDateSelectedChange = (e) => {

        setDateSelected(e);
        (e !== null) &&
        setUserAge(differenceInYears(new Date(), e));
    }

    
    // INCORRECT DATA ↓↓↓
    const [dateDataError, setDateDataError] = useState(false)
    // ON SUBMIT NEW AGE ↓↓↓
    const userAgeChecking = () => {

        if (dateSelected)
        {
            if ( (dateSelected instanceof Date) && (Object.prototype.toString.call(dateSelected)) &&
                 !(isNaN(dateSelected)) )
            {
                if ( (differenceInYears(new Date(), dateSelected)) > 18 &&
                    (differenceInYears(new Date(), dateSelected)) <= 130 )
                {
                    setDateDataError(false);
                    return(false);
                }
                else
                {
                    setDateDataError(true);
                    return(true);
                }
            }
        }
        else
        {
            setDateDataError(true);
            return(true);
        }
    }






// _-_-_-_-_-_-_-_-_- GENDER AND ORIENTATION SECTION -_-_-_-_-_-_-_-_-_


    // GENDER (RADIO) ↓↓↓
    const _genderChecked = {
        maleGender: false,
        femaleGender: false
    }

    const [genderChecked, setGenderChecked] = useState(_genderChecked)



    // ORIENTATION (CHECKBOX) ↓↓↓
    const _orientationChecked = {
        maleOrientation: false,
        femaleOrientation: false
    }

    const [orientationChecked, setOrientationChecked] = useState(_orientationChecked)


    // INCORRECT DATA ↓↓↓
    const [genderOrientationDataError, setGenderOrientationDataError] = useState(false)
    // ON SUBMIT NEW GENDER OR ORIENTATION ↓↓↓
    const genderAndOrientationChecking = () => {

        if ( (typeof(genderChecked.maleGender) === 'boolean') && (typeof(genderChecked.femaleGender) === 'boolean') &&
                (typeof(orientationChecked.maleOrientation) === 'boolean') && (typeof(orientationChecked.femaleOrientation) === 'boolean') )
        {
            if ( (genderChecked.maleGender !== genderChecked.femaleGender) &&
                    (orientationChecked.maleOrientation === true || orientationChecked.femaleOrientation === true) )
            {
                setGenderOrientationDataError(false);
                return (false);
            }
            else
            {
                setGenderOrientationDataError(true);
                return(true);
            }
        }
        else
        {
            setGenderOrientationDataError(true);
            return(true);
        }
    }





// _-_-_-_-_-_-_-_-_- PROFILE DESCRIPTION SECTION -_-_-_-_-_-_-_-_-_


    const [description, setDescription] = useState('')

    const handleDescriptionChange = e => {
        setDescription(e.target.value)
    }
    
    
    // INCORRECT DATA ↓↓↓
    const [descriptionDataError, setDescriptionDataError] = useState(false)
    // ON SUBMIT NEW DESCRIPTION ↓↓↓
    const descriptionChecking = () => {

        if ( description !== '' )
        {
            if ( description.length <= 650 )
            {
                setDescriptionDataError(false);
                return (false);
            }
            else
            {
                setDescriptionDataError(true);
                return (true);
            }
        }
        setDescriptionDataError(true);
        return (true);
    }





// _-_-_-_-_-_-_-_-_- TAGS SECTION -_-_-_-_-_-_-_-_-_
    
    
    // USER TAGS ↓↓↓
    const _userTags = []
    
    const [userTags, setUserTags] = useState(_userTags)


    const handleAddTag = (e) => {

        const tagID = e.currentTarget.id
        if ( (userTags.length < 5) && !(userTags.includes(tagID)) )
        {
            setUserTags(prevState => [...prevState, tagID]);
        }
    }


    const handleRemoveTag = (e) => {

        userTags.length > 0 &&
        setUserTags(userTags.filter(tag => tag !== e.currentTarget.id));
    }
    
    
    // INCORRECT DATA ↓↓↓
    const [userTagsDataError, setUserTagsDataError] = useState(false)
    // ON SUBMIT NEW TAGS ↓↓↓
    const userTagsChecking = () => {

        if ( userTags.length === 5 )
        {
            setUserTagsDataError(false);
            return (false);
        }
        else
        {
            setUserTagsDataError(true);
            return (true);
        }
    }





// _-_-_-_-_-_-_-_-_- USER LOCATION SECTION -_-_-_-_-_-_-_-_-_


    // USER LOCATION ↓↓↓
    const _userLocation = {
        lat: 47.0814396,
        lng: 2.3986275,
        city: '',
        state: '',
        country: ''
    }
    const [userLocation, setUserLocation] = useState(_userLocation)


    // ACTIVATION OF GEOLOCATION ↓↓↓
    const [geolocationActivated, setGeolocationActivated] = useState(false)

    const enableGeolocation = () => {
        setGeolocationActivated(true);
    }


    // INCORRECT DATA ↓↓↓
    const [userLocationDataError, setUserLocationDataError] = useState({ error: false, msg: '' })



    // ON SUBMIT NEW LOCATION ↓↓↓
    const userLocationChecking = () => {

        if ( !isNaN(userLocation.lat) && !isNaN(userLocation.lng) )
        {
            if (userLocation.country === 'France')
            {
                setUserLocationDataError({ error: false, msg: '' });
                return (false);
            }
            else if (userLocation.country === '')
            {
                setUserLocationDataError({ error: true, msg: 'Veuillez vous géolocaliser' });
            }
            else
            {
                setUserLocationDataError({ error: true, msg: 'Matcha est réservé aux utilisateurs résidant en France' });
                return (true);
            }
        }
        else
        {
            setUserLocationDataError({ error: true, msg: 'Une erreur est survenue' });
            return (true);
        }
    }





// _-_-_-_-_-_-_-_-_- SUBMIT COMPLEMENTARY INFORMATION -_-_-_-_-_-_-_-_-_


    const[dataValidationWaiting, setDataValidationWaiting] = useState(false)

    const handleSubmitComplementaryInformation = e => {
        e.preventDefault();
        setProfilePictureDataError({ error: false, msg: ''});

        const userAgeInvalid = userAgeChecking();
        const genderAndOrientationInvalid = genderAndOrientationChecking();
        const descriptionInvalid = descriptionChecking();
        const userTagsInvalid = userTagsChecking();
        const userLocationInvalid = userLocationChecking();

        if ( userAgeInvalid === false && genderAndOrientationInvalid === false &&
             descriptionInvalid === false && userTagsInvalid === false &&
             userLocationInvalid === false )
        {
            if ( profilePicture.profilePicture )
            {
                setDataValidationWaiting(true);
                axios.post('/users/conclude', {
                    profilePicture: profilePicture,
                    userPictures: userPictures,
                    dateSelected: dateSelected,
                    genderChecked: genderChecked,
                    orientationChecked: orientationChecked,
                    userLocation: userLocation,
                    userTags: userTags,
                    description: description
                })
                .then( (response) => {
                    if (response.status === 200)
                    {
                        setDataValidationWaiting(false);
                        navigate("/users");
                    }
                })
                .catch( () => {
                    setDataValidationWaiting(false);
                    updateErrorAlert();
                })
            }
            else
            {
                updateErrorAlert();
                setProfilePictureDataError({ error: true, msg: 'Une photo de profil est obligatoire'});
            }
        }
        else
        {
            updateErrorAlert();
        }
    }





// _-_-_-_-_-_-_-_-_- DATA SECTION -_-_-_-_-_-_-_-_-_


    // PICTURES DATA ↓↓↓
    const picturesData = [
        {
            picture: userPictures.secondPicture,
            id: 'secondPicture',
            number: '2',
            handleDeletePicture: handleDeletePicture,
            handlePictureChange: handlePictureChange,
            pictureLoading: pictureLoading.secondPicture
        },
        {
            picture: userPictures.thirdPicture,
            id: 'thirdPicture',
            number: '3',
            handleDeletePicture: handleDeletePicture,
            handlePictureChange: handlePictureChange,
            pictureLoading: pictureLoading.thirdPicture
        },
        {
            picture: userPictures.fourthPicture,
            id: 'fourthPicture',
            number: '4',
            handleDeletePicture: handleDeletePicture,
            handlePictureChange: handlePictureChange,
            pictureLoading: pictureLoading.fourthPicture
        },
        {
            picture: userPictures.fifthPicture,
            id: 'fifthPicture',
            number: '5',
            handleDeletePicture: handleDeletePicture,
            handlePictureChange: handlePictureChange,
            pictureLoading: pictureLoading.fifthPicture
        }
    ]




    // TAGS DATA ↓↓↓
    const tagsData = ["food", "science", "intello", "coding", "dodo", "bio", "geek", "vegan",
                      "artiste", "meditation", "paresse", "fitness", "aventure", "timide", "marketing",
                      "fastfood", "intelligence", "humour", "cool", "highTech", "globetrotting", "histoire",
                      "shopping", "nature", "sport", "football", "literature", "math", "action", "faitsDivers",
                      "decouverte", "cinema", "musique", "actualite", "politique", "social", "etudes",
                      "cuisine", "humanitaire", "animaux", "environnement", "jeuxVideo", "peinture", "dessin",
                      "ecriture", "lecture", "photographie", "chasse", "randonnee", "marche", "plage", "detente",
                      "automobile", "couture", "innovation", "terroir", "informatique", "marathon", "blogging"]




// _-_-_-_-_-_-_-_-_- ALERT -_-_-_-_-_-_-_-_-_


    const [alertMessages, setAlertMessages] = useState([])


    const handleNewAlert = (newAlert) => {

        setAlertMessages(prevState => prevState.slice(1));
        setAlertMessages(prevState => [...prevState, newAlert]);
    }


    const updateErrorAlert = () => {
        handleNewAlert({id: uuidv4(),
                        variant: "error",
                        information: "Oups ! Erreur..."})
    }





 
    return (
        <Fragment>
            {
                alertMessages.map( alert => {
                    return (
                        <AlertMsg
                            key={alert.id}
                            variant={alert.variant}
                            information={alert.information}
                        />
                    )
                })
            }
            <header>
                <Alert variant='warning' className='complete-profile-alert'>
                    <TiInfo className='mr-2 complete-info-alert-logo' />
                    Veuillez compléter votre profil pour accéder aux autres services
                    <div className='complete-profile-logout'>
                        <LogOut />
                    </div>
                </Alert>
            </header>
            <div className='big-info-container centerElementsInPage'>
                <h2 className='personal-information' style={{color: '#0F5132'}}>Vos informations personelles</h2>
                <div className='complete-profile-validated-information-container'>
                    { infoData.map( data => {
                            return (
                                <ValidatedInfo
                                    key={uuidv4()}
                                    label={data.label}
                                    info={data.info}
                                />
                            )
                        })
                    }
                    <BsPersonCheck className='complete-profile-icons val-inf-log' color='#65746E' />
                </div>
                <hr className='hr-profile vf-hr'/>
                <Form className='complete-profile-form' onSubmit={handleSubmitComplementaryInformation}>
                    <h2 className='personal-information-profile-picture'>Photo de profil</h2>
                    <h4 className='complete-profile-indication'><BsInfoCircle className='mr-1' />Importez une photo pour votre profil</h4>
                    <div className='info-container-profile-picture inf-cnt-marg'>
                        <div className='profile-picture-from'>
                            <ProfilePictureSection
                                picture={profilePicture.profilePicture}
                                id='profilePicture'
                                handlePictureChange={handleProfilePictureChange}
                                pictureLoading={profilePictureLoading.profilePicture}
                            />
                            {
                            profilePictureDataError.error &&
                            <div className='error-update-profile-div'>
                                <Form.Text className='error-update-profile'>
                                    <RiErrorWarningLine/>
                                    {profilePictureDataError.msg}
                                </Form.Text>
                            </div>
                            }
                        </div>
                    </div>
                    <hr className='hr-profile vf-hr'/>
                    <h2 className='personal-information'>Photos supplémentaires</h2>
                    <div className='info-container'>
                        <h4 className='complete-profile-indication'><BsInfoCircle className='mr-1' />Vous pouvez ajouter jusqu'à 4 photos</h4>
                        <div className='user-photo-from'>
                            { picturesData.map ( data => {
                                return (
                                    <UserPhotosSection
                                        key={data.id}
                                        picture={data.picture}
                                        id={data.id}
                                        number={data.number}
                                        handleDeletePicture={data.handleDeletePicture}
                                        handlePictureChange={data.handlePictureChange}
                                        pictureLoading={data.pictureLoading}
                                    />
                                )
                            })
                            }
                            <MdPhotoFilter className='complete-profile-icons'/>
                            {
                            pictureDataError.error &&
                            <div className='error-update-profile-div'>
                                <Form.Text className='error-update-profile'>
                                    <RiErrorWarningLine/>
                                    {pictureDataError.msg}
                                </Form.Text>
                            </div>
                            }
                        </div>
                    </div>
                    <hr className='hr-profile vf-hr'/>
                    <h2 className='personal-information'>Date de naissance</h2>
                    <div className='info-container'>
                        <h4 className='complete-profile-indication'><BsInfoCircle className='mr-1' />Définissez votre date de naissance</h4>
                        <div className='d-flex align-items-center dat-pic-cnt'>
                            <div className='age-user-label'>Âge</div>
                            <div className='age-user-div'>
                                <div className='age-user'>{`${userAge} ans`}</div>
                                <hr className='hr-age-user'/>
                                <div className='d-flex align-items-center'>
                                    <BiCalendarAlt className='calendar-age-user-icon'/>
                                    <DatePicker
                                        selected={dateSelected}
                                        onChange={handleDateSelectedChange}
                                        locale={fr}
                                        dateFormat="dd/MM/yyyy"
                                        maxDate={new Date()}
                                        closeOnScroll={true}
                                        isClearable={true}
                                        fixedHeight
                                        placeholderText="Entrez une date • jj/mm/aaaa"
                                    />
                                </div>
                            </div>
                            <IoCalendarOutline className='complete-profile-icons'/>
                            {
                            dateDataError &&
                            <div className='error-update-profile-div'>
                                <Form.Text className='error-update-profile'>
                                    <RiErrorWarningLine/>
                                    Matcha est réservé aux majeurs
                                </Form.Text>
                            </div>
                            }
                        </div>
                    </div>
                    <hr className='hr-profile'/>
                    <h2 className='personal-information'>Genre et orientation</h2>
                    <div className='info-container'>
                        <h4 className='complete-profile-indication'><BsInfoCircle className='mr-1' />Définissez votre genre et orientation</h4>
                        <GenderAndOrientation
                            genderChecked={genderChecked}
                            setGenderChecked={setGenderChecked}
                            orientationChecked={orientationChecked}
                            setOrientationChecked={setOrientationChecked}
                        />
                        <IoMaleFemaleSharp className='complete-profile-icons'/>
                        {
                        genderOrientationDataError &&
                        <div className='error-update-profile-div'>
                            <Form.Text className='error-update-profile'>
                                <RiErrorWarningLine />
                                Complétez les informations
                            </Form.Text>
                        </div>
                        }
                    </div>
                    <hr className='hr-profile'/>
                    <h2 className='personal-information'>Description</h2>
                    <div className='info-container'>
                        <h4 className='complete-profile-indication'><BsInfoCircle className='mr-1' />Decrivez-vous en quelques lignes</h4>
                        <textarea
                            className='profile-description-textarea'
                            value={description}
                            onChange={handleDescriptionChange}
                            autoComplete='off'
                            placeholder='650 caractères max.'
                            minLength='1'
                            maxLength='650'
                            autoCapitalize='on'
                        >
                        </textarea>
                        <CgCardHearts className='complete-profile-icons'/>
                        {
                        descriptionDataError &&
                        <div className='error-update-profile-div'>
                            <Form.Text className='error-update-profile'>
                                <RiErrorWarningLine/>
                                Vos entrées ne sont pas valide
                            </Form.Text>
                        </div>
                        }
                    </div>
                    <hr className='hr-profile'/>
                    <h2 className='personal-information'>Tags</h2>
                    <div className='info-container'>
                        <h4 className='complete-profile-indication'><BsInfoCircle className='mr-1' />Sélectionnez 5 tags vous correspondant</h4>
                        <div className='tags-section'>
                            { tagsData.map( data => {
                                return (
                                    <div key={uuidv4()} id={data} onClick={handleAddTag} className='tag-list-div'>
                                        <TagsBadge tag={data} />
                                    </div>
                                )
                            })
                            }
                        </div>
                        <div className='user-tags-selected'>
                            { userTags.map( data => {
                                return (
                                    <div key={uuidv4()} id={data} onClick={handleRemoveTag} className='user-tags-div'>
                                        <TagsBadge tag={data} />
                                        <IoIosCloseCircle className='tag-hide' />
                                    </div>
                                )
                            })
                            }
                        </div>
                        <FaSlackHash className='complete-profile-icons'/>
                        {
                        userTagsDataError &&
                        <div className='error-update-profile-div'>
                            <Form.Text className='error-update-profile'>
                                <RiErrorWarningLine/>
                                Veuillez sélectionner 5 tags de la liste
                            </Form.Text>
                        </div>
                        }
                    </div>
                    <hr className='hr-profile'/>
                    <h2 className='personal-information'>Localisation</h2>
                    <div className='info-container'>
                        <h4 className='complete-profile-indication'><BsInfoCircle className='mr-1' />Localisez vous</h4>
                        <div className='user-city-location-container'>
                            <h3 className='user-city-location'>
                                <IoPinSharp/>
                                {
                                userLocation.city === '' ?
                                '...' :
                                `${userLocation.city}, ${userLocation.state} (${userLocation.country})`
                                }
                            </h3>
                            <Button
                                variant="info"
                                disabled={geolocationActivated ? true : false}
                                className='activate-geolocation'
                                onClick={enableGeolocation}
                            >
                            {
                            geolocationActivated ?
                            <Spinner as="span" animation="border"
                                        size="sm" role="status"
                                        aria-hidden="true"/> :
                            <TiLocation/>
                            }
                                
                                Activer la géolocalisation
                            </Button>
                        </div>
                        <Location
                            userLocation={userLocation}
                            setUserLocation={setUserLocation}
                            geolocationActivated={geolocationActivated}
                            setGeolocationActivated={setGeolocationActivated}
                            setUserLocationDataError={setUserLocationDataError}
                            updateErrorAlert={updateErrorAlert}
                            zoom={5}
                        />
                        <FaSearchLocation className='complete-profile-icons'/>
                        {
                        userLocationDataError.error &&
                        <div className='error-update-profile-div'>
                            <Form.Text className='error-update-profile'>
                                <RiErrorWarningLine/>
                                {userLocationDataError.msg}
                            </Form.Text>
                        </div>
                        }
                    </div>
                    <hr className='hr-profile'/>
                    <button className='complete-profile-button' type='submit'>
                        {dataValidationWaiting ?
                        <Spinner className='mr-1' as="span" animation="border" size="sm" role="status" aria-hidden="true"/> :
                        <RiSaveFill className='mr-1' />}
                        Enregistrer mes informations
                    </button>
                </Form>
            </div>
        </Fragment>
        
    )
}

export default CompleteProfile