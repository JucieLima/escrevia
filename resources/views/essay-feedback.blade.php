@extends('app')
@section('title', 'Feedback da redação')
@section('content')
    <div class="px-0 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4">
                <p class="text-escreviaSecondary tracking-light text-[32px] font-bold leading-tight min-w-72">
                    Feedback da redação
                </p>
                {{-- Adicione um botão para voltar à lista de redações --}}
                <a href="{{ route('history') }}"
                   class="inline-flex items-center px-4 py-2 bg-escreviaPrimary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-escreviaPrimary focus:bg-gray-300 active:bg-escreviaAccent focus:outline-none focus:ring-2 focus->ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-200">
                    Voltar para Minhas Redações
                </a>
            </div>

            <h1 class="text-escreviaSecondary tracking-light text-[28px] font-bold leading-tight px-4 pb-3 pt-5">
                {{ $essay->title }}
            </h1>

            <h2 class="text-escreviaSecondary text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Pontuação geral
            </h2>
            <div class="flex flex-wrap gap-4 p-4">
                {{-- Lógica de cor para o Total Score --}}
                @php
                    $overallScoreTextColorClass = 'text-[#111418]'; // Cor padrão da fonte (pode ser ajustado para escreviaSecondary se preferir)
                    $overallScoreBgColorClass = 'bg-[#f0f2f5]'; // Cor de fundo padrão (mantendo o cinza claro se não houver nota)

                    if ($essay->overall_score !== null) {
                        if ($essay->overall_score < 500) { // Faixa 0-499
                            $overallScoreTextColorClass = 'text-escreviaPrimary';
                            $overallScoreBgColorClass = 'bg-escreviaPrimary-light';
                        } elseif ($essay->overall_score < 700) { // Faixa 500-699
                            $overallScoreTextColorClass = 'text-escreviaAccent';
                            $overallScoreBgColorClass = 'bg-escreviaAccent-light';
                        } elseif ($essay->overall_score < 800) { // Faixa 700-799
                            $overallScoreTextColorClass = 'text-escreviaSecondary'; // Corrigido para usar escreviaSecondary
                            $overallScoreBgColorClass = 'bg-escreviaSecondary-light';
                        } else { // Faixa 800+
                            $overallScoreTextColorClass = 'text-green-600';
                            $overallScoreBgColorClass = 'bg-green-light';
                        }
                    }
                @endphp
                {{-- Aplicando a classe de background ao div do card --}}
                <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-lg p-6 {{ $overallScoreBgColorClass }}">
                    <p class="text-[#111418] text-base font-medium leading-normal">Nota Total</p>
                    {{-- Aplicando a classe de cor da fonte à nota --}}
                    <p class="{{ $overallScoreTextColorClass }} tracking-light text-2xl font-bold leading-tight">
                        @if($essay->overall_score !== null)
                            {{ $essay->overall_score }}
                        @else
                            Aguardando
                        @endif
                    </p>
                </div>
            </div>

            {{-- Título "Feedback detalhado por Competência" - AGORA COM escreviaSecondary --}}
            <h2 class="text-escreviaSecondary text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Feedback detalhado por Competência
            </h2>
            <div class="flex flex-col p-4 gap-3">
                @if($essay->competencyFeedbacks->isEmpty())
                    <p class="text-[#60758a] text-sm font-normal leading-normal px-4">
                        Nenhum feedback por competência disponível ainda.
                    </p>
                @else
                    @foreach($essay->competencyFeedbacks as $feedback)
                        @php
                            $competencyScoreTextColorClass = 'text-[#111418]'; // Cor padrão da fonte (pode ser ajustado para escreviaSecondary se preferir)
                            $competencyScoreBgColorClass = 'bg-white'; // Cor de fundo padrão (mantendo branco se não houver nota ou se não cair em faixa)

                            if ($feedback->score !== null) {
                                if ($feedback->score < 100) { // Faixa 0-99
                                    $competencyScoreTextColorClass = 'text-escreviaPrimary';
                                    $competencyScoreBgColorClass = 'bg-escreviaPrimary-light';
                                } elseif ($feedback->score < 140) { // Faixa 100-139
                                    $competencyScoreTextColorClass = 'text-escreviaAccent';
                                    $competencyScoreBgColorClass = 'bg-escreviaAccent-light';
                                } elseif ($feedback->score < 180) { // Faixa 140-179 (ajustado para 180)
                                    $competencyScoreTextColorClass = 'text-escreviaSecondary'; // Corrigido para usar escreviaSecondary
                                    $competencyScoreBgColorClass = 'bg-escreviaSecondary-light';
                                } else { // Faixa 180-200
                                    $competencyScoreTextColorClass = 'text-green-600';
                                    $competencyScoreBgColorClass = 'bg-green-light';
                                }
                            }
                        @endphp
                        {{-- Aplicando a classe de background ao details --}}
                        <details
                                class="flex flex-col rounded-lg border border-[#dbe0e6] px-[15px] py-[7px] group {{ $competencyScoreBgColorClass }}">
                            <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                                <p class="text-[#111418] text-sm font-medium leading-normal">
                                    {{ $feedback->competency_name }}
                                    {{-- Aplicando a classe de cor da fonte à nota da competência --}}
                                    <span class="{{ $competencyScoreTextColorClass }} font-normal">
                                        ({{ $feedback->score }}/200)
                                    </span>
                                </p>
                                <div class="text-[#111418] group-open:rotate-180">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px"
                                         fill="currentColor" viewBox="0 0 256 256">
                                        <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"/>
                                    </svg>
                                </div>
                            </summary>
                            <p class="text-[#60758a] text-sm font-normal leading-normal pb-2">
                                {!! $feedback->feedback_text !!}
                            </p>
                        </details>
                    @endforeach
                @endif
            </div>

            {{-- Título "Sugestões para Melhoria" - AGORA COM escreviaSecondary --}}
            <h2 class="text-escreviaSecondary text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Sugestões para Melhoria
            </h2>
            {{-- NOVO BLOCO: Exibe o ia_feedback da redação --}}
            @if($essay->ia_feedback)
                {{-- A div modificada com padding e background --}}
                <div class="flex flex-col p-4 gap-3 bg-gray-50 rounded-lg shadow-sm">
                    <div class="prose prose-gray max-w-none text-gray-700">
                        {!! $essay->ia_feedback !!}
                    </div>
                </div>
            @else
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-3 pt-1 px-4">
                    Nenhuma sugestão de melhoria disponível ainda. A redação pode não ter sido analisada.
                </p>
            @endif
            {{-- FIM DO NOVO BLOCO --}}

            {{-- Título "Sua Redação enviada" - AGORA COM escreviaSecondary --}}
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
                {{-- Título da redação dentro da seção da redação - AGORA COM escreviaSecondary --}}
                <h2 class="prose prose-gray max-w-none text-justify text-escreviaSecondary
                                relative z-10 p-4 pl-14 leading-[1.5rem] text-lg font-playwrite-vn mb-4">
                    {{$essay->title}}
                </h2>
                <article class="prose prose-gray max-w-none text-justify text-gray-700
                                relative z-10 p-4 pl-14 leading-[1.5rem] text-xl font-playwrite-vn">
                    {!! nl2br($essay->content) !!}
                </article>
            </section>
        </div>
    </div>
@endsection
