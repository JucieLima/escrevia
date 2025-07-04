{{-- resources/views/history.blade.php --}}
@extends('layouts.app')
@section('title', 'Histórico de Redações')
@section('content')
    <div class="px-0 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-wrap justify-between gap-3 p-4"><p
                    class="text-[#121416] tracking-light text-[32px] font-bold leading-tight min-w-72">Minhas Redações</p>
            </div>
            <div class="flex gap-3 p-3 flex-wrap pr-4">
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Competência</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Nota</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Data</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
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
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                Os desafios da sustentabilidade diante das mudanças climáticas
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-07-20
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                85/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                O impacto da inteligência artificial nas relações de trabalho
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-07-15
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                78/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                A importância das fontes de energia renovável para o futuro do planeta
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-07-10
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                92/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                A urbanização e seus efeitos na qualidade de vida nas cidades brasileiras
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-07-05
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                65/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                A saúde global e os desafios no combate a pandemias
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-06-30
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                88/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                Reformas no sistema educacional brasileiro: entraves e perspectivas
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-06-25
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                72/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                A desigualdade econômica como obstáculo para o desenvolvimento social
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-06-20
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                95/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                A polarização política e seus impactos na democracia brasileira
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-06-15
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                58/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                O papel das redes sociais na formação da opinião pública
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-06-10
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                80/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        <tr class="border-t border-t-[#dde1e3]">
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                Os benefícios e os riscos da exploração espacial para a humanidade
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                2024-06-05
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                75/100
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                <button
                                    class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 bg-[#f1f2f4] text-[#121416] text-sm font-medium leading-normal w-full"
                                >
                                    <span class="truncate">Concluída</span>
                                </button>
                            </td>
                            <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                <a href="{{ route('feedback') }}" title="Ver feedback">Ver Feedback</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
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
            </div>
            <div class="flex items-center justify-center p-4">
                <a href="#" class="flex size-10 items-center justify-center">
                    <div class="text-[#121416]" data-icon="CaretLeft" data-size="18px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"></path>
                        </svg>
                    </div>
                </a>
                <a class="text-sm font-bold leading-normal tracking-[0.015em] flex size-10 items-center justify-center text-[#121416] rounded-full bg-[#f1f2f4]"
                   href="#">1</a>
                <a class="text-sm font-normal leading-normal flex size-10 items-center justify-center text-[#121416] rounded-full"
                   href="#">2</a>
                <a class="text-sm font-normal leading-normal flex size-10 items-center justify-center text-[#121416] rounded-full"
                   href="#">3</a>
                <a class="text-sm font-normal leading-normal flex size-10 items-center justify-center text-[#121416] rounded-full"
                   href="#">4</a>
                <a class="text-sm font-normal leading-normal flex size-10 items-center justify-center text-[#121416] rounded-full"
                   href="#">5</a>
                <a href="#" class="flex size-10 items-center justify-center">
                    <div class="text-[#121416]" data-icon="CaretRight" data-size="18px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor"
                             viewBox="0 0 256 256">
                            <path
                                d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path>
                        </svg>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
