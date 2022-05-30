import React, { useState, useEffect } from 'react';
import { v4 as uuidv4 } from 'uuid';
import { FaChevronRight } from "react-icons/fa";
import { IoChatbubblesSharp } from "react-icons/io5";
import { MdSend } from "react-icons/md";
import { BsThreeDots } from "react-icons/bs";
import { IoMdHeart } from "react-icons/io";
import Dropdown from 'react-bootstrap/Dropdown'
import { RiDeleteBin5Line } from "react-icons/ri";
import MsgIn from './MsgIn';
import MsgOut from './MsgOut';
import axios from 'axios';






const Chat = (props) => {


    // CHAT MESSAGES ↓↓↓
    const [chatMessages, setChatMessages] = useState([])
    
    useEffect( () => {

        axios.get(`/messages/data/${props.profileId}`)
        .then( (response) => {
            if (response.status === 200)
            {
                setChatMessages(response.data);
            }
        })
        .catch( () => {})

        // SCROLL IN BOTTOM
        const scrollChat = document.querySelector('.discussion');
        scrollChat.scrollTop = scrollChat.scrollHeight;

    }, [props.profileId])


    // CHAT DRAWER ↓↓↓
    const [chatDrawer, setChatDrawer] = useState(false)

    const moveChatDrawer = e => {
        e.preventDefault();
        
        let chatElement = document.querySelector('.chat');
        
        chatElement.classList.contains('chatOpen') ?
        chatElement.classList.remove('chatOpen') :
        chatElement.classList.add('chatOpen');
        
        setChatDrawer(!chatDrawer)
        props.onChatChange(!chatDrawer)
    }

    const theChatDrawer = chatDrawer ?
                          <FaChevronRight className='iconChatDrawer' /> :
                          <IoChatbubblesSharp className='iconChatDrawer' /> ;

    const chatContent = chatDrawer ?
                        'chat-content-open' :
                        'chat-content-close' ;
    

    // WRITTEN MESSAGE ↓↓↓
    const [theMessage, setTheMessage] = useState('')

    const newMessage = (e) => {
        setTheMessage(e.target.value)
    }
    
    
    // SEND MESSAGE ↓↓↓
    const handleAddNewMsg = (e) => {
        e.preventDefault();
        e.stopPropagation();

        if (theMessage !== '') {
            axios.post(`/messages/add/${props.profileId}`, {message: theMessage})
            .then( (response) => {
                if (response.status === 200)
                {
                    console.log(response.data);
                    setChatMessages(prevState => [...prevState, {
                        id: uuidv4(),
                        triggerID: props.userId,
                        messageText: theMessage
                    }]);
                    setTheMessage('');
                }
            })
            .catch( () => {})
        }
    }
    

    // SEND MSG WITH ENTER KEY ↓↓↓
    const handleKeyDown = (e) => {
        if (e.key === 'Enter' && !e.shiftKey) {
            handleAddNewMsg(e);
        }
    }


    // SEND BUTTON STYLE ↓↓↓
    const sendCursor = theMessage === '' ? 'initial' : 'pointer' ;
    const sendColor = theMessage === '' ? '#8FA3AD' : '#007bff' ;
    
    
    // DELETE DISCUSSION ↓↓↓
    const onConfirmDeleteDiscussion = () => {
        axios.delete(`/messages/delete/${props.profileId}`, { data: props.profileId })
        .then( (response) => {
            if (response.status === 200)
            {
                setChatMessages([]);
                props.onDeleteDiscussionConfirmation();
            }
        })
        .catch( () => {})
    }

    const deleteDiscussion = {
        act: "Supprimer la discussion",
        quest: "supprimer le contenu de la discussion",
        onConfirm: onConfirmDeleteDiscussion
    }

    const handleDeleteDiscussion = () => {
        chatMessages.length !== 0 &&
        props.onDeleteDiscussion(deleteDiscussion);
        
    }

    const emptyChat = chatMessages.length === 0 ?
                      <div className='empty-chat'>La discussion est vide.</div> :
                      null;

    
    return (
        <div className='chat'>
            <div className='iconChatDrawerDiv centerElementsInPage' onClick={moveChatDrawer}>
                <span className='nb-notif-chat-drawer'>3</span>
                {theChatDrawer}
            </div>
            <div className={chatContent}>
                <div className='discussionContainer'>
                    <div className='interlocutor'>
                        <div className='interlocutor-left-part'>
                            <div className='interlocutor-image-div'>
                                {props.thumbnail && <img src={props.thumbnail} alt='interlocutor' className='interlocutor-image'/>}
                            </div>
                            {props.username && <span className='interlocutor-name'>{props.username}</span>}
                        </div>
                        <div className='interlocutor-right-part'>
                            <IoMdHeart size='23' color='#010103' className='m-1' />
                            <Dropdown className='m-1'>
                                <Dropdown.Toggle className='toogle-delete-discussion'>
                                    <BsThreeDots size='27' color='#010103' className='dlt-disc-icon' />
                                </Dropdown.Toggle>
                                <Dropdown.Menu>
                                    <Dropdown.Item className='item-delete-discussion' onClick={handleDeleteDiscussion}>
                                        <RiDeleteBin5Line className='icons-dropdown' />
                                        Suppr. discussion
                                    </Dropdown.Item>
                                </Dropdown.Menu>
                            </Dropdown>
                        </div>
                    </div>
                    <div className='discussion'>
                        {chatMessages.map( msg => {
                            if (msg.triggerID === props.userId){
                                return <MsgIn key={msg.id} msgContent={msg.messageText} />
                            }
                            else {
                                return <MsgOut key={msg.id} msgContent={msg.messageText} />
                            }
                        })}
                        {emptyChat}
                    </div>
                </div>
                <form className='text-to-send' onSubmit={handleAddNewMsg}>
                    <textarea
                        value={theMessage}
                        onChange={newMessage}
                        onKeyDown={handleKeyDown}
                        className='chat-textarea'
                        autoComplete='off'
                        placeholder='Taper un message'
                        minLength='1'
                        maxLength='255'
                        autoCapitalize='on'
                    />
                    <button type='submit'className='send-button' style={{cursor: `${sendCursor}` }} >
                        <MdSend className='send-icon' color={sendColor} />
                    </button>
                </form>
            </div>
        </div>
    )
}

export default Chat;