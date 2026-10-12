<!-- la zone vide où Vue va afficher son contenu -->
<div id="app">{{ message }}</div>

<!-- charge Vue sur la page depuis internet -->
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>

<!-- début de mon code JavaScript -->
<script>
    // je sors l'outil createApp de la caisse Vue
    const {createApp} = Vue ;
    // je démarre Vue et je lui décris mon application
    createApp ({
        data () {
            return {
                message: 'Hello'
            }
        }

    })
    .mount('#app')
</script>