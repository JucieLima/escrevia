<script setup>
import {ref, nextTick, watch} from 'vue';
import axios from 'axios';
import {Head} from '@inertiajs/vue3'; // Importe Head se estiver usando

const messages = ref([
    {type: 'milena', text: 'Olá! Eu sou a Milena, sua assistente de redação. Como posso te ajudar hoje?'},
]);
const newMessage = ref('');

const chatContainer = ref(null);

const sendMessage = async () => { // Função assíncrona para lidar com a API
    if (!newMessage.value.trim()) {
        return; // Não envia mensagens vazias
    }

    const userMessageText = newMessage.value;
    messages.value.push({type: 'user', text: userMessageText});
    newMessage.value = ''; // Limpa o input imediatamente

    // Role para o final do chat após a mensagem do usuário
    await nextTick();
    if (chatContainer.value) {
        chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
    }

    try {
        const response = await axios.post(route('milena.send'), {
            message: userMessageText,
            // Para gerenciar histórico, você passaria algo como:
            // history: messages.value.map(msg => ({
            //     role: msg.type === 'user' ? 'user' : 'assistant',
            //     content: msg.text
            // })),
        });

        messages.value.push({type: 'milena', text: response.data.ai_response});

    } catch (error) {
        console.error('Erro ao enviar mensagem para a Milena:', error);
        messages.value.push({
            type: 'milena',
            text: 'Ops! Tive um problema ao processar sua mensagem. Poderia tentar novamente?'
        });
    } finally {
        // Role para o final do chat após a resposta da IA também
        await nextTick();
        if (chatContainer.value) {
            chatContainer.value.scrollTop = chatContainer.value.scrollHeight;
        }
    }
};

const props = defineProps({
    isVisible: {
        type: Boolean,
        default: false,
    },
});

const emit = defineEmits(['close']);

const closeChat = () => {
    emit('close');
};

// REMOVA QUALQUER LINHA COMO ESTA ABAIXO SE AINDA EXISTIR NO SEU Chat.vue:
// const response = await axios.post(route('milena.send'), { ... }); // <<--- REMOVA ISSO!
</script>

<template>
    <div v-if="props.isVisible" class="fixed inset-0 bg-black bg-opacity-60 flex justify-center items-center z-[1001]">
        <div class="transform scale-100 opacity-100 transition-all duration-300 ease-out">
            <div
                class="flex flex-col w-[350px] h-[500px] bg-escreviaWhite border border-escreviaBorder rounded-lg shadow-xl overflow-hidden relative">
                <div
                    class="flex justify-between items-center bg-escreviaPrimary text-escreviaWhite p-3 border-b border-escreviaBorder font-bold text-center">
                    <h3>Chatbot Milena</h3>
                    <button @click="closeChat"
                            class="text-escreviaWhite text-2xl px-2 py-0.5 rounded-full hover:bg-escreviaAccent-light hover:text-escreviaSecondary transition-colors duration-200">
                        &times;
                    </button>
                </div>
                <div ref="chatContainer" class="flex-grow p-4 overflow-y-auto flex flex-col bg-escreviaBgLight">
                    <div
                        v-for="(msg, index) in messages"
                        :key="index"
                        :class="[
                            'p-2 rounded-xl mb-2 max-w-[80%] break-words',
                            msg.type === 'user' ? 'self-end bg-escreviaPrimary text-escreviaWhite rounded-br-sm' : 'self-start bg-escreviaSecondary-light text-escreviaSecondary rounded-bl-sm'
                        ]"
                    >
                        {{ msg.text }}
                    </div>
                </div>
                <div class="flex p-4 border-t border-escreviaBorder bg-escreviaWhite">
                    <input
                        v-model="newMessage"
                        @keyup.enter="sendMessage"
                        placeholder="Digite sua mensagem..."
                        class="flex-grow p-2 border border-escreviaBorder rounded mr-2 text-escreviaSecondary focus:outline-none focus:border-escreviaPrimary"
                    />
                    <button @click="sendMessage"
                            class="bg-escreviaPrimary text-escreviaWhite py-2 px-4 rounded hover:ring-offset-pink-500 transition-colors duration-200">
                        Enviar
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
