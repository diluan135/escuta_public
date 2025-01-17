<script>
import { mapState } from 'vuex';
import axios from 'axios';

export default {
    data() {
        return {
            enquetes: [],
            opcoes: [],
            votedEnquetes: new Set(),  // Usado para rastrear quais enquetes já foram votadas
            carregandoEnquetes: false,
        }
    },
    computed: {
        ...mapState(['user', 'FAQ']),
    },
    methods: {
        async getEnquete() {
            this.carregandoEnquetes = true;
            try {
                const response = await axios.get('/api/enquetes');
                this.enquetes = response.data.enquetes;
                this.opcoes = response.data.opcoes;
                this.votedEnquetes = new Set(response.data.votedEnquetes || []); // Ajuste para incluir enquetes já votadas
                this.carregandoEnquetes = false;
            } catch (error) {
                console.error(error);
                this.carregandoEnquetes = false;
            }
            console.log(this.enquetes, this.opcoes);
        },
        async vote(opcao_id, enquete_id) {
            console.log(opcao_id, enquete_id, this.user);
            try {
                const response = await axios.post('/api/votar', {
                    opcao_id: opcao_id,
                    enquetes_id: enquete_id,
                    usuario_id: this.user.id
                });
                console.log(response);
                // Atualizar o estado para refletir que a enquete foi votada
                this.votedEnquetes.add(enquete_id);
            } catch (error) {
                console.error(error);
            }
        },
        async changeVote(enquete_id) {
            try {
                const response = await axios.post('/api/resetVote', {
                    enquetes_id: enquete_id,
                    usuario_id: this.user.id
                });
                console.log(response);
                // Atualizar o estado para refletir que a enquete foi resetada
                this.votedEnquetes.delete(enquete_id);
                await this.getEnquete(); // Recarregar enquetes para refletir mudanças
            } catch (error) {
                console.error(error);
            }
        }
    },
    async created() {
        // Carregar as enquetes ao criar o componente
        await this.getEnquete();

        // Chamar a ação Vuex para buscar os FAQs
        await this.$store.dispatch('fetch');

        // Exibir os dados dos FAQs no console
        console.log(this.FAQ);
    },
    mounted() {
        // Log adicional após montar o componente (os FAQs devem estar prontos)
        console.log('FAQ após montado:', this.FAQ);
    }
}
</script>

<template>
    <div class="container mt-5" style="height: 75vh; overflow-y: auto;">
        <!-- Loading spinner enquanto as enquetes carregam -->
        <div v-if="carregandoEnquetes" class="d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Carregando enquetes...</span>
            </div>
        </div>

        <!-- Lista de enquetes -->
         <h2>Enquetes</h2>
        <div v-for="enquete in enquetes" :key="enquete.id" class="mb-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <!-- Título e Descrição da enquete -->
                    <h5 class="card-title">{{ enquete.titulo }}</h5>
                    <p class="card-text">{{ enquete.descricao }}</p>

                    <!-- Opções de voto -->
                    <div v-if="!votedEnquetes.has(enquete.id)">
                        <div class="row g-2 justify-content-center">
                            <div v-for="opcao in opcoes.filter(o => o.enquete_id === enquete.id)" :key="opcao.id"
                                class="col-6 col-md-4 d-flex justify-content-center">
                                <button @click="vote(opcao.id, enquete.id)" class="btn w-100 text-white p-3"
                                    :style="{ backgroundColor: opcao.cor || '#3994cc' }">
                                    {{ opcao.opcao }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Opção para mudar o voto -->
                    <div v-else>
                        <button @click="changeVote(enquete.id)" class="btn btn-warning mt-3">
                            Mudar voto
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div>
            <h2>Perguntas frequentes</h2>
            <hr>
            <div v-for="faq in FAQ" :key="faq.chat.id" class="faq-item mb-4">
                <!-- Exibe o assunto do chat -->
                <h5>Assunto do chat: {{ faq.chat.assunto }}</h5>

                <!-- Exibe as mensagens -->
                <div v-for="mensagem in faq.mensagens" :key="mensagem.id" class="mensagem-item">
                    <!-- Verifica se admin_id é diferente de null ou 0 -->
                    <span v-if="mensagem.admin_id != null && mensagem.admin_id != 0">
                        Admin: 
                    </span>
                    <!-- Exibe a mensagem -->
                    <span>{{ mensagem.mensagem }}</span>
                </div>
                <hr>
            </div>
        </div>

    </div>
</template>