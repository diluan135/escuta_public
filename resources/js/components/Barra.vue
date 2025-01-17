<script>
import { mapState, mapMutations } from 'vuex';
import axios from 'axios';

export default {
    computed: {
        ...mapState(['user'])
    },
    data() {
        return {
            isLoggingOut: false,
            activeView: null // Propriedade para rastrear a visualização ativa
        };
    },
    methods: {
        ...mapMutations(['setCurrentView']),
        async logout() {
            if (this.isLoggingOut) return;
            this.isLoggingOut = true;
            try {
                await axios.post('/logout');
                this.user = null;
                window.location.href = '/';
            } catch (error) {
                console.error('Logout failed', error);
            } finally {
                this.isLoggingOut = false;
            }
        },
        changeView(view) {
            this.activeView = view; // Define a visualização ativa
            this.setCurrentView(view);
        }
    },
    mounted() {
        this.activeView = 'NovaSolicitacao'; // Define uma visualização padrão ativa ao carregar
    }
};
</script>
<template>
    <div style="background-color:#3994cc; max-width: 100%;" class="container">
        <div class="row">
            <div class="col d-flex align-items-center text-center">
                <img style="height:1.5vw; margin-right: 10px; padding-left: 1vw; padding-right: 2vw;"
                    src="../../img/logo.png" alt="ESCUTA LOGO">
                <div class="vertical-divider"></div>
                <button id="botao" :class="{ active: activeView === 'NovaSolicitacao' }" class="btn btn-primary"
                    @click="changeView('NovaSolicitacao')">NOVA SOLICITAÇÃO</button>
                <div class="vertical-divider"></div>
                <button id="botao" :class="{ active: activeView === 'MinhasSolicitacoes' }" class="btn btn-primary"
                    @click="changeView('MinhasSolicitacoes')">MINHAS SOLICITAÇÕES</button>
                <div class="vertical-divider"></div>
                <button id="botao" :class="{ active: activeView === 'Perguntas' }" class="btn btn-primary"
                    @click="changeView('Perguntas')">PERGUNTAS DA COMUNIDADE E ENQUETES</button>
                <div class="vertical-divider"></div>
                <!-- Exibe o nome do usuário e botão de logout -->
                <div class="col text-end" style="margin-right: 1rem;" v-if="user">
                    <span style="margin-right:10px; color:white;">Bem vindo(a), {{ user.name }}</span>
                    <div class="vertical-divider"></div>
                    <a href="" style="margin-left:10px; color:white;" @click.prevent="logout"
                        :disabled="isLoggingOut"><i class="fa-solid fa-right-from-bracket"></i></a>
                </div>
            </div>
        </div>
    </div>
</template>
