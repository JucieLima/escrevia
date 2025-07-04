@extends('layouts.app')
@section('title', 'Feedback da redação')
@section('content')
    <div class="px-0 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p
                    class="text-[#111418] tracking-light text-[32px] font-bold leading-tight min-w-72">Feedback da
                    redação</p>
            </div>
            <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Pontuação geral
            </h2>
            <div class="flex flex-wrap gap-4 p-4">
                <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-lg p-6 bg-[#f0f2f5]">
                    <p class="text-[#111418] text-base font-medium leading-normal">Total Score</p>
                    <p class="text-[#111418] tracking-light text-2xl font-bold leading-tight">840</p>
                </div>
            </div>
            <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Feedback detalhado
            </h2>
            <div class="flex flex-col p-4 gap-3">
                <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                    <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                        <p class="text-[#111418] text-sm font-medium leading-normal">
                            Domínio da Forma Escrita Padrão do Português <span class="text-[#60758a] font-normal">(180/200)</span>
                        </p>
                        <div class="text-[#111418] group-open:rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"/>
                            </svg>
                        </div>
                    </summary>
                    <p class="text-[#60758a] text-sm font-normal leading-normal pb-2">
                        O texto demonstra bom domínio da norma culta da língua portuguesa, com poucos desvios gramaticais e ortográficos. Os erros observados não comprometem a compreensão, o que revela boa maturidade linguística.
                    </p>
                </details>

                <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                    <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                        <p class="text-[#111418] text-sm font-medium leading-normal">
                            Compreensão do tema <span class="text-[#60758a] font-normal">(200/200)</span>
                        </p>
                        <div class="text-[#111418] group-open:rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"/>
                            </svg>
                        </div>
                    </summary>
                    <p class="text-[#60758a] text-sm font-normal leading-normal pb-2">
                        A redação aborda o tema de forma pertinente e consistente, apresentando argumentos que demonstram boa leitura da proposta e senso crítico. O foco do texto é mantido ao longo de toda a argumentação.
                    </p>
                </details>

                <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                    <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                        <p class="text-[#111418] text-sm font-medium leading-normal">
                            Argumentação e Persuasão <span class="text-[#60758a] font-normal">(160/200)</span>
                        </p>
                        <div class="text-[#111418] group-open:rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"/>
                            </svg>
                        </div>
                    </summary>
                    <p class="text-[#60758a] text-sm font-normal leading-normal pb-2">
                        Os argumentos apresentados são bem estruturados e coerentes, utilizando repertório sociocultural produtivo para sustentar as ideias. Há tentativa clara de persuadir o leitor e conduzi-lo a uma reflexão crítica.
                    </p>
                </details>

                <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                    <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                        <p class="text-[#111418] text-sm font-medium leading-normal">
                            Coesão e Coerência Textual <span class="text-[#60758a] font-normal">(180/200)</span>
                        </p>
                        <div class="text-[#111418] group-open:rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"/>
                            </svg>
                        </div>
                    </summary>
                    <p class="text-[#60758a] text-sm font-normal leading-normal pb-2">
                        O texto é bem organizado, com progressão lógica de ideias e uso adequado de conectivos. A transição entre parágrafos contribui para a fluidez da leitura e manutenção da coerência temática.
                    </p>
                </details>

                <details class="flex flex-col rounded-lg border border-[#dbe0e6] bg-white px-[15px] py-[7px] group">
                    <summary class="flex cursor-pointer items-center justify-between gap-6 py-2">
                        <p class="text-[#111418] text-sm font-medium leading-normal">
                            Proposta de Intervenção <span class="text-[#60758a] font-normal">(200/200)</span>
                        </p>
                        <div class="text-[#111418] group-open:rotate-180">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                                <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"/>
                            </svg>
                        </div>
                    </summary>
                    <p class="text-[#60758a] text-sm font-normal leading-normal pb-2">
                        A proposta de intervenção está bem articulada, contemplando agente, ação, meio de execução e detalhamento. Mostra-se viável e coerente com os argumentos desenvolvidos no texto.
                    </p>
                </details>
            </div>
            <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">
                Sugestões para Melhoria
            </h2>
            <p class="text-[#111418] text-base font-normal leading-normal pb-3 pt-1 px-4">
                Revise o feedback fornecido em cada critério para identificar áreas que precisam de melhorias.
                Concentre-se em fortalecer sua argumentação, refinar seu estilo de escrita e garantir que sua proposta
                de intervenção seja detalhada e viável.
            </p>
            <section class="mt-8 bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Redação enviada</h2>
                <article class="prose prose-gray max-w-none text-justify text-gray-700">
                    <p>
                        No mundo contemporâneo, a tecnologia tem desempenhado um papel central na transformação das relações humanas. Nesse contexto, observa-se que o uso excessivo das redes sociais pode causar efeitos negativos na saúde mental dos indivíduos, especialmente entre os jovens. Essa problemática se intensifica devido à falta de educação digital e à pressão por padrões inalcançáveis de sucesso e beleza propagados virtualmente.
                    </p>
                    <p>
                        Em primeiro lugar, a ausência de um preparo educacional voltado para o uso consciente da internet faz com que muitos adolescentes se tornem vulneráveis ao cyberbullying, à dependência tecnológica e à desinformação. De acordo com estudos do Instituto Datafolha, mais de 60% dos jovens brasileiros já se sentiram ansiosos ou deprimidos após longos períodos conectados. Isso evidencia a urgência de iniciativas que ensinem o uso saudável dessas ferramentas.
                    </p>
                    <p>
                        Além disso, as redes sociais promovem uma cultura de comparação constante, onde a felicidade é exibida como obrigação. Essa ilusão de perfeição pode comprometer a autoestima de usuários, gerando frustração, isolamento e até quadros depressivos. A mídia, portanto, tem responsabilidade na construção de narrativas mais realistas e humanas.
                    </p>
                    <p>
                        Diante do exposto, é imprescindível que o Ministério da Educação insira, no currículo escolar, disciplinas de letramento digital que capacitem os alunos a lidar criticamente com as redes. Paralelamente, campanhas públicas devem conscientizar sobre os impactos psicológicos do uso abusivo da internet. Assim, será possível construir uma sociedade mais equilibrada, informada e emocionalmente saudável.
                    </p>
                </article>
            </section>
        </div>
    </div>
@endsection
