{{-- resources/views/history.blade.php --}}
@extends('layouts.app')
@section('title', 'Minhas Redações') {{-- Título da página --}}

@section('content')
    <div class="px-0 flex flex-1 justify-center py-5">
        <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            {{-- Bloco para exibir mensagens de sucesso/erro --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
                    <strong class="font-bold">Sucesso!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mt-4" role="alert">
                    <strong class="font-bold">Erro!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                    <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer" onclick="this.parentElement.style.display='none';">
                <svg class="fill-current h-6 w-6 text-red-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 14.849a1.2 1.2 0 0 1-1.697 0L10 11.819l-2.651 3.029a1.2 1.2 0 1 1-1.697-1.697l2.758-3.15-2.759-3.152a1.2 1.2 0 1 1 1.697-1.697L10 8.183l2.651-3.031a1.2 1.2 0 1 1 1.697 1.697l-2.758 3.152 2.758 3.15a1.2 1.2 0 0 1 0 1.698z"/></svg>
            </span>
                </div>
            @endif
            {{-- Fim do bloco de mensagens --}}
            <div class="flex flex-wrap justify-between gap-3 p-4">
                <p class="text-[#121416] tracking-light text-[32px] font-bold leading-tight min-w-72">Minhas Redações</p>
                {{-- Adicionar um botão "Enviar Nova Redação" aqui também pode ser útil --}}
                <a href="{{ route('submit-essay') }}" class="inline-flex items-center px-4 py-2 bg-escreviaPrimary border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-escreviaAccent focus:bg-escreviaAccent active:bg-escreviaAccent focus:outline-none focus:ring-2 focus:ring-escreviaPrimary focus:ring-offset-2 transition ease-in-out duration-150">
                    Enviar Nova Redação
                </a>
            </div>

            {{-- Botões de filtro (mantidos estáticos por enquanto) --}}
            <div class="flex gap-3 p-3 flex-wrap pr-4">
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Competência</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Nota</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Data</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
                        </svg>
                    </div>
                </button>
                <button class="flex h-8 shrink-0 items-center justify-center gap-x-2 rounded-xl bg-[#f1f2f4] pl-4 pr-2">
                    <p class="text-[#121416] text-sm font-medium leading-normal">Status</p>
                    <div class="text-[#121416]" data-icon="CaretDown" data-size="20px" data-weight="regular">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                            <path d="M213.66,101.66l-80,80a8,8,0,0,1-11.32,0l-80-80A8,8,0,0,1,53.66,90.34L128,164.69l74.34-74.35a8,8,0,0,1,11.32,11.32Z"></path>
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
                        @if($essays->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    Nenhuma redação encontrada.
                                </td>
                            </tr>
                        @else
                            @foreach ($essays as $essay)
                                <tr class="border-t border-t-[#dde1e3]">
                                    <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 h-[72px] px-4 py-2 w-[400px] text-[#121416] text-sm font-normal leading-normal">
                                        {{ $essay->title }}
                                    </td>
                                    <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                        {{ $essay->created_at->format('d/m/Y') }} {{-- Formatando a data --}}
                                    </td>
                                    <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 h-[72px] px-4 py-2 w-[400px] text-[#6a7681] text-sm font-normal leading-normal">
                                        @if($essay->overall_score !== null) {{-- Verifica se a nota não é nula --}}
                                        {{ $essay->overall_score }}/100
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 h-[72px] px-4 py-2 w-60 text-sm font-normal leading-normal">
                                        {{-- Lógica para exibir o status com cores --}}
                                        @php
                                            $statusText = '';
                                            $statusClass = '';
                                            switch ($essay->status) {
                                                case 'draft':
                                                    $statusText = 'Rascunho';
                                                    $statusClass = 'bg-blue-100 text-blue-800';
                                                    break;
                                                case 'pending_correction':
                                                    $statusText = 'Aguardando Correção';
                                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                                    break;
                                                case 'corrected':
                                                    $statusText = 'Concluída';
                                                    $statusClass = 'bg-green-100 text-green-800';
                                                    break;
                                                case 'cancelled':
                                                    $statusText = 'Cancelada';
                                                    $statusClass = 'bg-red-100 text-red-800';
                                                    break;
                                                default:
                                                    $statusText = 'Desconhecido';
                                                    $statusClass = 'bg-gray-100 text-gray-800';
                                                    break;
                                            }
                                        @endphp
                                        <button
                                            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-8 px-4 {{ $statusClass }} text-sm font-medium leading-normal w-full"
                                        >
                                            <span class="truncate">{{ $statusText }}</span>
                                        </button>
                                    </td>
                                    <td class="table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 h-[72px] px-4 py-2 w-60 text-[#6a7681] text-sm font-bold leading-normal tracking-[0.015em]">
                                        @if ($essay->status === 'corrected')
                                            <a href="{{ route('essay-feedback', $essay->id) }}" title="Ver feedback" class="text-escreviaPrimary hover:text-escreviaAccent">Ver Feedback</a>
                                        @elseif ($essay->status === 'draft')
                                            <a href="{{ route('submit-essay', ['essay_id' => $essay->id]) }}" title="Continuar editando" class="text-blue-600 hover:text-blue-800">Editar</a>
                                            {{-- Se você tiver uma rota específica para edição de rascunhos, use-a.
                                            Aqui estou passando o ID para a rota de envio, assumindo que ela pode lidar com edição. --}}
                                        @else
                                            <span class="text-gray-500">Aguardando</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
                {{-- O estilo @container deve ser mantido como está --}}
                <style>
                    @container(max-width:120px) { .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-120 { display: none; } }
                    @container(max-width:240px) { .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-240 { display: none; } }
                    @container(max-width:360px) { .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-360 { display: none; } }
                    @container(max-width:480px) { .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-480 { display: none; } }
                    @container(max-width:600px) { .table-00a6e313-13b0-4aaf-82f6-a32f4d8dbe19-column-600 { display: none; } }
                </style>
            </div>

            {{-- Paginação --}}
            <div class="flex items-center justify-center p-4">
                {{-- Verifica se há mais de uma página para exibir os controles de paginação --}}
                @if ($essays->hasPages())
                    {{ $essays->links('pagination::tailwind') }} {{-- Usa o tema tailwind para a paginação do Laravel --}}
                @endif
            </div>
        </div>
    </div>
@endsection
