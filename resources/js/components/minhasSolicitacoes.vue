<script>
import { mapState, mapActions } from 'vuex';
import axios from 'axios';
import Echo from "laravel-echo";
import Pusher from "pusher-js";

// Configuração do Pusher e Echo
window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY, // Use import.meta.env para acessar variáveis de ambiente no Vite
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER, // O cluster
    wsHost: import.meta.env.VITE_PUSHER_HOST || '127.0.0.1',
    wsPort: import.meta.env.VITE_PUSHER_PORT || 6001,
    forceTLS: import.meta.env.VITE_PUSHER_SCHEME === 'https',
    disableStats: true,
    enabledTransports: ['ws'], // Use WebSocket
});

export default {
    data() {
        return {
            mensagens: [],
            novaMensagem: '',
            chatSelecionado: null,
            loading: false,
<<<<<<< HEAD
<<<<<<< HEAD
<<<<<<< HEAD
=======
            abriuChat: false,
>>>>>>> 70560ab (Estilização: Minhas solicitações)
=======
>>>>>>> cd33b5a (Corrigindo tela de Minhas Solicitacoes)
=======
>>>>>>> 0cedd0c (implementação da merda do websocket)
        };
    },
    computed: {
        ...mapState(['chats', 'user']),
    },
    methods: {
        ...mapActions(['fetchChats']),
<<<<<<< HEAD
<<<<<<< HEAD
        async getMessage(chat_id) {
            try {
                const response = await axios.get('/api/mensagem', {
                    params: { chat_id: chat_id },
                });
                this.mensagens = response.data;
                this.chatSelecionado = chat_id;

                // Reconfigura o canal para o chat selecionado
                window.Echo.channel('chat.' + chat_id)
                    .listen('MensagemEnviada', (event) => {
                        console.log('Mensagem recebida:', event.mensagem);
                        this.mensagens.push(event.mensagem);
                    });
<<<<<<< HEAD
=======
        async abrirChat(chat) {
            this.chat = chat;
            this.abriuChat = true;
            this.mensagens = [];
=======
        async getMessage(chat_id) {
>>>>>>> cd33b5a (Corrigindo tela de Minhas Solicitacoes)
            try {
                const response = await axios.get('/api/mensagem', {
                    params: { chat_id: chat_id },
                });
                this.mensagens = response.data;
<<<<<<< HEAD
                this.chatSelecionado = chat.id;
>>>>>>> 70560ab (Estilização: Minhas solicitações)
=======
                this.chatSelecionado = chat_id;

                // Reconfigura o canal para o chat selecionado
                window.Echo.channel('chat.' + chat_id)
                    .listen('MensagemEnviada', (event) => {
                        console.log('Mensagem recebida:', event.mensagem);
                        this.mensagens.push(event.mensagem);
                    });
>>>>>>> cd33b5a (Corrigindo tela de Minhas Solicitacoes)
=======
>>>>>>> 0cedd0c (implementação da merda do websocket)
            } catch (error) {
                console.error('Erro ao buscar mensagens:', error);
            }
        },
        async mandarMensagem() {
            if (!this.chatSelecionado) {
                console.error('Nenhum chat selecionado.');
                return;
            }

            this.loading = true;

            try {
                const response = await axios.post('/api/mensagem/enviarMensagem', {
                    usuario_id: this.user.id,
                    chat_id: this.chatSelecionado,
                    mensagem: this.novaMensagem,
                });
                console.log('Mensagem enviada:', response.data);
                this.novaMensagem = '';
                await this.getMessage(this.chatSelecionado);
            } catch (error) {
                console.error('Erro ao enviar mensagem:', error);
            } finally {
                this.loading = false;
            }
        }
    },
    mounted() {
<<<<<<< HEAD
        this.fetchChats();
        window.Echo.channel('chat.' + this.chatSelecionado)
            .listen('MensagemEnviada', (event) => {
                console.log('Nova mensagem recebida:', event.mensagem);
                this.mensagens.push(event.mensagem);
            });

        window.Echo.channel('test-channel')
            .listen('TestEvent', (event) => {
                console.log('Evento de teste recebido:', event);
            });

        // Emitir um evento de teste para verificar a recepção
        axios.post('/api/test-event', {
            message: 'Hello World!'
        }).then(response => {
            console.log('Evento de teste enviado:', response.data);
        }).catch(error => {
            console.error('Erro ao enviar evento de teste:', error);
        });
<<<<<<< HEAD
<<<<<<< HEAD

        // Listener para o evento TesteDeConexao
        window.Echo.channel('public')
            .listen('TesteDeConexao', (event) => {
                console.log('Mensagem recebida:', event.mensagem);
            });
    }
=======
    },
>>>>>>> 70560ab (Estilização: Minhas solicitações)
=======
    }
>>>>>>> cd33b5a (Corrigindo tela de Minhas Solicitacoes)
=======
    }
>>>>>>> 0cedd0c (implementação da merda do websocket)
};

</script>

<template>
    <div class="row">
        <!-- Lista de Conversas -->
        <div class="col-4 p-4 border-end" style="height: calc(100vh - 7rem);">
            <h1 class="mb-4" style="margin-left: 1rem;">Conversas</h1>
            <div style="height: 100%; overflow-y: auto;">
                <div v-for="chat in chats" :key="chat.id" class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ chat.assunto }}</h5>
                        <p class="card-text">
                            <strong>Criado em:</strong> {{ chat.criado_em }}
                        </p>
                        <p v-if="chat.linha !== null" class="card-text">
                            <strong>Linha:</strong> {{ chat.linha }}
                        </p>
                        <p class="card-text">
                            <strong>Status:</strong> {{ chat.chat_status }}
                        </p>
                        <button @click="getMessage(chat.id)" class="btn btn-primary btn-sm">Acessar chat</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mensagens do Chat -->
        <div v-if="mensagens.length" class="col-8 d-flex flex-column p-3" style="height: calc(100vh - 3rem); width: 60vw;">
            <div class="border-bottom pb-3 mb-3">
                <h3>Chat ativo</h3>
            </div>

            <div class="chat-messages flex-grow-1 overflow-auto mb-3">
                <div v-for="mensagem in mensagens" :key="mensagem.id" class="mb-2">
                    <div class="alert alert-secondary">
                        <span>{{ mensagem.mensagem }}</span>
                        <div class="text-muted small">Chat ID: {{ mensagem.chat_id }}</div>
                    </div>
                </div>
            </div>

            <!-- Input para nova mensagem -->
            <div class="d-flex flex-row" style="width: 80%;">
                <input class="form-control col-9 me-2" type="text" v-model="novaMensagem"
                    placeholder="Digite sua mensagem">
                <button @click="mandarMensagem()" class="btn btn-success col" :disabled="loading">
                    Enviar mensagem
                </button>
            </div>
        </div>

        <!-- Placeholder quando nenhum chat está selecionado -->
        <div v-else class="col-8 d-flex align-items-center justify-content-center h-100">
            <h1>Acesse um chat para visualizá-lo.</h1>
        </div>
    </div>
</template>
