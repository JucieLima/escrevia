<script setup>
import { ref, onMounted, nextTick } from 'vue';
import { useForm } from '@inertiajs/vue3'; // Importar useForm do Inertia

const messages = ref([]); // Para armazenar as mensagens do chat
const currentMessage = ref(''); // Campo de entrada do usuário
const sessionId = ref(null); // Para manter o ID da sessão da Milena
const options = ref([]); // Para armazenar botões de opções da Milena
const isLoading = ref(false); // Para mostrar "Milena está digitando..."

// Usar useForm do Inertia para enviar mensagens POST
// Inertia lida automaticamente com CSRF para POST, PUT, PATCH, DELETE
const form = useForm({
    message: '',
    session_id: null,
});

// Função para rolar o chat para o final
const scrollToBottom = () => {
    nextTick(() => {
        const chatBox = document.getElementById('chat-messages');
        if (chatBox) {
            chatBox.scrollTop = chatBox.scrollHeight;
        }
    });
};

// Adiciona uma mensagem ao array de mensagens e rola para o final
const addMessage = (text, sender) => {
    messages.value.push({ text, sender });
    scrollToBottom();
};

// Inicia a conversa com a Milena ao carregar o componente
onMounted(async () => {
    // Tenta carregar session_id do localStorage, caso a página tenha sido recarregada
    const storedSessionId = localStorage.getItem('milenaSessionId');
    if (storedSessionId) {
        sessionId.value = storedSessionId;
        // Opcional: Você pode querer carregar o histórico de chat aqui
        // ou ter uma lógica no backend para "continuar" a sessão
    }

    // Inicia a conversa com a Milena
    await startMilenaChat();
});

async function startMilenaChat() {
    isLoading.value = true;
    try {
        // Para chamadas GET, Inertia.js pode usar router.get ou fetch/axios diretamente.
        // Se a rota for `Route::get('/milena/start-chat')` e você não estiver
        // fazendo uma navegação de página completa, Fetch API ou Axios é mais direto.
        const response = await fetch('/milena/start-chat', {
            method: 'GET',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                // Inertia.js geralmente lida com CSRF automaticamente para XHRs.
                // Mas se precisar, o token CSRF pode ser acessado via usePage().props.csrf_token
                // Ou o Laravel já envia o XSRF-TOKEN via cookie, que o Axios/Fetch usa.
            },
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

        const data = await response.json();
        addMessage(data.message, 'milena');
        if (data.options) {
            options.value = data.options;
        }
        if (data.session_id) {
            sessionId.value = data.session_id;
            localStorage.setItem('milenaSessionId', data.session_id);
        }
    } catch (error) {
        console.error("Erro ao iniciar chat com Milena:", error);
        addMessage("Desculpe, não consegui iniciar a conversa com a Milena. Por favor, tente novamente mais tarde.", 'system');
    } finally {
        isLoading.value = false;
    }
}

// Envia a mensagem do usuário para a Milena
const submitMessage = async () => {
    if (!currentMessage.value.trim()) return;

    const userMessage = currentMessage.value;
    addMessage(userMessage, 'user'); // Exibe a mensagem do usuário imediatamente
    currentMessage.value = ''; // Limpa o campo de entrada
    options.value = []; // Limpa as opções anteriores

    isLoading.value = true;

    form.message = userMessage;
    form.session_id = sessionId.value;

    try {
        // Inertia's useForm automaticamente envia como POST e lida com CSRF
        await form.post('/milena/message', {
            preserveScroll: true, // Mantém o scroll na página
            onSuccess: (page) => {
                const data = page.props.flash.milenaResponse || page.props.milenaResponse; // Adapte como você passa a resposta
                if (data) {
                    addMessage(data.message, 'milena');
                    if (data.options) {
                        options.value = data.options;
                    }
                    if (data.session_id) { // Se o session_id for atualizado ou confirmado
                        sessionId.value = data.session_id;
                        localStorage.setItem('milenaSessionId', data.session_id);
                    }
                }
            },
            onError: (errors) => {
                console.error("Erro do servidor:", errors);
                addMessage("Ops! Houve um problema ao obter a resposta da Milena. Por favor, tente novamente.", 'system');
            },
            onFinish: () => {
                isLoading.value = false;
            }
        });
    } catch (error) {
        console.error("Erro na requisição:", error);
        addMessage("Houve um erro inesperado ao conectar com a Milena. Verifique sua conexão.", 'system');
        isLoading.value = false;
    }
};

const sendOptionAsMessage = (optionText) => {
    currentMessage.value = optionText; // Preenche o input com a opção
    submitMessage(); // Envia como se o usuário tivesse digitado
};
</script>

<template>
    <div class="chat-container">
        <div id="chat-messages" class="chat-messages">
            <div v-for="(msg, index) in messages" :key="index" :class="['message', msg.sender]">
                <div class="sender-name" v-if="msg.sender === 'milena'">Milena</div>
                <div class="sender-name" v-else-if="msg.sender === 'user'">Você</div>
                <div class="sender-name" v-else>Sistema</div>
                <div v-html="msg.text"></div> </div>
            <div v-if="isLoading" class="message milena typing-indicator">
                <div class="sender-name">Milena</div>
                Milena está digitando...
            </div>
        </div>

        <div class="chat-input-area">
            <div v-if="options.length" class="options-container">
                <button v-for="(option, index) in options" :key="index" @click="sendOptionAsMessage(option)" class="option-button">
                    {{ option }}
                </button>
            </div>
            <form @submit.prevent="submitMessage" class="message-form">
                <input
                    type="text"
                    v-model="currentMessage"
                    placeholder="Converse com a Milena..."
                    :disabled="isLoading"
                />
                <button type="submit" :disabled="isLoading">
                    Enviar
                </button>
            </form>
        </div>
    </div>
</template>

<style scoped>
/* Estilos básicos para o chat - personalize como quiser com Tailwind CSS */
.chat-container {
    display: flex;
    flex-direction: column;
    height: 100%; /* Ajuste conforme a altura do seu container pai */
    max-width: 600px; /* Largura máxima do chat */
    margin: 0 auto; /* Centraliza */
    border: 1px solid #e2e8f0; /* Tailwind border-gray-200 */
    border-radius: 0.5rem; /* Tailwind rounded-lg */
    overflow: hidden;
    background-color: #ffffff; /* Tailwind bg-white */
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Tailwind shadow-md */
}

.chat-messages {
    flex-grow: 1;
    overflow-y: auto;
    padding: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem; /* Espaçamento entre mensagens */
}

.message {
    padding: 0.75rem 1rem;
    border-radius: 0.5rem;
    max-width: 80%; /* Mensagens ocupam até 80% da largura */
    word-wrap: break-word; /* Quebra de linha para palavras longas */
}

.message.milena {
    align-self: flex-start;
    background-color: #f0f4f8; /* Tailwind bg-blue-50 */
    color: #2d3748; /* Tailwind text-gray-800 */
    border-bottom-left-radius: 0;
}

.message.user {
    align-self: flex-end;
    background-color: #6366f1; /* Tailwind bg-indigo-600 */
    color: #ffffff;
    border-bottom-right-radius: 0;
}

.message.system {
    align-self: center;
    background-color: #f7fafc; /* Tailwind bg-gray-50 */
    color: #718096; /* Tailwind text-gray-600 */
    font-style: italic;
    text-align: center;
    width: 100%;
}

.sender-name {
    font-weight: bold;
    font-size: 0.8em;
    margin-bottom: 0.25rem;
    color: #4a5568; /* Tailwind text-gray-700 */
}

.message.user .sender-name {
    color: #ffffff;
}

.typing-indicator {
    font-style: italic;
    color: #6b7280; /* Tailwind text-gray-500 */
}

.chat-input-area {
    padding: 1rem;
    border-top: 1px solid #e2e8f0;
    background-color: #f8fafc; /* Tailwind bg-gray-50 */
}

.message-form {
    display: flex;
    gap: 0.5rem;
}

.message-form input {
    flex-grow: 1;
    padding: 0.75rem;
    border: 1px solid #cbd5e0; /* Tailwind border-gray-300 */
    border-radius: 0.375rem; /* Tailwind rounded-md */
    outline: none;
    font-size: 1rem;
}

.message-form input:focus {
    border-color: #6366f1; /* Tailwind border-indigo-500 */
    box-shadow: 0 0 0 1px #6366f1; /* Tailwind ring-indigo-500 */
}

.message-form button {
    padding: 0.75rem 1rem;
    background-color: #6366f1; /* Tailwind bg-indigo-600 */
    color: white;
    border: none;
    border-radius: 0.375rem;
    cursor: pointer;
    font-size: 1rem;
    font-weight: 600; /* Tailwind font-semibold */
    transition: background-color 0.2s;
}

.message-form button:hover:not(:disabled) {
    background-color: #4f46e5; /* Tailwind bg-indigo-700 */
}

.message-form button:disabled {
    background-color: #a78bfa; /* Tailwind bg-indigo-300 */
    cursor: not-allowed;
}

.options-container {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
    margin-bottom: 0.75rem;
    justify-content: center;
}

.option-button {
    padding: 0.5rem 1rem;
    background-color: #e0e7ff; /* Tailwind bg-indigo-100 */
    color: #4f46e5; /* Tailwind text-indigo-700 */
    border: 1px solid #818cf8; /* Tailwind border-indigo-300 */
    border-radius: 9999px; /* Tailwind rounded-full */
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    transition: background-color 0.2s, border-color 0.2s;
}

.option-button:hover {
    background-color: #c7d2fe; /* Tailwind bg-indigo-200 */
    border-color: #6366f1; /* Tailwind border-indigo-500 */
}
</style>
