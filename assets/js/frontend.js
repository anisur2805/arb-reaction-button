;(function ($) {
    $(document).ready(function() {
        const buttons    = document.querySelectorAll(".like-variations button");
        const likeButton = document.querySelector(".like-wrapper button");

        if (typeof buttons !== "undefined" && buttons !== null) {
            buttons.forEach(button => {
                button.addEventListener("click", function(e) {
                    e.preventDefault();
                    
                    var self = $(this),
                        id = self.data('react-id'),
                        user_id = document.querySelector('input[name="arb_user_id"]').value,
                        post_id = document.querySelector('input[name="arb_post_id"]').value;

                        var data = {
                            id: id,
                            action:     "like_action",
                            _wpnonce:   arbObj._wpnonce,
                            user_id: user_id,
                            post_id: post_id
                        };
                    
                        $.post( arbObj.ajaxUrl, data, function ( response ) {
                            if (response.success) {
                                console.log( 'res', response )
                            } else {
                                alert( response.data.error );
                                console.log( 'error' )
                            }
                        })

                })
                
            });
        }

        if (typeof likeButton !== "undefined" && likeButton !== null) {
            likeButton.addEventListener("click", function(e) {
                e.preventDefault();
                
                var self = $(this),
                    id = self.data('react-id'),
                    user_id = document.querySelector('input[name="arb_user_id"]').value,
                    post_id = document.querySelector('input[name="arb_post_id"]').value;

                    var data = {
                        id: id,
                        action:     "main_like_action",
                        _wpnonce:   arbObj._wpnonce,
                        user_id: user_id,
                        post_id: post_id
                    };
                
                    $.post( arbObj.ajaxUrl, data, function ( response ) {
                        if (response.success) {
                            console.log( 'res', response )
                        } else {
                            alert( response.data.error );
                            console.log( 'error' )
                        }
                    })

            })
        }

    })
})(jQuery);