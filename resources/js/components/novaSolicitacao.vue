<script>
import axios from 'axios';
import Barra from './Barra.vue';
import { mapMutations } from 'vuex';

export default {
    components: { Barra },
    data() {
        return {
            tipoSolicitacao: '',
            linhasData: [],
            linhaSelecionada: '',
            assunto: '',
            mensagem: '',
            items: ['Linha', 'Horários', 'Sugestão', 'Reclamação', 'Outros'],
            carregando: true,
            enviando: false,
        };
    },
    methods: {
        ...mapMutations(['setCurrentView']),
        clickHandler() {
<<<<<<< HEAD
            // console.log('click');
=======
>>>>>>> 70560ab (Estilização: Minhas solicitações)
            this.$router.push('/teste');
        },
        settipoSolicitacao(tipoSolicitacao) {
            this.tipoSolicitacao = tipoSolicitacao;
        },
        async fetchUser() {
            try {
                const response = await axios.get('/api/user');
                this.user = response.data;
<<<<<<< HEAD
                // console.log(this.user.id);
=======
>>>>>>> 70560ab (Estilização: Minhas solicitações)
            } catch (error) {
                console.error('Failed to fetch user', error);
            }
        },
        async fetchLinhasData() {
            try {
                const response = await axios.get('/api/linhas');
                this.linhasData = response.data.map(item => item.nome);
<<<<<<< HEAD
<<<<<<< HEAD
                // console.log(this.linhasData);
=======
                this.carregando = false;
>>>>>>> 70560ab (Estilização: Minhas solicitações)
=======
                this.carregando = false;
>>>>>>> b561b0e (Ajustando condição de loading, tela de nova solicitação.)
            } catch (error) {
                console.error('Failed to fetch Linhas data', error);
            }
        },
        setLinha(linha) {
            this.linhaSelecionada = linha;
        },
        settipoSolicitacao(tipo) {
            this.tipoSolicitacao = tipo;
        },
        enviar() {
<<<<<<< HEAD
<<<<<<< HEAD
            // console.log('usuario: ', this.user.id, 'assunto: ', this.assunto, 'mensagem: ', this.mensagem, 'linha selecionada: ', this.linhaSelecionada, 'tipo: ', this.tipo, 'tipoSolicitação: ', this.tipoSolicitacao);
=======
>>>>>>> 70560ab (Estilização: Minhas solicitações)
=======
            this.enviando = true;
>>>>>>> 7076cca (Corrigido tela de Minhas Solicitações.)
            axios.post('/api/chat/newChat',
                {
                    usuario_id: this.user.id,
                    tipo: this.tipoSolicitacao,
                    assunto: this.assunto,
                    linha: this.linhaSelecionada
                }
<<<<<<< HEAD
            )
                .then(response => {
                    // console.log(response.data);
                    // console.log(response.data.id);
                    axios.post('api/mensagem/enviarMensagem',
                        {
                            usuario_id: this.user.id,
                            chat_id: response.data.id,
                            mensagem: this.mensagem
                        }
                    ).then(response => {
                        this.setCurrentView('MinhasSolicitacoes');
                    }).catch(error => {
                        console.error(error);
                    });

                })
                .catch(error => {
=======
            ).then(response => {
                axios.post('api/mensagem/enviarMensagem',
                    {
                        usuario_id: this.user.id,
                        chat_id: response.data.id,
                        mensagem: this.mensagem
                    }
                ).then(response => {
                    this.setCurrentView('MinhasSolicitacoes');
                }).catch(error => {
>>>>>>> 70560ab (Estilização: Minhas solicitações)
                    console.error(error);
                });
            }).catch(error => {
                console.error(error);
            });
        },
        updateCharCount() { },
    },
    mounted() {
        this.fetchUser();
        this.fetchLinhasData();
    }

}
</script>

<template>
    <div>
        <h1 class="container mt-5 fs-1" style="text-shadow: none;">Faça sua solicitação!</h1>
        <div class="container d-flex flex-column mt-3"
            style="border-radius: 1rem; background: white; border: none; padding: 2rem">
            <div class="d-flex justify-start flex-column">
                <div class="mb-3 d-flex flex-row gap-3">
                    <button class="dropdown-toggle my-input white" style="width: 20vw; caret-color: transparent;"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="d-flex justify-content-between align-items-center w-100">
                            <span>{{ tipoSolicitacao ? tipoSolicitacao : 'Selecione o tipo de solicitação' }}</span>
                            <span class="dropdown-icon">
                                <i class="bi bi-caret-down"></i>
                            </span>
                        </div>
                    </button>
                    <ul class="dropdown-menu" style="width: 20vw; caret-color: transparent;">
                        <li v-for="item in items" :key="item" class="dropdown-item" @click="settipoSolicitacao(item)"
                            style="cursor: pointer; color: #646464;">{{ item }}
                        </li>
                    </ul>
                    <div v-if="tipoSolicitacao == 'Linha' || tipoSolicitacao == 'Horários'">
                        <button class="dropdown-toggle my-input white" style="width: 20vw" type="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="d-flex justify-content-between align-items-center w-100">
                                <span>{{ linhaSelecionada ? linhaSelecionada : 'Selecione a Linha' }}</span>
                                <span class="dropdown-icon">
                                    <i class="bi bi-caret-down"></i>
                                </span>
                            </div>
                        </button>
                        <ul class="dropdown-menu custom-dropdown" style="width: 20vw; cursor: pointer;">
                            <li v-if="carregando" class="dropdown-item" style="color: #646464;">
                                <i class="bi bi-arrow-repeat"></i> Carregando...
                            </li>
                            <li v-else v-for="(linha, index) in linhasData" :key="index" class="dropdown-item"
                                style="color: #646464;" @click="setLinha(linha)">
                                {{ linha }}
                            </li>
                        </ul>
                    </div>
                </div>
                <input class="mb-3 my-input white" v-model="assunto" placeholder="Assunto" type="text"
                    style="width: 41.2vw">
                <div style="position: relative; width: 100%;">
                    <textarea class="mb-3 my-input white" style="height: 15vh; resize: none;" v-model="mensagem"
                        maxlength="255" placeholder="Descreva sua solicitação..."></textarea>
                    <div :style="{ color: mensagem.length === 255 ? 'red' : '#646464' }"
                        style="position: absolute; bottom: 25px; right: 15px; font-size: 0.9rem;">
                        {{ mensagem.length }}/255
                    </div>
                </div>
                <button class="botao azul" style="background: #3994cc;" @click="enviar()">{{ enviando ? 'Enviando solicitação...' : 'Enviar solicitação' }}</button>
            </div>
        </div>
    </div>
</template>