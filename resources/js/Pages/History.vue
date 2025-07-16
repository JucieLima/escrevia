<script setup>
import {Head, Link} from '@inertiajs/vue3'; // Link para navegar entre as rotas Inertia
import MainLayout from '@/Layouts/MainLayout.vue'; // Importe o layout principal

// Definindo as props que este componente espera receber do controlador Laravel
// 'essays' será a coleção paginada de redações
// 'flash' para mensagens de sessão (sucesso/erro)
const props = defineProps({
    essays: Object, // Laravel passará a coleção paginada de redações aqui
    flash: {
        type: Object,
        default: () => ({success: null, error: null}),
    },
});

// Lógica para fechar mensagens de flash
const closeFlash = (type) => {
    props.flash[type] = null; // Isso limpará a mensagem na UI
};

// Função para obter o texto e a classe de estilo para o status da redação
const getStatusDisplay = (status) => {
    let statusText = '';
    let statusClass = '';
    switch (status) {
        case 'draft':
            statusText = 'Rascunho';
            statusClass = 'bg-blue-100 text-blue-800';
            break;
        case 'pending_correction':
            statusText = 'Aguardando Correção';
            statusClass = 'bg-yellow-100 text-yellow-800';
            break;
        case 'corrected':
            statusText = 'Concluída';
            statusClass = 'bg-green-100 text-green-800';
            break;
        case 'cancelled':
            statusText = 'Cancelada';
            statusClass = 'bg-red-100 text-red-800';
            break;
        default:
            statusText = 'Desconhecido';
            statusClass = 'bg-gray-100 text-gray-800';
            break;
    }
    return {statusText, statusClass};
};

</script>

<template>
    <Head title="Minhas Redações"/>
    <div class="flex flex-1 justify-center py-5 px-0">
        <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
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
            <div class="flex flex-wrap justify-between gap-3 p-4">
                <p class="text-[#121416] tracking-light text-[32px] font-bold leading-tight min-w-72">Minhas
                    Redações</p>
                <Link :href="route('submit-essay')"
                      class="inline-flex items-center px-4 py-2 bg-escreviaPrimary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-escreviaAccent focus:bg-escreviaAccent active:bg-escreviaAccent focus:outline-none focus:ring-2 focus:ring-escreviaPrimary focus:ring-offset-2 transition ease-in-out duration-150">
                    Enviar Nova Redação
                </Link>
            </div>

            <div class="flex gap-3 p-3 flex-wrap pr-4">
                <button
                    class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Competência</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button
                    class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Nota</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button
                    class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Data</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button
                    class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Status</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
            </div>

            <div class="px-4 py-3 @container">
                <div class="flex overflow-hidden rounded-xl border border-[#dde1e3] bg-white">
                    <table class="flex-1">
                        <thead>
                        <tr class="bg-white">
                            <th class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                Título
                            </th>
                            <th class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                Data de Envio
                            </th>
                            <th class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 px-4 py-3 text-left text-[#121416] w-[400px] text-sm font-medium leading-normal">
                                Nota Final
                            </th>
                            <th class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 px-4 py-3 text-left text-[#121416] w-60 text-sm font-medium leading-normal">
                                Status
                            </th>
                            <th class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 px-4 py-3 text-left text-[#121416] w-60 text-[#6a7681] text-sm font-medium leading-normal">
                                Ações
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-if="essays.data.length === 0">
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                Nenhuma redação encontrada.
                            </td>
                        </tr>
                        <tr v-for="essay in essays.data" :key="essay.id" class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                {{ essay.title }}
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                {{ new Date(essay.created_at).toLocaleDateString('pt-BR') }}
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                <span v-if="essay.overall_score !== null">{{ essay.overall_score }}/100</span>
                                <span v-else>N/A</span>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 text-sm font-medium leading-normal w-full"
                                    :class="getStatusDisplay(essay.status).statusClass"
                                >
                                    <span class="truncate">{{ getStatusDisplay(essay.status).statusText }}</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <template v-if="essay.status === 'corrected'">
                                    <Link :href="route('essay.feedback', essay.id)" title="Ver feedback"
                                          class="text-escreviaPrimary hover:text-escreviaAccent">Ver Feedback
                                    </Link>
                                </template>
                                <template v-else-if="essay.status === 'draft'">
                                    <Link :href="route('essay.edit', essay.id)" title="Continuar editando"
                                          class="text-blue-600 hover:text-blue-800">Editar
                                    </Link>
                                </template>
                                <template v-else>
                                    <span class="text-gray-500">Aguardando</span>
                                </template>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="flex items-center justify-center p-4">
                <template v-if="essays.last_page > 1">
                    <nav class="flex items-center space-x-2">
                        <Link v-if="essays.prev_page_url" :href="essays.prev_page_url"
                              class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                            Anterior
                        </Link>
                        <span v-else
                              class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                                Anterior
                            </span>

                        <template v-for="link in essays.links" :key="link.label">
                            <Link
                                v-if="link.url && link.label !== 'pagination.previous' && link.label !== 'pagination.next'"
                                :href="link.url"
                                class="px-3 py-2 text-sm font-medium rounded-md"
                                :class="{
                                          'bg-escreviaPrimary text-white': link.active,
                                          'bg-white text-gray-700 border border-gray-300 hover:bg-gray-100': !link.active
                                      }"
                            >
                                {{ link.label }}
                            </Link>
                        </template>

                        <Link v-if="essays.next_page_url" :href="essays.next_page_url"
                              class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100">
                            Próximo
                        </Link>
                        <span v-else
                              class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 border border-gray-300 rounded-md cursor-not-allowed">
                                Próximo
                            </span>
                    </nav>
                </template>
            </div>
        </div>
    </div>
</template>

<style>
@container(max-width:120px) {
    .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 {
        display: none;
    }
}

@container(max-width:240px) {
    .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 {
        display: none;
    }
}

@container(max-width:360px) {
    .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 {
        display: none;
    }
}

@container(max-width:480px) {
    .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 {
        display: none;
    }
}

@container(max-width:600px) {
    .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 {
        display: none;
    }
}
</style>
