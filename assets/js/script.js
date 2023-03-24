const buttons = document.querySelectorAll('.arb-reaction-button');

buttons.forEach(function(button) {
    const postId = button.dataset.postId;
    const userId = button.dataset.userId;

    const likeBtn = button.querySelector('.like-btn');
    const variations = button.querySelector('.like-variations');

    likeBtn.addEventListener('click', function() {
        variations.classList.toggle('active');
    });

    const variationBtns = variations.querySelectorAll('.button-variation-item');

    variationBtns.forEach(function(variationBtn) {
        variationBtn.addEventListener('click', function() {
            const reactId = this.dataset.reactId;

            fetch(arbData.ajaxUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'action=arb_add_reaction&react_id=' + reactId + '&post_id=' + postId + '&user_id=' + userId
            })
            .then(response => response.json())
            .then(data => {
                variations.classList.remove('active');
                const likeInfo = button.querySelector('.like-info');
                likeInfo.innerHTML = data.likes;
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
