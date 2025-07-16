<script setup>
import {Head} from '@inertiajs/vue3';
import MainLayout from '@/Layouts/MainLayout.vue';
</script>

<template>
    <Head title="Dashboard"/>
    <div class="layout-container flex h-full grow flex-col">
        <div class="px-0 flex flex-1 justify-center py-5">
            <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
                <div class="flex flex-wrap justify-between gap-3 p-4">
                    <div class="flex min-w-72 flex-col gap-3">
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight">Bem-vindo de
                            volta,
                            Juciê!</p>
                        <p class="text-[#60758a] text-sm font-normal leading-normal">Aqui está um resumo do seu
                            progresso e
                            atividades recentes.</p>
                    </div>
                </div>
                <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Progresso geral</h2>
                <div class="flex flex-wrap gap-4 px-4 py-6">
                    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#dbe0e6] p-6">
                        <p class="text-[#111418] text-base font-medium leading-normal">Tendência da pontuação
                            geral</p>
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight truncate">85</p>
                        <div class="flex gap-1">
                            <p class="text-[#60758a] text-base font-normal leading-normal">Últimos 6 meses</p>
                            <p class="text-[#078838] text-base font-medium leading-normal">+5%</p>
                        </div>
                        <div class="flex min-h-[180px] flex-1 flex-col gap-8 py-4">
                            <svg width="100%" height="148" viewBox="-3 0 478 150" fill="none"
                                 xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
                                <path
                                    d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25V149H326.769H0V109Z"
                                    fill="url(#paint0_linear_1131_5935)"
                                ></path>
                                <path
                                    d="M0 109C18.1538 109 18.1538 21 36.3077 21C54.4615 21 54.4615 41 72.6154 41C90.7692 41 90.7692 93 108.923 93C127.077 93 127.077 33 145.231 33C163.385 33 163.385 101 181.538 101C199.692 101 199.692 61 217.846 61C236 61 236 45 254.154 45C272.308 45 272.308 121 290.462 121C308.615 121 308.615 149 326.769 149C344.923 149 344.923 1 363.077 1C381.231 1 381.231 81 399.385 81C417.538 81 417.538 129 435.692 129C453.846 129 453.846 25 472 25"
                                    stroke="#60758a"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                ></path>
                                <defs>
                                    <linearGradient id="paint0_linear_1131_5935" x1="236" y1="1" x2="236" y2="149"
                                                    gradientUnits="userSpaceOnUse">
                                        <stop stop-color="#f0f2f5"></stop>
                                        <stop offset="1" stop-color="#f0f2f5" stop-opacity="0"></stop>
                                    </linearGradient>
                                </defs>
                            </svg>
                            <div class="flex justify-around">
                                <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                    Jan</p>
                                <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                    Fev</p>
                                <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                    Mar</p>
                                <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                    Abr</p>
                                <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                    Mai</p>
                                <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                    Jun</p>
                            </div>
                        </div>
                    </div>
                </div>
                <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Análise de Competências</h2>
                <div class="flex flex-wrap gap-4 px-4 py-6">
                    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#dbe0e6] p-6">
                        <p class="text-[#111418] text-base font-medium leading-normal">Competência 1:
                            Argumentação</p>
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight truncate">90</p>
                        <div class="flex gap-1">
                            <p class="text-[#60758a] text-base font-normal leading-normal">Última Redação</p>
                            <p class="text-[#078838] text-base font-medium leading-normal">+10%</p>
                        </div>
                        <div
                            class="grid min-h-[180px] grid-flow-col gap-6 grid-rows-[1fr_auto] items-end justify-items-center px-3">
                            <div class="border-[#60758a] bg-[#f0f2f5] border-t-2 w-full" style="height: 20%;"></div>
                            <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                Score</p>
                        </div>
                    </div>
                    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#dbe0e6] p-6">
                        <p class="text-[#111418] text-base font-medium leading-normal">Competência 2: Coesão
                            Textual</p>
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight truncate">80</p>
                        <p class="text-[#60758a] text-base font-normal leading-normal">Última Redação</p>
                        <p class="text-[#e73908] text-base font-medium leading-normal">-5%</p>
                        <div
                            class="grid min-h-[180px] grid-flow-col gap-6 grid-rows-[1fr_auto] items-end justify-items-center px-3">
                            <div class="border-[#60758a] bg-[#f0f2f5] border-t-2 w-full" style="height: 70%;"></div>
                            <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                Score</p>
                        </div>
                    </div>
                    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#dbe0e6] p-6">
                        <p class="text-[#111418] text-base font-medium leading-normal">Competência 3: Domínio da
                            Língua</p>
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight truncate">85</p>
                        <p class="text-[#078838] text-base font-medium leading-normal">+2%</p>
                        <div
                            class="grid min-h-[180px] grid-flow-col gap-6 grid-rows-[1fr_auto] items-end justify-items-center px-3">
                            <div class="border-[#60758a] bg-[#f0f2f5] border-t-2 w-full" style="height: 70%;"></div>
                            <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                Pontuação</p>
                        </div>
                    </div>
                </div>
                <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Compare Redações
                </h2>
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                    <label class="flex flex-col min-w-40 flex-1">
                        <select
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 bg-[image:--select-button-svg] placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                        >
                            <option value="one">Selecione 1</option>
                            <option value="two">two</option>
                            <option value="three">three</option>
                        </select>
                    </label>
                </div>
                <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
                    <label class="flex flex-col min-w-40 flex-1">
                        <select
                            class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 bg-[image:--select-button-svg] placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                        >
                            <option value="one">Selecione 2</option>
                            <option value="two">two</option>
                            <option value="three">three</option>
                        </select>
                    </label>
                </div>
                <div class="flex flex-wrap gap-4 px-4 py-6">
                    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#dbe0e6] p-6">
                        <p class="text-[#111418] text-base font-medium leading-normal">Argumentação</p>
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight truncate">90</p>
                        <div class="flex gap-1">
                            <p class="text-[#60758a] text-base font-normal leading-normal">Redação 1</p>
                            <p class="text-[#078838] text-base font-medium leading-normal">+10%</p>
                        </div>
                        <div class="grid min-h-[180px] gap-x-4 gap-y-6 grid-cols-[auto_1fr] items-center py-3">
                            <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                Pontuação</p>
                            <div class="h-full flex-1">
                                <div class="border-[#60758a] bg-[#f0f2f5] border-r-2 h-full"
                                     style="width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#dbe0e6] p-6">
                        <p class="text-[#111418] text-base font-medium leading-normal">Coesão Textual</p>
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight truncate">80</p>
                        <p class="text-[#e73908] text-base font-medium leading-normal">-5%</p>
                        <div class="grid min-h-[180px] gap-x-4 gap-y-6 grid-cols-[auto_1fr] items-center py-3">
                            <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                Pontuação</p>
                            <div class="h-full flex-1">
                                <div class="border-[#60758a] bg-[#f0f2f5] border-r-2 h-full"
                                     style="width: 70%;"></div>
                            </div>
                        </div>
                    </div>
                    <div class="flex min-w-72 flex-1 flex-col gap-2 rounded-lg border border-[#dbe0e6] p-6">
                        <p class="text-[#111418] text-base font-medium leading-normal">Domínio da Língua</p>
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight truncate">85</p>
                        <p class="text-[#078838] text-base font-medium leading-normal">+2%</p>
                        <div class="grid min-h-[180px] gap-x-4 gap-y-6 grid-cols-[auto_1fr] items-center py-3">
                            <p class="text-[#60758a] text-[13px] font-bold leading-normal tracking-[0.015em]">
                                Pontuação</p>
                            <div class="h-full flex-1">
                                <div class="border-[#60758a] bg-[#f0f2f5] border-r-2 h-full"
                                     style="width: 20%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="px-30 flex flex-1 justify-center py-5">
            <div class="layout-content-container flex flex-col max-w-[1200px] flex-1">
                <div class="flex flex-wrap justify-between gap-3 p-4">
                    <div class="flex min-w-72 flex-col gap-3">
                        <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight">Visão geral do
                            desempenho</p>
                        <p class="text-[#60758a] text-sm font-normal leading-normal">Acompanhe seu progresso e
                            identifique áreas que precisam de melhorias.</p>
                    </div>
                </div>
                <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Ações
                    Rápidas</h2>
                <div class="flex justify-stretch">
                    <div class="flex flex-1 gap-3 flex-wrap px-4 py-3 justify-start">
                        <button
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#0c7ff2] text-white text-sm font-bold leading-normal tracking-[0.015em]">
                            <span class="truncate">Enviar Nova Redação</span>
                        </button>
                        <Link :href="route('history')">
                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center
                            overflow-hidden rounded-lg h-10 px-4 bg-[#f0f2f5] text-[#111418] text-sm font-bold
                            leading-normal tracking-[0.015em]">
                            <span class="truncate">Ver Histórico de Redações</span>
                        </Link>
                    </div>
                </div>

                <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Visão
                    Geral do Progresso</h2>
                <div class="flex flex-col gap-3 p-4">
                    <div class="flex gap-6 justify-between">
                        <p class="text-[#111418] text-base font-medium leading-normal">Redações Revisadas</p>
                        <p class="text-[#111418] text-sm font-normal leading-normal">75%</p>
                    </div>
                    <div class="rounded bg-[#dbe0e6]">
                        <div class="h-2 rounded bg-[#111418]" style="width: 75%;"></div>
                    </div>
                    <p class="text-[#60758a] text-sm font-normal leading-normal">Você revisou 75% das suas redações.
                        Continue com o ótimo trabalho!</p>
                </div>
                <div class="flex flex-col gap-3 p-4">
                    <div class="flex gap-6 justify-between">
                        <p class="text-[#111418] text-base font-medium leading-normal">Feedback Recebido</p>
                        <p class="text-[#111418] text-sm font-normal leading-normal">60%</p>
                    </div>
                    <div class="rounded bg-[#dbe0e6]">
                        <div class="h-2 rounded bg-[#111418]" style="width: 60%;"></div>
                    </div>
                    <p class="text-[#60758a] text-sm font-normal leading-normal">Você recebeu feedback em 60% das
                        suas
                        redações. Verifique a seção de feedback para mais detalhes.</p>
                </div>

                <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Atividade
                    Recente</h2>
                <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
                    <div
                        class="text-[#111418] flex items-center justify-center rounded-lg bg-[#f0f2f5] shrink-0 size-12"
                        data-icon="Megaphone" data-size="24px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M240,120a48.05,48.05,0,0,0-48-48H152.2c-2.91-.17-53.62-3.74-101.91-44.24A16,16,0,0,0,24,40V200a16,16,0,0,0,26.29,12.25c37.77-31.68,77-40.76,93.71-43.3v31.72A16,16,0,0,0,151.12,214l11,7.33A16,16,0,0,0,186.5,212l11.77-44.36A48.07,48.07,0,0,0,240,120ZM40,199.93V40h0c42.81,35.91,86.63,45,104,47.24v65.48C126.65,155,82.84,164.07,40,199.93Zm131,8,0,.11-11-7.33V168h21.6ZM192,152H160V88h32a32,32,0,1,1,0,64Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-[#111418] text-base font-medium leading-normal">Feedback Recebido</p>
                        <p class="text-[#60758a] text-sm font-normal leading-normal">Recebeu feedback sobre a
                            redação "O
                            Impacto da Tecnologia na Sociedade"</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
                    <div
                        class="text-[#111418] flex items-center justify-center rounded-lg bg-[#f0f2f5] shrink-0 size-12"
                        data-icon="Upload" data-size="24px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M240,136v64a16,16,0,0,1-16,16H32a16,16,0,0,1-16-16V136a16,16,0,0,1,16-16H80a8,8,0,0,1,0,16H32v64H224V136H176a8,8,0,0,1,0-16h48A16,16,0,0,1,240,136ZM85.66,77.66,120,43.31V128a8,8,0,0,0,16,0V43.31l34.34,34.35a8,8,0,0,0,11.32-11.32l-48-48a8,8,0,0,0-11.32,0l-48,48A8,8,0,0,0,85.66,77.66ZM200,168a12,12,0,1,0-12,12A12,12,0,0,0,200,168Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-[#111418] text-base font-medium leading-normal">Redações Enviadas</p>
                        <p class="text-[#60758a] text-sm font-normal leading-normal"> Nova redação enviado: "O
                            Futuro da
                            Energia Renovável"</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
                    <div
                        class="text-[#111418] flex items-center justify-center rounded-lg bg-[#f0f2f5] shrink-0 size-12"
                        data-icon="CheckCircle" data-size="24px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M173.66,98.34a8,8,0,0,1,0,11.32l-56,56a8,8,0,0,1-11.32,0l-24-24a8,8,0,0,1,11.32-11.32L112,148.69l50.34-50.35A8,8,0,0,1,173.66,98.34ZM232,128A104,104,0,1,1,128,24,104.11,104.11,0,0,1,232,128Zm-16,0a88,88,0,1,0-88,88A88.1,88.1,0,0,0,216,128Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-[#111418] text-base font-medium leading-normal">Redação Revisada</p>
                        <p class="text-[#60758a] text-sm font-normal leading-normal">Sua redação "O Papel da
                            Inteligência
                            Artificial" foi revisado</p>
                    </div>
                </div>

                <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                    Notificações</h2>
                <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
                    <div
                        class="text-[#111418] flex items-center justify-center rounded-lg bg-[#f0f2f5] shrink-0 size-12"
                        data-icon="Bell" data-size="24px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-[#111418] text-base font-medium leading-normal">Novos Recursos</p>
                        <p class="text-[#60758a] text-sm font-normal leading-normal">Novos materiais disponíveis na
                            seção
                            "Recursos"</p>
                    </div>
                </div>

                <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2">
                    <div
                        class="text-[#111418] flex items-center justify-center rounded-lg bg-[#f0f2f5] shrink-0 size-12"
                        data-icon="Bell" data-size="24px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06ZM128,216a24,24,0,0,1-22.62-16h45.24A24,24,0,0,1,128,216ZM48,184c7.7-13.24,16-43.92,16-80a64,64,0,1,1,128,0c0,36.05,8.28,66.73,16,80Z"
                            ></path>
                        </svg>
                    </div>
                    <div class="flex flex-col justify-center">
                        <p class="text-[#111418] text-base font-medium leading-normal">Próxima Oficina</p>
                        <p class="text-[#60758a] text-sm font-normal leading-normal">Oficina sobre "Técnicas
                            Eficazes de
                            Escrita de Redações" em breve</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
