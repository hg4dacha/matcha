import React, { Fragment, useEffect, useState } from 'react';
import { v4 as uuidv4 } from 'uuid';
import ConfirmWindow from '../ConfirmWindow/ConfirmWindow';
import Chat from './Chat';
import Carousel from './Carousel';
import TagsBadge from './TagsBadge';
import Button from 'react-bootstrap/Button'
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

import jeanma1 from '../../images/jeanma1.jpg'
import jeanma2 from '../../images/jeanma2.jpg'
import jeanma3 from '../../images/jeanma3.jpg'
import selfie from '../../images/selfie.jpg'
import selfie22 from '../../images/selfie22.jpg'


const tags = [
    'gourmand',
    'curieux',
    'intello',
    'codeur',
    'dormeur'
]


const AccessProfile = (props) => {

    const UserPhotos = [selfie22, selfie, jeanma1, jeanma2, jeanma3]



    // LIKE DISLIKE ↓↓↓
    const [like, setLike] = useState(false)

    const toLike = () => {
        setLike(true)
        props.onLike()
    }

    const toDislike = () => {
        setLike(false)
        props.onDislike()
    }

    const heart = like ?
                  <Button variant="offline-danger" onClick={ () => toDislike() } className='button-like act'>
                      <IoMdHeart className='like-heart' color='darkred' />
                  </Button> :
                  <Button variant="offline-danger" onClick={ () => toLike() } className='button-like dis'>
                      <IoMdHeartEmpty className='like-heart' color='rgb(1, 1, 3)' />
                  </Button> ;



    // INLINE OFFLINE ↓↓↓
    const [inline, setInline] = useState(false)

    // const inlineOffline = () => {
    //     setInline(!inline)
    // }


    const connectionState = inline ?
                            <small className='user-connection-status'><GoPrimitiveDot color='#009432' />En ligne</small> :
                            <small className='user-connection-status'><GoPrimitiveDot color='#7f8c8d' />
                                Hors ligne<span className='last-connection'>&nbsp;&nbsp;Dernière connexion le 25/02/22 à 13h46</span>
                            </small> ;



    // FOR PICTURE SIZE ↓↓↓
    const [pictureSize, setPictureSize] = useState(null)

    useEffect( () => {

        setPictureSize(document.querySelector('.profile-description').offsetHeight)

        window.onresize = () => {
            setPictureSize(document.querySelector('.profile-description').offsetHeight)
        }

        return () => {
            window.onresize = () => null
        }

    }, [])



    // BLUR WHEN OPENING CHAT ↓↓↓
    const [chatState, setChatState] = useState(false)

    const blurFunc = (chatState) => {
        
        setChatState(chatState)

        document.querySelector('.profile-description').classList.contains('profile-blurring') ?
        document.querySelector('.profile-description').classList.remove('profile-blurring') :
        document.querySelector('.profile-description').classList.add('profile-blurring') ;
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
            <Chat
                onChatChange={blurFunc}
                onDeleteDiscussion={displayConfirmWindow}
                onDeleteDiscussionConfirmation={props.onDeleteDiscussionConfirmation}
            />
            <div className='profile-description'>
                <div className='photos-part'>
                    <div className='photos-list'>
                        <Carousel UserPhotos={UserPhotos} forPictureSize={pictureSize} />
                    </div>
                </div>
                <div className='infos-part'>
                    <div className='infos-list'>
                        <div className='username-global-div'>
                            <div className='username-and-popularity'>
                                <h1 className='username-member-profile'>username-269428</h1>
                                <span className='popularity popularity-member-profile'><AiFillStar className='star'/>1425°</span>
                                <HiBadgeCheck className='was-liked' />
                            </div>
                            {connectionState}
                            <div className='button-like-div'>
                                {heart}
                            </div>
                        </div>
                        <div>
                            <div className='alignment'>
                                <RiUser3Line className='user-infos-icons'/>Michel Dupont
                            </div>
                            <div className='alignment'>
                                <FiCalendar className='user-infos-icons'/>36 ans
                            </div>
                            <div className='alignment'>
                                <GiPositionMarker className='user-infos-icons'/>Paris, Ile-de-France (France)
                            </div>
                            <div className='alignment'>
                                <IoMaleFemaleSharp className='user-infos-icons'/>Je suis
                                <span className='bold' style={{color: '#40739e'}}>&nbsp;un homme</span>
                            </div>
                            <div className='alignment'>
                                <BiSearch className='user-infos-icons'/>Je cherche
                                <span className='bold' style={{color: '#58B19F'}}>&nbsp;une femme</span>
                            </div>
                        </div>
                        <div className='about-me-div'>
                            <div className='alignment'>
                                <IoMdFlashlight style={{transform: 'rotate(90deg)', marginRight: '3px'}}/>
                                <span>À propos de moi</span>
                            </div>
                            <div className='tags-badge'>
                                {tags.map( tag => {
                                    return (
                                        <TagsBadge
                                            key={uuidv4()}
                                            tag={tag}
                                        />)
                                    })
                                }
                            </div>
                            <p className='user-description'>
                                Je ne suis à la recherche, ni d'une relation éphémère, ni d'amies, ni d'échanges pour combler une solitude. Ma vie est saine, équilibrée, et je souhaite simplement vous rencontrer pour une relation durable, sereine, apaisante, et harmonieuse. Dans laquelle chacun apportera sa joie de vivre, sa « vraie valeur ajoutée » ! Saurai-je être l'épice de votre vie ? Celle qui donnera de la saveur à votre quotidien, fera briller vos yeux, et adoucira vos vieux jours ? Bon, j'arrête là  mon délire aromatique, faute de quoi, je vais passer pour un poète illuminé, bercé par les vapeurs d'absinthe !
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