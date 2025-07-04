{{-- resources/views/submit-essay.blade.php --}}
@extends('layouts.app')
@section('title', 'Enviar Redação')
@section('content')
<div class="layout-content-container flex flex-col max-w-[960px] flex-1">
    <div class="flex flex-wrap justify-between gap-3 p-4">
        <div class="flex min-w-72 flex-col gap-3">
            <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight">Envie sua redação</p>
            <p class="text-[#60758a] text-sm font-normal leading-normal">Escolha seu método preferido para enviar sua redação para feedback.
                essay for feedback.</p>
        </div>
    </div>
    <div class="pb-3">
        <div class="flex border-b border-[#dbe0e6] px-4 gap-8">
            <a class="flex flex-col items-center justify-center border-b-[3px] border-b-[#111418] text-[#111418] pb-[13px] pt-4"
               href="#">
                <p class="text-[#111418] text-sm font-bold leading-normal tracking-[0.015em]">Carregar PDF</p>
            </a>
            <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#60758a] pb-[13px] pt-4"
               href="#">
                <p class="text-[#60758a] text-sm font-bold leading-normal tracking-[0.015em]">Digitar Redação</p>
            </a>
            <a class="flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#60758a] pb-[13px] pt-4"
               href="#">
                <p class="text-[#60758a] text-sm font-bold leading-normal tracking-[0.015em]">Manuscrito (OCR)</p>
            </a>
        </div>
    </div>
    <div class="flex flex-col p-4">
        <div class="flex flex-col items-center gap-6 rounded-lg border-2 border-dashed border-[#dbe0e6] px-6 py-14">
            <div class="flex max-w-[480px] flex-col items-center gap-2">
                <p class="text-[#111418] text-lg font-bold leading-tight tracking-[-0.015em] max-w-[480px] text-center">
                    Arraste e solte seu PDF aqui</p>
                <p class="text-[#111418] text-sm font-normal leading-normal max-w-[480px] text-center">Ou navegue para selecionar um arquivo do seu computador</p>
            </div>
            <button
                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#f0f2f5] text-[#111418] text-sm font-bold leading-normal tracking-[0.015em]"
            >
                <span class="truncate">Navegar pelos arquivos</span>
            </button>
        </div>
    </div>
    <p class="text-[#60758a] text-sm font-normal leading-normal pb-3 pt-1 px-4 text-center">Tipos de arquivo suportados: PDF. Tamanho máximo do arquivo: 10 MB</p>
    <div class="flex px-4 py-3 justify-center">
        <button
            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#0c7ff2] text-white text-sm font-bold leading-normal tracking-[0.015em]"
        >
            <span class="truncate">Enviar Redação</span>
        </button>
    </div>
</div>
@endsection
