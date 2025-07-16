@extends('app')
@section('title', 'Editar Redação Rascunho')
@section('content')
    <div class="flex flex-1 justify-center py-5 px-0">
        <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <p class="text-escreviaSecondary tracking-light text-[32px] font-bold leading-tight min-w-72 p-4">
                Editar Redação (Rascunho)
            </p>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mx-4 mb-4"
                     role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mx-4 mb-4"
                     role="alert">
                    <strong class="font-bold">Ops!</strong>
                    <span class="block sm:inline">Houve alguns problemas com sua submissão.</span>
                    <ul class="mt-3 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- O formulário agora envia para a rota de update se você tiver uma, ou continua para store --}}
            {{-- Para rascunhos, vamos focar no auto-save e no botão de submissão final --}}
            <form id="essayForm" action="{{ route('essay.store') }}" method="POST" class="flex flex-col p-4 gap-4">
                @csrf

                {{-- Campo escondido para o ID da redação, se existir (para rascunhos) --}}
                @if(isset($essay) && $essay->id)
                    <input type="hidden" name="essay_id" id="essay_id" value="{{ $essay->id }}">
                @endif

                {{-- Campo para o Título da Redação --}}
                <div class="flex flex-col gap-2">
                    <label for="title" class="text-[#111418] text-base font-medium leading-normal">Título da
                        Redação:</label>
                    <input type="text"
                           id="title"
                           name="title"
                           class="w-full h-12 rounded-lg border border-[#dbe0e6] px-4 py-2
                                  text-[#111418] text-base font-normal leading-normal
                                  focus:outline-none focus:ring-1 focus:ring-escreviaPrimary
                                  focus:border-transparent"
                           placeholder="Ex: Os desafios da educação a distância no Brasil"
                           value="{{ old('title', $essay->title ?? '') }}" {{-- Preenche com o valor da redação --}}
                           required>
                </div>

                {{-- Campo: Tema da Redação --}}
                <div class="flex flex-col gap-2">
                    <label for="theme" class="text-[#111418] text-base font-medium leading-normal">Tema da
                        Redação:</label>
                    <input type="text"
                           id="theme"
                           name="theme"
                           class="w-full h-12 rounded-lg border border-[#dbe0e6] px-4 py-2
                                  text-[#111418] text-base font-normal leading-normal
                                  focus:outline-none focus:ring-1 focus:ring-escreviaPrimary
                                  focus:border-transparent"
                           placeholder="Ex: A importância da leitura na formação do indivíduo"
                           value="{{ old('theme', $essay->theme ?? '') }}" {{-- Preenche com o valor da redação --}}
                           required>
                </div>

                {{-- Campo para o Conteúdo da Redação (Textarea) --}}
                <div class="flex flex-col gap-2">
                    <label for="content" class="text-[#111418] text-base font-medium leading-normal">Conteúdo da
                        Redação:</label>
                    <textarea id="editor"
                              name="content"
                              rows="15"
                              class="w-full min-h-[300px] rounded-lg border border-[#dbe0e6] px-4 py-2
                                     text-[#111418] text-base font-normal leading-normal resize-y
                                     focus:outline-none focus:ring-1 focus:ring-escreviaPrimary
                                     focus:border-transparent"
                              placeholder="Escreva sua redação aqui..."
                    >{{ old('content', $essay->content ?? '') }}</textarea> {{-- Preenche com o valor da redação --}}
                </div>

                <div class="flex justify-end gap-4 mt-4">
                    <button type="submit"
                            name="action"
                            value="draft"
                            class="inline-flex items-center px-6 py-3 bg-gray-200 border border-transparent rounded-md font-semibold text-base text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-200">
                        Salvar Rascunho
                    </button>

                    {{-- Botão Enviar Redação --}}
                    <button type="submit"
                            name="action"
                            value="submit"
                            class="inline-flex items-center px-6 py-3 bg-escreviaPrimary border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest hover:bg-escreviaPrimary focus:bg-gray-300 active:bg-escreviaAccent focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-200">
                        Enviar Redação para Análise
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Script para Salvamento Automático --}}
    @push('scripts')
        <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
        <script>
            let editor; // CKEditor instance
            let autoSaveInterval;
            let lastSavedContent = ''; // Para evitar salvar se o conteúdo não mudou

            // Função para obter ou criar o input hidden para o essay_id
            function getOrCreateEssayIdInput() {
                let essayIdInput = document.getElementById('essay_id');
                if (!essayIdInput) {
                    essayIdInput = document.createElement('input');
                    essayIdInput.type = 'hidden';
                    essayIdInput.name = 'essay_id';
                    essayIdInput.id = 'essay_id';
                    // Adiciona o input ao formulário principal
                    document.getElementById('essayForm').appendChild(essayIdInput);
                }
                return essayIdInput;
            }

            ClassicEditor
                .create(document.querySelector('#editor'), {})
                .then(newEditor => {
                    editor = newEditor;
                    // Inicializa lastSavedContent com o conteúdo atual do editor
                    lastSavedContent = editor.getData();

                    // Inicia o auto-save somente depois que o editor estiver pronto
                    autoSaveInterval = setInterval(saveDraft, 5000); // Salva a cada 5 segundos
                })
                .catch(error => {
                    console.error(error);
                });

            // Função para salvar rascunho
            function saveDraft() {
                const currentContent = editor.getData();
                const title = document.getElementById('title').value;
                const theme = document.getElementById('theme').value;

                // Se nenhum dos campos principais está preenchido, não faz sentido salvar
                if (!title.trim() && !theme.trim() && !currentContent.trim()) {
                    console.log('Todos os campos vazios, pulando auto-save.');
                    return;
                }

                // Verifica se houve mudança significativa para justificar o auto-save
                // Obtemos o essayIdInput aqui para ter certeza que ele existe (ou será criado)
                const essayIdInput = getOrCreateEssayIdInput();

                // Verifica se o conteúdo, título ou tema mudou desde o último salvamento
                const currentEssayId = essayIdInput.value;
                const initialTitle = essayIdInput.dataset.initialTitle || '';
                const initialTheme = essayIdInput.dataset.initialTheme || '';

                if (currentContent === lastSavedContent &&
                    title === initialTitle &&
                    theme === initialTheme) {
                    console.log('Conteúdo, título e tema não alterados, pulando auto-save.');
                    return;
                }

                // Validação básica antes de enviar
                if (!title.trim() || !theme.trim() || !currentContent.trim()) {
                    console.warn('Campos obrigatórios (título, tema, conteúdo) ausentes para auto-salvamento. Pulando.');
                    // Você pode adicionar um feedback visual aqui, se desejar
                    return;
                }

                const formData = new FormData();
                formData.append('title', title);
                formData.append('theme', theme);
                formData.append('content', currentContent);
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Se o essay_id já existe (ou foi recém-criado/inserido), anexa-o
                if (currentEssayId) {
                    formData.append('essay_id', currentEssayId);
                }

                fetch('{{ route('essay.auto-save') }}', { // Usa a rota nomeada
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json',
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw err;
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            console.log('Rascunho salvo com sucesso!');
                            // IMPORTANTE: Se um novo ID foi retornado e o campo está vazio, atualiza
                            if (data.essay_id && essayIdInput.value !== data.essay_id) {
                                essayIdInput.value = data.essay_id; // Define o novo ID
                                console.log('ID da redação atualizado para:', data.essay_id);
                                // Opcional: Atualizar a URL no navegador para refletir o ID da redação
                                // Isso é útil se o usuário quiser copiar a URL de um rascunho
                                // window.history.replaceState(null, null, `/essay/${data.essay_id}/edit`);
                            }
                            lastSavedContent = currentContent; // Atualiza o último conteúdo salvo
                            // Atualiza os atributos de dados para o título e tema iniciais após salvar
                            essayIdInput.dataset.initialTitle = title;
                            essayIdInput.dataset.initialTheme = theme;

                        } else {
                            console.error('Erro ao salvar rascunho automaticamente:', data.message || 'Erro desconhecido.');
                            // Adicione feedback visual para o usuário aqui, se desejar
                        }
                    })
                    .catch(error => {
                        console.error('Erro na requisição de auto-salvamento:', error);
                        if (error.message) {
                            console.error('Detalhes do erro:', error.message);
                        }
                        // Adicione feedback visual de erro para o usuário
                    });
            }

            // Limpa o intervalo ao sair da página (boa prática)
            window.addEventListener('beforeunload', () => {
                clearInterval(autoSaveInterval);
            });

            // Adiciona os atributos de dados para o estado inicial do título e tema
            // Isso é útil para a primeira verificação de "conteúdo não alterado" quando a página carrega
            document.addEventListener('DOMContentLoaded', () => {
                const initialTitle = document.getElementById('title').value;
                const initialTheme = document.getElementById('theme').value;
                const essayIdInput = getOrCreateEssayIdInput(); // Garante que o input exista
                essayIdInput.dataset.initialTitle = initialTitle;
                essayIdInput.dataset.initialTheme = initialTheme;

                // Se houver um ID inicial (editando um rascunho), define lastSavedContent com o conteúdo atual
                if (essayIdInput.value) {
                    lastSavedContent = editor ? editor.getData() : ''; // CKEditor pode não estar pronto ainda
                }
            });

            // Adicionar um listener para o evento 'submit' do formulário
            // Para evitar que o auto-save dispare junto com o submit normal
            document.getElementById('essayForm').addEventListener('submit', function () {
                clearInterval(autoSaveInterval); // Garante que nenhum auto-save pendente seja disparado
            });
        </script>
    @endpush
@endsection
