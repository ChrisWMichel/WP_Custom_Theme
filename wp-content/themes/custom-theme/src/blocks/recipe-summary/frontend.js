import Rating from '@mui/material/Rating';
import { render, useState, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';

function RecipeRating(props){
    const [avgRating, setAvgRating] = useState(props.avgRating);
    const [permission, setPermission] = useState(props.loggedIn);

    useEffect(() => {
        if(props.ratingCount){
            setPermission(false);
        }
    }, []);


    return (
        <Rating 
        value={avgRating}
        precision={0.5}
        readOnly={!permission}
        onChange={(async (event, rating) => {
            if(!permission){
                return alert("You have already rated this recipe or you may need to login.")
            }
            setPermission(false)
            const response = await apiFetch({
                path: 'custom-plus/v1/rate',
                method: 'POST',
                data: {
                    post_id: props.postId,
                    rating: rating
                }
            })
            if(response.status == 2){
                setAvgRating(response.rating);
            }
        })}
        />
    )
}

document.addEventListener('DOMContentLoaded', () => {
    const block = document.getElementById('recipe-rating');
    if (block) {
        const postId = block.getAttribute('data-post-id');
        const avgRating = parseFloat(block.getAttribute('data-avg-rating')) || 0;
        const loggedIn = block.getAttribute('data-logged-in') === '1';
        const ratingCount = parseInt(block.getAttribute('data-rating-count')) || 0;

        // You can now use these variables to handle the rating functionality
        console.log(postId, avgRating, loggedIn, ratingCount);

        render(<RecipeRating postId={postId} loggedIn={loggedIn} avgRating={avgRating} ratingCount={ratingCount} />, block);
    }
});