import React from 'react';
import Badge from 'react-bootstrap/Badge'
import { FaSlackHash } from "react-icons/fa";





const TagsBadge = (props) => {


    return (
        <Badge className='tags-badge-style'>
            <FaSlackHash/>
            {props.tag}
        </Badge>
    )
}

export default TagsBadge;