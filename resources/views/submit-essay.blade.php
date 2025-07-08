@extends('layouts.app')
@section('title', 'Enviar Redação')
@section('content')
    <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
        <div class="flex flex-wrap justify-between gap-3 p-4">
            <div class="flex min-w-72 flex-col gap-3">
                <p class="text-escreviaSecondary tracking-light text-[32px] font-bold leading-tight">Envie sua
                    redação</p>
                <p class="text-[#60758a] text-sm font-normal leading-normal">Escolha seu método preferido para enviar
                    sua redação para feedback.</p>
            </div>
        </div>

        {{-- Tabs Navigation --}}
        <div class="pb-3">
            <div class="flex border-b border-[#dbe0e6] px-4 gap-8">
                {{-- Botão para a aba de Carregar PDF --}}
                <button id="tab-pdf"
                        class="tab-button flex flex-col items-center justify-center border-b-[3px] border-b-escreviaSecondary text-escreviaSecondary pb-[13px] pt-4"
                        data-tab="pdf-upload">
                    <p class="text-sm font-bold leading-normal tracking-[0.015em]">Carregar PDF</p>
                </button>

                {{-- Botão para a aba de Digitar Redação --}}
                <button id="tab-type"
                        class="tab-button flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#60758a] pb-[13px] pt-4"
                        data-tab="type-essay">
                    <p class="text-sm font-bold leading-normal tracking-[0.015em]">Digitar Redação</p>
                </button>

                {{-- Botão para a aba de Manuscrito (OCR) --}}
                <button id="tab-handwritten"
                        class="tab-button flex flex-col items-center justify-center border-b-[3px] border-b-transparent text-[#60758a] pb-[13px] pt-4"
                        data-tab="handwritten-ocr">
                    <p class="text-sm font-bold leading-normal tracking-[0.015em]">Manuscrito (OCR)</p>
                </button>
            </div>
        </div>

        {{-- Tabs Content --}}
        <div class="tab-content-container">
            {{-- Conteúdo da aba "Carregar PDF" (Inicialmente visível) --}}
            <div id="pdf-upload" class="tab-pane flex flex-col p-4">
                <div
                    class="flex flex-col items-center gap-6 rounded-lg border-2 border-dashed border-[#dbe0e6] px-6 py-14">
                    <div class="flex max-w-[480px] flex-col items-center gap-2">
                        <p class="text-escreviaSecondary text-lg font-bold leading-tight tracking-[-0.015em] max-w-[480px] text-center">
                            Arraste e solte seu PDF aqui</p>
                        <p class="text-[#111418] text-sm font-normal leading-normal max-w-[480px] text-center">Ou
                            navegue para selecionar um arquivo do seu computador</p>
                    </div>
                    <button
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#f0f2f5] text-[#111418] text-sm font-bold leading-normal tracking-[0.015em]"
                    >
                        <span class="truncate">Navegar pelos arquivos</span>
                    </button>
                </div>
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-3 pt-1 px-4 text-center">Tipos de arquivo
                    suportados: PDF. Tamanho máximo do arquivo: 10 MB</p>
                <div class="flex px-4 py-3 justify-center">
                    <button
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#0c7ff2] text-white text-sm font-bold leading-normal tracking-[0.015em]"
                    >
                        <span class="truncate">Enviar Redação</span>
                    </button>
                </div>
            </div>

            {{-- Conteúdo da aba "Digitar Redação" (Inicialmente oculto) --}}
            <div id="type-essay" class="tab-pane hidden flex flex-col p-4">
                <form action="{{ route('essay.store') }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    <div class="flex flex-col gap-2">
                        <label for="title" class="text-escreviaSecondary text-sm font-semibold">Título da Redação
                            (Opcional)</label>
                        <input type="text" id="title" name="title"
                               class="w-full rounded-lg border px-3 py-2 text-escreviaSecondary font-handwritten
                                  @error('title') border-red-500 @else border-[#dbe0e6] @enderror
                                  focus:border-escreviaSecondary focus:ring focus:ring-escreviaSecondary focus:ring-opacity-50"
                               placeholder="Opcional: Ex: Os desafios da educação no século XXI"
                               value="{{ old('title') }}"> {{-- Repopula o campo --}}
                        @error('title')
                        <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex flex-col gap-2">
                        <label for="content" class="text-escreviaSecondary text-sm font-semibold">Digitar
                            Redação</label>
                        <textarea id="content" name="content" rows="15"
                                  class="w-full rounded-lg border px-3 py-2 text-escreviaSecondary font-handwritten resize-y
                                     @error('content') border-escreviaPrimary @else border-[#dbe0e6] @enderror
                                     focus:border-escreviaSecondary focus:ring focus:ring-escreviaSecondary focus:ring-opacity-50"
                                  placeholder="Comece a digitar sua redação aqui..."
                                  required> {{-- Mantemos o required aqui para o HTML5 --}}
                            {{ old('content') }}</textarea> {{-- Repopula a textarea --}}
                        @error('content')
                        <p class="text-escreviaPrimary text-xs italic mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="flex px-4 py-3 justify-center">
                        <button type="submit"
                                class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-escreviaAccent text-white text-sm font-bold leading-normal tracking-[0.015em]"
                        >
                            <span class="truncate">Enviar Redação Digitada</span>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Conteúdo da aba "Manuscrito (OCR)" (Inicialmente oculto) --}}
            <div id="handwritten-ocr" class="tab-pane hidden flex flex-col p-4">
                <div
                    class="flex flex-col items-center gap-6 rounded-lg border-2 border-dashed border-[#dbe0e6] px-6 py-14">
                    <div class="flex max-w-[480px] flex-col items-center gap-2">
                        <p class="text-escreviaSecondary text-lg font-bold leading-tight tracking-[-0.015em] max-w-[480px] text-center">
                            Em breve: Envie sua redação manuscrita!</p>
                        <p class="text-[#111418] text-sm font-normal leading-normal max-w-[480px] text-center">
                            Converteremos seu texto para digital usando OCR.</p>
                    </div>
                    <button
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#f0f2f5] text-[#111418] text-sm font-bold leading-normal tracking-[0.015em]"
                    >
                        <span class="truncate">Carregar Imagem/PDF Manuscrito</span>
                    </button>
                </div>
                <p class="text-[#60758a] text-sm font-normal leading-normal pb-3 pt-1 px-4 text-center">Tipos de arquivo
                    suportados: JPG, PNG, PDF. Tamanho máximo do arquivo: 10 MB</p>
                <div class="flex px-4 py-3 justify-center">
                    <button
                        class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#0c7ff2] text-white text-sm font-bold leading-normal tracking-[0.015em]"
                    >
                        <span class="truncate">Enviar Manuscrito</span>
                    </button>
                </div>
            </div>
        </div>

    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const tabButtons = document.querySelectorAll('.tab-button');
                const tabPanes = document.querySelectorAll('.tab-pane');

                function activateTab(tabId) {
                    // Remove active styles from all buttons and hide all panes
                    tabButtons.forEach(button => {
                        button.classList.remove('border-b-escreviaSecondary', 'text-escreviaSecondary');
                        button.classList.add('border-b-transparent', 'text-[#60758a]');
                        button.querySelector('p').classList.remove('text-escreviaSecondary');
                        button.querySelector('p').classList.add('text-[#60758a]');
                    });
                    tabPanes.forEach(pane => {
                        pane.classList.add('hidden');
                    });

                    // Add active styles to the clicked button and show the corresponding pane
                    const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
                    if (activeButton) {
                        activeButton.classList.remove('border-b-transparent', 'text-[#60758a]');
                        activeButton.classList.add('border-b-escreviaSecondary', 'text-escreviaSecondary');
                        activeButton.querySelector('p').classList.remove('text-[#60758a]');
                        activeButton.querySelector('p').classList.add('text-escreviaSecondary');
                    }

                    const activePane = document.getElementById(tabId);
                    if (activePane) {
                        activePane.classList.remove('hidden');
                    }
                }

                // Determina qual aba deve ser ativada inicialmente.
                // Se houver erros de validação (especialmente no campo 'content', que é obrigatório),
                // ativamos a aba 'type-essay'. Caso contrário, a 'pdf-upload' (padrão).
                @if ($errors->has('title') || $errors->has('content'))
                activateTab('type-essay');
                @else
                activateTab('pdf-upload');
                @endif

                // Add click event listeners to buttons
                tabButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const tabId = this.dataset.tab;
                        activateTab(tabId);
                    });
                });
            });
        </script>
    @endpush
@endsection
