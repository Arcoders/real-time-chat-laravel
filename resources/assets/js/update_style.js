export const mixin = {

// ----------------------------------------------

    methods: {

        // ----------------------------------------------

        showRight() {
            if (window.innerWidth <= 1000) {
                document.querySelector(".navigate").style.display = "block";
                document.querySelector(".left").style.display = "none";

                let right = document.querySelector(".right");
                right.style.width = "100%";
                right.style.display = "block";
            }
        },

        // ---------------------------------------------------

        updateStyles() {
            this.Styles('none', 'none', 'block', '100%')
        },

        // ---------------------------------------------------

        resetStyle() {
            window.addEventListener('resize', () => {
                if (window.innerWidth > 1000) this.Styles('', '', '', '')
            });
        },

        // ---------------------------------------------------

        Styles(displayNavigate, displayRight, displayLeft, widthLeft) {
            document.querySelector(".navigate").style.display = displayNavigate;
            document.querySelector(".right").style.display = displayRight;

            let left = document.querySelector(".left");
            left.style.display = displayLeft;
            left.style.width = widthLeft;
        }

        // ---------------------------------------------------


    },


};