<template>
    <div id="bienvenido_app">

        <div class="wrap-content">
            <div class="dynamic_content">

                <div class="welcome">
                    <img src="images/default/udemy.png" alt="udemy">
                    <p>Real-time chat app</p>
                </div>

            </div>
        </div>

    </div>
</template>

<style scoped>
    #bienvenido_app {
        background-color: #f7f9fa;
        border-radius: 2px;
        height: calc(98vh - 25px);
    }
    .dynamic_content {
        padding: 10px;
        background-color: #f7f9fa;
        height: calc(98vh - 50px);
        border-bottom: 5px solid #25D366;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .welcome {
        display: flex;
    }
    .welcome p {
        color: #777777;
    }

</style>

<script>
    export default {
        mounted() {
            console.log('Bienvenido ok!');
        }
    }
</script>
