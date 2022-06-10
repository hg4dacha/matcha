import React, { Fragment, useEffect, useState, useRef, useCallback, useContext, useMemo } from 'react';
import { useParams, useNavigate } from 'react-router-dom';
import { UserContext } from '../UserContext/UserContext';
import { v4 as uuidv4 } from 'uuid';
import ConfirmWindow from '../ConfirmWindow/ConfirmWindow';
import Chat from './Chat';
import Carousel from './Carousel';
import TagsBadge from './TagsBadge';
import Button from 'react-bootstrap/Button'
import differenceInYears from 'date-fns/differenceInYears';
import { MdBlock } from "react-icons/md";
import { GoPrimitiveDot } from "react-icons/go";
import { IoMdHeartEmpty, IoMdHeart, IoMdFlashlight } from "react-icons/io";
import { AiFillStar } from 'react-icons/ai';
import { GiPositionMarker } from 'react-icons/gi';
import { TiWarningOutline } from "react-icons/ti";
import { BiSearch } from "react-icons/bi";
import { RiUser3Line } from "react-icons/ri";
import { FiCalendar } from "react-icons/fi";
import { IoMaleFemaleSharp } from "react-icons/io5";
import { HiBadgeCheck } from "react-icons/hi";
import axios from 'axios';





const AccessProfile = (props) => {

    const { value } = useContext(UserContext);
    const user = value[0];
    const navigate = useNavigate();

    const [userPersonalInfo, setUserPersonalInfo] = useState({
        username: '',
        popularity: '',
        connectionStatue: '',
        lastConnection: '',
        lastname: '',
        firstname: '',
        birthdate: '',
        locationUser: '',
        gender: '',
        maleOrientation: '',
        femaleOrientation: '',
        descriptionUser: '',
        profileLiked: '',
        currentUserLiked:''
    });
    const info = useMemo( () => ({userPersonalInfo, setUserPersonalInfo}), [userPersonalInfo, setUserPersonalInfo]);
    const [userTags, setUserTags] = useState([]);
    const [userPhotos, setUserPhotos] = useState([]);
    const [pictureSize, setPictureSize] = useState(null);
    const [initialRequest, setInitialRequest] = useState(false)
    const params = useParams();


    let requestTimeOut = useRef();
    const currentUserBlocked = props.onCurrentUserBlocked;

    const getDisplayData = useCallback( () => {

        axios.get(`/users/profile-refresh/${params.userid}`)
        .then( (response) => {
            if(response.status === 200) {
                if(response.data.currentUserBlocked) {
                    currentUserBlocked();
                    return;
                }
                else {
                    info.setUserPersonalInfo(prevState => ({
                        ...prevState,
                        connectionStatue: response.data.connectionStatue,
                        profileLiked: response.data.profileLiked,
                        currentUserLiked: response.data.currentUserLiked
                    }));
                }
            }
        })
        .catch( (error) => {
            navigate("/users");
        })

    }, [currentUserBlocked, params.userid, info, navigate])


    useEffect( () => {

        if(!initialRequest) {

            axios.get(`/users/data/${params.userid}`)
            .then( (response) => {
                if (response.status === 200)
                {
                    info.setUserPersonalInfo({
                        username: response.data.username,
                        popularity: response.data.popularity,
                        connectionStatue: response.data.connectionStatue,
                        lastConnection: response.data.lastConnection,
                        lastname: response.data.lastname,
                        firstname: response.data.firstname,
                        birthdate: response.data.birthdate,
                        locationUser: JSON.parse(response.data.locationUser),
                        gender: response.data.gender,
                        maleOrientation: response.data.maleOrientation,
                        femaleOrientation: response.data.femaleOrientation,
                        descriptionUser: response.data.descriptionUser,
                        profileLiked: response.data.profileLiked,
                        currentUserLiked: response.data.currentUserLiked
                    });
                    setUserTags(
                        JSON.parse(response.data.tags)
                    );
                    response.data.profilePicture &&
                    setUserPhotos(prevState => [...prevState, response.data.profilePicture]);
                    response.data.secondPicture &&
                    setUserPhotos(prevState => [...prevState, response.data.secondPicture]);
                    response.data.thirdPicture &&
                    setUserPhotos(prevState => [...prevState, response.data.thirdPicture]);
                    response.data.fourthPicture &&
                    setUserPhotos(prevState => [...prevState, response.data.fourthPicture]);
                    response.data.fifthPicture &&
                    setUserPhotos(prevState => [...prevState, response.data.fifthPicture]);
                    setLike(response.data.profileLiked);
                }
            })
            .catch( (error) => {
                navigate("/notfound");
            })

            setPictureSize(document.querySelector('.profile-description').offsetHeight);

            window.onresize = () => {
                setPictureSize(document.querySelector('.profile-description').offsetHeight);
            }

        }

        requestTimeOut.current = setInterval( () => {
            getDisplayData();
        }, 5000);

        setInitialRequest(true);

        return () => {
            window.onresize = () => null;
            clearInterval(requestTimeOut.current);
        }

    }, [params.userid, getDisplayData, info, initialRequest, navigate])



    // LIKE DISLIKE ↓↓↓
    const [like, setLike] = useState(false)

    const toLike = () => {
        axios.post('/likes/add', params.userid)
        .then( (response) => {
            if (response.status === 200)
            {
                setLike(true)
                props.onLike()
            }
        })
        .catch( (error) => {
            props.errorAlert();
        })
    }

    const toDislike = () => {
        axios.delete('/likes/delete', { data: params.userid  })
        .then( (response) => {
            if (response.status === 200)
            {
                setLike(false)
                props.onDislike()
            }
        })
        .catch( (error) => {
            props.errorAlert();
        })
    }

    const heart = like ?
        <Button variant="offline-danger" onClick={ () => toDislike() } className='button-like act'>
            <IoMdHeart className='like-heart' color='darkred' />
        </Button> :
        <Button variant="offline-danger" onClick={ () => toLike() } className='button-like dis'>
            <IoMdHeartEmpty className='like-heart' color='rgb(1, 1, 3)' />
        </Button> ;




    // BLUR WHEN OPENING CHAT ↓↓↓
    const [chatState, setChatState] = useState(false)

    const blurFunc = (chatDrawer) => {    
        setChatState(chatDrawer);
    }


    // CONFIRMATION WINDOW ↓↓↓
    const [confirmWindow, setConfirmWindow] = useState(false)

    //..... BLOCKING .....
    const blockProfile = {
        act: "Bloquer l'utilisateur",
        quest: "bloquer l'utilisateur",
        onConfirm: props.onBlockingConfirmation
    }

    //..... REPORT .....
    const reportProfile = {
        act: "Signaler le profil",
        quest: "signaler le profil commme étant faux",
        onConfirm: props.onReportConfirmation
    }

    //..... DISPLAY CONFIRM WINDOW .....
    const displayConfirmWindow = (act) => {
        setMsgConfirmWindow(act)
        setConfirmWindow(true)
    }

    const [msgConfirmWindow, setMsgConfirmWindow] = useState(null)

    const confirmationWindow = confirmWindow ?
                               <ConfirmWindow
                                    act={msgConfirmWindow.act}
                                    quest={msgConfirmWindow.quest}
                                    onCancel={setConfirmWindow}
                                    onConfirm={msgConfirmWindow.onConfirm}
                               /> :
                               null ;


    return (
        <Fragment>
            {confirmationWindow}
            {
                (info.userPersonalInfo.profileLiked && info.userPersonalInfo.currentUserLiked) &&
                <Chat
                    thumbnail={userPhotos[0]}
                    username={info.userPersonalInfo.username}
                    userId={user && user.user.user_id}
                    profileId={params.userid}
                    onChatChange={blurFunc}
                    onDeleteDiscussion={displayConfirmWindow}
                    onDeleteDiscussionConfirmation={props.onDeleteDiscussionConfirmation}
                    errorAlert={props.errorAlert}
                />
            }
            <div className={`profile-description ${chatState ? 'profile-blurring' : ''}`}>
                <div className='photos-part'>
                    <div className='photos-list'>
                        {userPhotos[0] &&
                        <Carousel userPhotos={userPhotos} forPictureSize={pictureSize} />}
                    </div>
                </div>
                <div className='infos-part'>
                    <div className='infos-list'>
                        <div className='username-global-div'>
                            <div className='username-and-popularity'>
                                <h1 className='username-member-profile'>{info.userPersonalInfo.username}</h1>
                                <span className='popularity popularity-member-profile'><AiFillStar className='star'/>{`${info.userPersonalInfo.popularity}°`}</span>
                                <HiBadgeCheck className='was-liked' />
                            </div>
                            {
                                info.userPersonalInfo.connectionStatue === '1' ?
                                <small className='user-connection-status'><GoPrimitiveDot color='#009432' />
                                    En ligne
                                </small> :
                                <small className='user-connection-status'><GoPrimitiveDot color='#7f8c8d' />
                                    Hors ligne
                                    <span className='last-connection'>
                                        &nbsp;&nbsp;Dernière connexion le&nbsp;
                                        {`${new Date(info.userPersonalInfo.lastConnection).toLocaleDateString('fr-FR', {day: '2-digit', month: '2-digit', year: '2-digit'})} à ${new Date(info.userPersonalInfo.lastConnection).toLocaleTimeString('fr-FR', {hour: '2-digit', minute: '2-digit'})}`}
                                    </span>
                                </small>
                            }
                            <div className='button-like-div'>
                                {heart}
                            </div>
                        </div>
                        <div>
                            <div className='alignment'>
                                <RiUser3Line className='user-infos-icons'/>{`${info.userPersonalInfo.lastname} ${info.userPersonalInfo.firstname}`}
                            </div>
                            <div className='alignment'>
                                <FiCalendar className='user-infos-icons'/>
                                {info.userPersonalInfo.birthdate && `${differenceInYears(new Date(), new Date(info.userPersonalInfo.birthdate))} ans`}
                            </div>
                            <div className='alignment'>
                                <GiPositionMarker className='user-infos-icons'/>{`${info.userPersonalInfo.locationUser.city}, ${info.userPersonalInfo.locationUser.state} (${info.userPersonalInfo.locationUser.country})`}
                            </div>
                            <div className='alignment'>
                                <IoMaleFemaleSharp className='user-infos-icons'/>Je suis
                                <span className='bold' style={{color: '#40739e'}}>&nbsp;{info.userPersonalInfo.gender === 'MALE' ? 'un homme' : 'une femme'}</span>
                            </div>
                            <div className='alignment'>
                                <BiSearch className='user-infos-icons'/>Je cherche
                                <span className='bold' style={{color: '#58B19F'}}>&nbsp;{
                                    (info.userPersonalInfo.maleOrientation === '1' && info.userPersonalInfo.femaleOrientation === '1') ?
                                    "un homme et une femme" :
                                    (info.userPersonalInfo.maleOrientation === '1' ? "un homme" : "une femme")
                                }</span>
                            </div>
                        </div>
                        <div className='about-me-div'>
                            <div className='alignment'>
                                <IoMdFlashlight style={{transform: 'rotate(90deg)', marginRight: '3px'}}/>
                                <span>À propos de moi</span>
                            </div>
                            <div className='tags-badge'>
                                {userTags.map( tag => {
                                    return (
                                        <TagsBadge
                                            key={uuidv4()}
                                            tag={tag}
                                        />)
                                    })
                                }
                            </div>
                            <p className='user-description'>
                                {info.userPersonalInfo.descriptionUser}
                            </p>
                        </div>
                        <div className='danger-buttons-div'>
                            <button onClick={() => displayConfirmWindow(blockProfile)} className='danger-buttons'>
                                <MdBlock className='mr-1' />Bloquer
                            </button>
                            <button onClick={() => displayConfirmWindow(reportProfile)} className='danger-buttons'>
                                <TiWarningOutline className='mr-1' />Signaler
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </Fragment>
    )
}

export default AccessProfile;