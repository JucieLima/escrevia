<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';

// Define as props que este componente receberá do Laravel/Inertia
const props = defineProps({
    essay: {
        type: Object,
        required: true,
    },
    flash: {
        type: Object,
        default: () => ({ success: null, error: null }),
    },
});

// Função para fechar as mensagens flash
const closeFlash = (type) => {
    props.flash[type] = null;
};

// Computed property para determinar as classes de cor do score geral
const overallScoreClasses = computed(() => {
    let textColorClass = 'text-[#111418]';
    let bgColorClass = 'bg-[#f0f2f5]'; // Cor de fundo padrão

    if (props.essay.overall_score !== null) {
        if (props.essay.overall_score < 500) { // Faixa 0-499
            textColorClass = 'text-escreviaPrimary';
            bgColorClass = 'bg-escreviaPrimary-light';
        } else if (props.essay.overall_score < 700) { // Faixa 500-699
            textColorClass = 'text-escreviaAccent';
            bgColorClass = 'bg-escreviaAccent-light';
        } else if (props.essay.overall_score < 800) { // Faixa 700-799
            textColorClass = 'text-escreviaSecondary';
            bgColorClass = 'bg-escreviaSecondary-light';
        } else { // Faixa 800+
            textColorClass = 'text-green-600';
            bgColorClass = 'bg-green-light';
        }
    }
    return { textColorClass, bgColorClass };
});

// Função para determinar as classes de cor de cada competência
const getCompetencyScoreClasses = (score) => {
    let textColorClass = 'text-[#111418]';
    let bgColorClass = 'bg-white'; // Cor de fundo padrão

    if (score !== null) {
        if (score < 100) { // Faixa 0-99
            textColorClass = 'text-escreviaPrimary';
            bgColorClass = 'bg-escreviaPrimary-light';
        } else if (score < 140) { // Faixa 100-139
            textColorClass = 'text-escreviaAccent';
            bgColorClass = 'bg-escreviaAccent-light';
        } else if (score < 180) { // Faixa 140-179
            textColorClass = 'text-escreviaSecondary';
            bgColorClass = 'bg-escreviaSecondary-light';
        } else { // Faixa 180-200
            textColorClass = 'text-green-600';
            bgColorClass = 'bg-green-light';
        }
    }
    return { textColorClass, bgColorClass };
};

// Computed property para exibir o conteúdo da redação com quebras de linha
const formattedEssayContent = computed(() => {
    return props.essay.content ? props.essay.content.replace(/\r?\n/g, '<br>') : '';
});
</script>

<template>
    <Head title="Feedback da redação" />

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

    <div class="px-0 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
                <p class="text-escreviaSecondary tracking-light text-[32px] font-bold leading-tight min-w-72">
                    Feedback da redação
                </p>
                <Link :href="route('history')"
                      class="inline-flex items-center px-4 py-2 bg-escreviaPrimary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-escreviaPrimary focus:bg-gray-300 active:bg-escreviaAccent focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-200">
                    Voltar para Minhas Redações
                </Link>
            </div>

            <h1 class="text-escreviaSecondary tracking-light text-[28px] font-bold leading-tight px-4 pb-3 pt-5">
                {{ essay.title }}
            </h1>

            <h2 class="text-escreviaSecondary text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Pontuação geral
            </h2>
            <div class="flex flex-wrap gap-4 p-4">
                <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-lg p-6"
                     :class="overallScoreClasses.bgColorClass">
                    <p class="text-[#111418] text-base font-medium leading-normal">Nota Total</p>
                    <p class="tracking-light text-2xl font-bold leading-tight"
                       :class="overallScoreClasses.textColorClass">
                        {{ essay.overall_score !== null ? essay.overall_score : 'Aguardando' }}
                    </p>
                </div>
            </div>

            <h2 class="text-escreviaSecondary text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Feedback detalhado por Competência
            </h2>
            <div class="flex flex-col p-4 gap-3">
                <p v-if="!essay.competency_feedbacks || essay.competency_feedbacks.length === 0"
                   class="text-[#60758a] text-sm font-normal leading-normal px-4">
                    Nenhum feedback por competência disponível ainda.
                </p>
                <template v-else>
                    <details v-for="feedback in essay.competency_feedbacks" :key="feedback.id"
                             class="flex flex-col rounded-lg border border-[#dbe0e6] px-[15px] py-[7px] group"
                             :class="getCompetencyScoreClasses(feedback.score).bgColorClass">
                        <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                            <p class="text-[#111418] text-sm font-medium leading-normal">
                                {{ feedback.competency_name }}
                                <span class="font-normal"
                                      :class="getCompetencyScoreClasses(feedback.score).textColorClass">
                                    ({{ feedback.score !== null ? feedback.score : 'N/A' }}/200)
                                </span>
                            </p>
                            <div class="text-[#111418] group-open:rotate-180">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                     fill="currentColor" viewBox="0 0 256 256">
                                    <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"/>
                                </svg>
                            </div>
                        </summary>
                        <p class="text-[#60758a] text-sm font-normal leading-normal pb-2"
                           v-html="feedback.feedback_text">
                        </p>
                    </details>
                </template>
            </div>

            <h2 class="text-escreviaSecondary text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Sugestões para Melhoria
            </h2>
            <div v-if="essay.ia_feedback"
                 class="flex flex-col p-4 gap-3 bg-gray-50 rounded-lg shadow-sm">
                <div class="prose prose-gray max-w-none text-gray-700" v-html="essay.ia_feedback">
                </div>
            </div>
            <p v-else class="text-[#60758a] text-sm font-normal leading-normal pb-3 pt-1 px-4">
                Nenhuma sugestão de melhoria disponível ainda. A redação pode não ter sido analisada.
            </p>

            <h2 class="text-escreviaSecondary text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5 mt-8">
                Sua Redação enviada
            </h2>
            <section class="bg-white rounded-lg shadow p-6 mx-4 mb-4 relative overflow-hidden">
                <div class="absolute inset-0 pointer-events-none z-0
                            bg-[repeating-linear-gradient(to_bottom,transparent_0_calc(1.5rem_-_1px),#e0e0e0_calc(1.5rem_-_1px)_1.5rem)]
                            [background-position-y:0.75rem]
                            ">
                </div>
                <div class="absolute left-10 inset-y-0 w-[1px] bg-red-400 z-0"></div>
                <h2 class="prose prose-gray max-w-none text-justify text-escreviaSecondary
                                relative z-10 p-4 pl-14 leading-[1.5rem] text-lg font-playwrite-vn mb-4">
                    {{ essay.title }}
                </h2>
                <article class="prose prose-gray max-w-none text-justify text-gray-700
                                relative z-10 p-4 pl-14 leading-[1.5rem] text-xl font-playwrite-vn"
                         v-html="formattedEssayContent">
                </article>
            </section>
        </div>
    </div>
</template>
