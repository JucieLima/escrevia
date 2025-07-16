<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import {onMounted, onUnmounted, ref} from 'vue'; // Importar ref e onMounted para o CKEditor

// Definindo as props que este componente espera receber do controlador Laravel
const props = defineProps({
    essay: Object, // Pode ser null para nova redação, ou um objeto para rascunho
    errors: Object, // Erros de validação
    flash: {
        type: Object,
        default: () => ({ success: null, error: null }),
    },
});

const submitForm = (actionType) => {
    if (!editor) return;

    form.content = editor.getData();
    form.action = actionType;

    clearInterval(autoSaveInterval);

    const method = form.essay_id ? 'put' : 'post';
    const routeName = form.essay_id ? 'essay.update' : 'essay.store';
    const routeParams = form.essay_id ? form.essay_id : undefined;

    console.log('--- Debug de Submissão (Final) ---');
    console.log('form.essay_id:', form.essay_id);
    console.log('Calculated Method:', method);
    console.log('Calculated RouteName:', routeName);
    console.log('Calculated RouteParams:', routeParams);
    console.log('Rota final:', route(routeName, routeParams));
    console.log('--- Fim Debug ---');

    form[method](route(routeName, routeParams), {
        // --- ADICIONE ESTA LINHA ---
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        // ---------------------------
        onSuccess: () => {
            console.log('Formulário submetido com sucesso!');
        },
        onError: (errors) => {
            console.error('Erro ao submeter formulário:', errors);
        },
        onFinish: () => {
            if (actionType !== 'submit') {
                autoSaveInterval = setInterval(saveDraft, 5000);
            }
        }
    });
};

// Inicializa o formulário Inertia.js
const form = useForm({
    essay_id: props.essay?.id || null, // Se tiver essay, usa o ID, senão null
    title: props.essay?.title || '',
    theme: props.essay?.theme || '',
    content: props.essay?.content || '',
    action: '', // Para "draft" ou "submit"
});

// CKEditor setup
let editor = null; // Variável para a instância do CKEditor
const editorElement = ref(null); // Ref para o textarea

let autoSaveInterval;
let lastSavedContent = form.content; // Inicializa com o conteúdo da prop

// Lógica para fechar mensagens de flash (já que você tem no History.vue)
const closeFlash = (type) => {
    props.flash[type] = null;
};

// Função para obter ou criar o input hidden para o essay_id
// Não é estritamente necessário com useForm, mas mantemos a lógica similar
const getOrCreateEssayIdInput = () => {
    if (!form.essay_id) { // Se não tem ID ainda, simula a criação
        // Na verdade, useForm já está cuidando disso para nós.
        // Apenas precisamos garantir que form.essay_id seja atualizado no backend.
    }
    return { value: form.essay_id }; // Retorna um objeto para manter a compatibilidade com a função original
};


// Função para salvar rascunho (auto-save)
const saveDraft = () => {
    if (!editor) { // Garante que o editor foi inicializado
        return;
    }

    const currentContent = editor.getData();
    const title = form.title;
    const theme = form.theme;

    if (!title.trim() && !theme.trim() && !currentContent.trim()) {
        console.log('Todos os campos vazios, pulando auto-save.');
        return;
    }

    // Verifica se houve mudança significativa para justificar o auto-save
    // Com useForm, o estado já é reativo, mas o CKEditor não atualiza form.content automaticamente
    if (currentContent === lastSavedContent && title === form.initialTitle && theme === form.initialTheme) {
        console.log('Conteúdo, título e tema não alterados, pulando auto-save.');
        return;
    }

    // Validação básica antes de enviar (poderia ser feito no backend também)
    if (!title.trim() || !theme.trim() || !currentContent.trim()) {
        console.warn('Campos obrigatórios (título, tema, conteúdo) ausentes para auto-salvamento. Pulando.');
        return;
    }

    form.content = currentContent; // Atualiza o conteúdo no form object
    form.action = 'draft'; // Define a ação para o auto-save

    // Aqui, em vez de `fetch`, usamos `form.post` ou `form.put` do Inertia
    // Para rascunhos, usamos 'post' para criar, e 'put' para atualizar (se o ID existe)
    const routeName = form.essay_id ? 'essay.update-draft' : 'essay.store-draft'; // Você precisará criar essas rotas

    form.post(route(routeName, form.essay_id ? form.essay_id : undefined), {
        preserveScroll: true,
        onSuccess: (page) => {
            console.log('Rascunho salvo com sucesso!');
            if (page.props.flash?.essay_id && !form.essay_id) {
                form.essay_id = page.props.flash.essay_id; // Atualiza o ID se for um novo rascunho
                console.log('ID da redação atualizado para:', form.essay_id);
                // Opcional: window.history.replaceState(null, null, route('essay.edit', form.essay_id));
            }
            lastSavedContent = currentContent; // Atualiza o último conteúdo salvo
            form.initialTitle = title; // Atualiza o estado inicial do título
            form.initialTheme = theme; // Atualiza o estado inicial do tema
        },
        onError: (errors) => {
            console.error('Erro ao salvar rascunho automaticamente:', errors);
            // Mostrar erros na UI se necessário
        }
    });
};

onMounted(async () => {
    // Carrega o CKEditor dinamicamente
    const { default: ClassicEditor } = await import('@ckeditor/ckeditor5-build-classic');

    editor = await ClassicEditor
        .create(editorElement.value, {
            toolbar: {
                items: [
                    'undo', 'redo', // Apenas desfazer e refazer
                    '|', // Separador
                    'bulletedList', 'numberedList' // Listas
                ]
            },
            placeholder: 'Escreva sua redação aqui...', // Mantém o placeholder
            // Para ajustar a altura mínima do editor
            // Você pode ajustar este valor conforme a necessidade.
            minHeight: '400px', // Altura mínima de 400 pixels
        }) // Usa o ref aqui
        .catch(error => {
            console.error(error);
        });

    // Inicializa lastSavedContent com o conteúdo atual do editor
    lastSavedContent = editor.getData();

    // Inicia o auto-save somente depois que o editor estiver pronto
    autoSaveInterval = setInterval(saveDraft, 5000); // Salva a cada 5 segundos

    // Define o estado inicial para comparação de auto-save
    form.initialTitle = form.title;
    form.initialTheme = form.theme;
});

// Limpa o intervalo ao sair da página (boa prática)
onUnmounted(() => {
    clearInterval(autoSaveInterval);
});

</script>

<template>
    <Head :title="essay ? 'Editar Redação (Rascunho)' : 'Enviar Nova Redação'"/>

    <div v-if="flash.success"
         class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4"
         role="alert">
        <strong class="font-bold">Sucesso!</strong>
        <span class="block sm:inline">{{ flash.success }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
              @click="closeFlash('success')">
            <svg class="fill-current h-6 w-6 text-green-500" role="button"
                 xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path
                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>

    <div v-if="flash.error"
         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4"
         role="alert">
        <strong class="font-bold">Erro!</strong>
        <span class="block sm:inline">{{ flash.error }}</span>
        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer"
              @click="closeFlash('error')">
            <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 20 20"><title>Close</title><path
                d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
        </span>
    </div>

    <div v-if="Object.keys(errors).length > 0"
         class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mb-4"
         role="alert">
        <strong class="font-bold">Ops!</strong>
        <span class="block sm:inline">Houve alguns problemas com sua submissão.</span>
        <ul class="mt-3 list-disc list-inside">
            <li v-for="(error, key) in errors" :key="key">{{ error }}</li>
        </ul>
    </div>


    <div class="flex flex-1 justify-center py-5 px-0">
        <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <p class="text-escreviaSecondary tracking-light text-[32px] font-bold leading-tight min-w-72 p-4">
                {{ essay ? 'Editar Redação (Rascunho)' : 'Enviar Nova Redação' }}
            </p>


            <form @submit.prevent="submitForm(form.action)" class="flex flex-col p-4 gap-4">
                <div class="flex flex-col gap-2">
                    <label for="title" class="text-[#111418] text-base font-medium leading-normal">Título da
                        Redação:</label>
                    <input type="text"
                           id="title"
                           name="title"
                           v-model="form.title"
                           class="w-full h-12 rounded-lg border border-[#dbe0e6] px-4 py-2
                                  text-[#111418] text-base font-normal leading-normal
                                  focus:outline-none focus:ring-1 focus:ring-escreviaPrimary
                                  focus:border-transparent"
                           placeholder="Ex: Os desafios da educação a distância no Brasil"
                           required>
                    <div v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="theme" class="text-[#111418] text-base font-medium leading-normal">Tema da
                        Redação:</label>
                    <input type="text"
                           id="theme"
                           name="theme"
                           v-model="form.theme"
                           class="w-full h-12 rounded-lg border border-[#dbe0e6] px-4 py-2
                                  text-[#111418] text-base font-normal leading-normal
                                  focus:outline-none focus:ring-1 focus:ring-escreviaPrimary
                                  focus:border-transparent"
                           placeholder="Ex: A importância da leitura na formação do indivíduo"
                           required>
                    <div v-if="form.errors.theme" class="text-red-500 text-sm mt-1">{{ form.errors.theme }}</div>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="editor" class="text-[#111418] text-base font-medium leading-normal">Conteúdo da
                        Redação:</label>
                    <textarea id="editor"
                              ref="editorElement"
                              name="content"
                              rows="15"
                              :value="form.content" class="w-full min-h-[300px] rounded-lg border border-[#dbe0e6] px-4 py-2
                                     text-[#111418] text-base font-normal leading-normal resize-y
                                     focus:outline-none focus:ring-1 focus:ring-escreviaPrimary
                                     focus:border-transparent"
                              placeholder="Escreva sua redação aqui..."
                    ></textarea>
                    <div v-if="form.errors.content" class="text-red-500 text-sm mt-1">{{ form.errors.content }}</div>
                </div>

                <div class="flex justify-end gap-4 mt-4">
                    <button type="button"
                            @click="submitForm('draft')"
                            :disabled="form.processing"
                            class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-md font-semibold text-base text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-200">
                        Salvar Rascunho
                    </button>

                    <button type="button"
                            @click="submitForm('submit')"
                            :disabled="form.processing"
                            class="inline-flex items-center px-6 py-3 bg-escreviaPrimary border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-escreviaPrimary focus:bg-gray-300 active:bg-escreviaAccent focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-200">
                        Enviar Redação para Análise
                    </button>
                </div>
            </form>
        </div>
    </div>
</template>
