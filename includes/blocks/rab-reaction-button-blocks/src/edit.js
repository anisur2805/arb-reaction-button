import { __ } from '@wordpress/i18n';
import './editor.scss';

const { get_current_user_id, get_the_ID } = wp.data.select( 'core/editor' );
const { Button } = wp.components;
const { useState } = wp.element;
import sadImgUrl from '../images/sad.png';
import smileImgUrl from '../images/smile.png';
import straightImgUrl from '../images/straight.png';

export default function edit() {

	const [ likes, setLikes ] = useState( 0 );
	const [ reaction, setReaction ] = useState( null );
	// const [ user, setUser ] = useState( get_current_user_id() );
	// const [ post, setPost ] = useState( get_the_ID() );

	const onReactionClick = ( reaction ) => {
		setReaction( reaction );
		fetch( '/wp-json/rab/rab-reaction-button-blocks', {
			method: 'POST',
			headers: {
				'Content-Type': 'application/json'
			},
			body: JSON.stringify( {
				// user_id: user,
				// post_id: post,
				reaction: reaction
			} )
		} )
		.then( ( response ) => response.json() )
		.then( ( data ) => setLikes( data.likes ) );
	};

	return (
		<div className="custom-reactions-container">
			<div className="like-info">
				{ likes } Likes
			</div>

			<div className="like-wrapper">
				<Button
					isPrimary={ reaction === null }
					onClick={ () => onReactionClick( null ) }
				>
					<span className="dashicons dashicons-thumbs-up"></span> Like
				</Button>
			</div>

			<div className="like-variations">
				<Button
					isPrimary={ reaction === 'smile' }
					onClick={ () => onReactionClick( 'smile' ) }
					className="button-smile button-variation-item"
				>
					<img src={ `${smileImgUrl}` } />
				</Button>

				<Button
					isPrimary={ reaction === 'straight' }
					onClick={ () => onReactionClick( 'straight' ) }
					className="button-smile button-variation-item"
				>
					<img src={ `${straightImgUrl}` } />
				</Button>

				<Button
					isPrimary={ reaction === 'sad' }
					onClick={ () => onReactionClick( 'sad' ) }
					className="button-smile button-variation-item"
				>
					<img src={ `${sadImgUrl}` } />
				</Button>

			</div>
		</div>
	);
}
