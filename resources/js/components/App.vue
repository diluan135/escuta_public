<script>
import { mapState, mapMutations, mapActions } from 'vuex';
import Barra from './Barra.vue';
import MinhasSolicitacoes from './minhasSolicitacoes.vue';
import NovaSolicitacao from './novaSolicitacao.vue';
import Perguntas from './perguntas.vue';
import Logout from './Logout.vue';

export default {
    components: { Barra },
    computed: {
        ...mapState(['currentView']),
        currentViewComponent() {
            switch (this.currentView) {
                case 'MinhasSolicitacoes':
                    return MinhasSolicitacoes;
                case 'NovaSolicitacao':
                    return NovaSolicitacao;
                case 'Perguntas':
                    return Perguntas;
                case 'Logout':
                    return Logout;
                default:
                    return NovaSolicitacao;
            }
        },
    },
    mounted() {
        this.setCurrentView('NovaSolicitacao');
        this.fetchUser();
        this.fetchChats();
    },
    methods: {
        ...mapMutations(['setCurrentView']),
        ...mapActions(['fetchUser', 'fetchChats']),
    },
};
</script>

<template>
    <Barra />
    <component :is="currentViewComponent"></component>
</template>
