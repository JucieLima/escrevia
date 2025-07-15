<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserChat; // Certifique-se de usar o nome correto do seu modelo de chat
use Illuminate\Support\Str; // Para gerar session_id (opcional, pode vir do frontend)

class MilenaChatbotService
{
    /**
     * Inicia a interação da Milena após o login do usuário.
     *
     * @param User $user
     * @return array
     */
    public function startUserSession(User $user): array
    {
        // Verifica a última interação da Milena para o usuário
        $lastMilenaMessage = UserChat::where('user_id', $user->id)
            ->where('role', 'assistant')
            ->latest()
            ->first();

        // Se não houver interações anteriores ou se a última não for de boas-vindas/meta definida, inicia o fluxo de primeiro login.
        if (!$lastMilenaMessage || $this->shouldInitiateFirstLoginFlow($lastMilenaMessage)) {
            return $this->handleFirstLoginFlow($user);
        }

        // Se o usuário já passou pelo fluxo inicial, pode-se implementar lógicas para:
        // - Continuar uma conversa anterior (se 'session_id' for o mesmo)
        // - Oferecer ajuda contextual
        // - Perguntar se quer continuar aprimorando
        return $this->handleReturningUser($user, $lastMilenaMessage);
    }

    /**
     * Lida com o fluxo de primeiro login do usuário.
     *
     * @param User $user
     * @return array
     */
    protected function handleFirstLoginFlow(User $user): array
    {
        // Gerar um novo session_id para o início desta conversa de "boas-vindas"
        $sessionId = (string) Str::uuid();

        // 1. Mensagem de Boas-Vindas da Milena (SDT: Relacionamento, Autonomia)
        $welcomeMessageContent = "Olá, {$user->name}! Eu sou a Milena, sua assistente de escrita de IA e estou aqui para te ajudar a aprimorar suas redações e buscar a nota mil. Fico muito feliz em ter você aqui!";
        $this->saveMilenaMessage($user, $welcomeMessageContent, 'welcome_message', ['session_id' => $sessionId, 'flow_step' => 'initial_greeting']);

        // 2. Pergunta de Definição de Metas (SDT: Autonomia, Competência)
        $goalPromptContent = "Para começarmos, qual aspecto da sua escrita você mais gostaria de focar em melhorar hoje? (Por exemplo: clareza, gramática, estrutura, argumentação, repertório sociocultural...)";
        $options = [
            'Clareza', 'Gramática', 'Estrutura', 'Argumentação', 'Repertório Sociocultural', 'Outro'
        ];
        $this->saveMilenaMessage($user, $goalPromptContent, 'goal_setting_prompt', ['session_id' => $sessionId, 'flow_step' => 'prompt_sent', 'options' => $options]);

        return [
            'message' => $goalPromptContent,
            'options' => $options,
            'session_id' => $sessionId, // Retorna o session_id para o frontend
            'milena_state' => 'awaiting_goal_response' // Estado para o frontend (opcional)
        ];
    }

    /**
     * Lida com as respostas do usuário e continua o fluxo da conversa.
     *
     * @param User $user
     * @param string $userMessageContent
     * @param string|null $sessionId
     * @return array
     */
    public function handleUserResponse(User $user, string $userMessageContent, ?string $sessionId): array
    {
        // Salva a mensagem do usuário
        $this->saveUserMessage($user, $userMessageContent, $sessionId);

        // Busca a última mensagem da Milena para entender o contexto
        $lastMilenaMessage = UserChat::where('user_id', $user->id)
            ->where('role', 'assistant')
            ->where('session_id', $sessionId) // Importante para contexto de sessão
            ->latest()
            ->first();

        // Se não houver contexto claro, retorna uma mensagem padrão ou de erro
        if (!$lastMilenaMessage || !isset($lastMilenaMessage->context_data['flow_step'])) {
            return ['message' => "Desculpe, não consegui entender o contexto. Você pode começar uma nova conversa ou me dizer como posso ajudar?", 'milena_state' => 'idle'];
        }

        $flowStep = $lastMilenaMessage->context_data['flow_step'];

        switch ($flowStep) {
            case 'prompt_sent': // Milena perguntou sobre a meta
                return $this->processGoalResponse($user, $userMessageContent, $sessionId);
            case 'tour_offer_sent': // Milena ofereceu o tour
                return $this->processTourResponse($user, $userMessageContent, $sessionId);
            // ... adicione outros casos para diferentes etapas do fluxo
            default:
                // Lógica para interações gerais após o fluxo inicial
                return $this->handleGeneralUserQuery($user, $userMessageContent, $sessionId);
        }
    }

    /**
     * Processa a resposta do usuário à pergunta de meta.
     * @param User $user
     * @param string $goalResponse
     * @param string $sessionId
     * @return array
     */
    protected function processGoalResponse(User $user, string $goalResponse, string $sessionId): array
    {
        // Aqui você pode validar ou normalizar a 'goalResponse'
        $selectedGoal = $goalResponse; // Para simplificar, estamos usando a resposta direta

        // Salva a confirmação da meta (SDT: Competência, Autonomia)
        $confirmationMessage = "Entendido! Você quer focar em **{$selectedGoal}**. É uma ótima escolha para aprimorar sua escrita!";
        $this->saveMilenaMessage($user, $confirmationMessage, 'goal_confirmation', ['session_id' => $sessionId, 'flow_step' => 'goal_confirmed', 'selected_goal' => $selectedGoal]);

        // Oferece o tour (SDT: Competência, Autonomia)
        $tourOffer = "Quer que eu te mostre rapidamente como funciona? É bem simples: você envia sua redação, eu a analiso e te dou um feedback detalhado para você melhorar. Ou prefere explorar por conta própria?";
        $options = ['Sim, por favor!', 'Não, obrigado, quero explorar.'];
        $this->saveMilenaMessage($user, $tourOffer, 'tour_offer', ['session_id' => $sessionId, 'flow_step' => 'tour_offer_sent', 'options' => $options]);

        return [
            'message' => $tourOffer,
            'options' => $options,
            'session_id' => $sessionId,
            'milena_state' => 'awaiting_tour_response'
        ];
    }

    /**
     * Processa a resposta do usuário à oferta de tour.
     * @param User $user
     * @param string $tourResponse
     * @param string $sessionId
     * @return array
     */
    protected function processTourResponse(User $user, string $tourResponse, string $sessionId): array
    {
        if (Str::contains(mb_strtolower($tourResponse), 'sim') || Str::contains(mb_strtolower($tourResponse), 'sim, por favor')) {
            // Inicia o tour guiado
            $tourContent = "Ótimo! Para começar, clique no botão 'Enviar Redação' no topo da página. Eu vou te guiar passo a passo. Se tiver dúvidas, é só perguntar!";
            $this->saveMilenaMessage($user, $tourContent, 'tour_guided', ['session_id' => $sessionId, 'flow_step' => 'tour_started']);
            return ['message' => $tourContent, 'milena_state' => 'guiding_tour', 'action' => 'redirect_to_upload']; // 'action' para o frontend
        } else {
            // Permite ao usuário explorar por conta própria
            $exploreContent = "Sem problemas! Sinta-se à vontade para explorar. Lembre-se, estou aqui para ajudar sempre que precisar de feedback para sua redação. Quando estiver pronto, é só enviar!";
            $this->saveMilenaMessage($user, $exploreContent, 'tour_skipped', ['session_id' => $sessionId, 'flow_step' => 'tour_skipped']);
            return ['message' => $exploreContent, 'milena_state' => 'idle', 'action' => 'allow_exploration'];
        }
    }

    /**
     * Lógica para usuários que já passaram pelo fluxo inicial.
     * Pode oferecer continuidade, novas funcionalidades, etc.
     * @param User $user
     * @param UserChat $lastMilenaMessage
     * @return array
     */
    protected function handleReturningUser(User $user, UserChat $lastMilenaMessage): array
    {
        // Exemplo: se a última interação foi há muito tempo, re-engajar
        if ($lastMilenaMessage->created_at->diffInDays(now()) > 7) {
            $reengagementMessage = "Olá novamente, {$user->name}! Que bom te ver de volta. Queremos continuar aprimorando suas redações? Se precisar de ajuda ou quiser definir um novo foco, é só me dizer!";
            $this->saveMilenaMessage($user, $reengagementMessage, 'reengagement_prompt', ['session_id' => (string) Str::uuid(), 'flow_step' => 'reengagement_offered']);
            return ['message' => $reengagementMessage, 'milena_state' => 'reengagement'];
        }

        // Caso contrário, uma mensagem padrão ou continuidade da última sessão
        $defaultMessage = "Olá, {$user->name}! O que podemos aprimorar hoje? Se tiver uma redação, pode enviar!";
        return ['message' => $defaultMessage, 'milena_state' => 'idle'];
    }

    /**
     * Determina se o fluxo de primeiro login deve ser iniciado.
     * @param UserChat|null $lastMilenaMessage
     * @return bool
     */
    protected function shouldInitiateFirstLoginFlow(?UserChat $lastMilenaMessage): bool
    {
        if (!$lastMilenaMessage) {
            return true; // Sem interações anteriores
        }
        // Se a última interação não foi sobre boas-vindas, definição de meta ou tour, iniciar o fluxo novamente
        $completedFlowSteps = ['goal_confirmed', 'tour_started', 'tour_skipped'];
        return !in_array($lastMilenaMessage->interaction_type, ['welcome_message', 'goal_setting_prompt', 'tour_offer']) &&
            !in_array($lastMilenaMessage->context_data['flow_step'] ?? null, $completedFlowSteps);
    }


    /**
     * Salva uma mensagem da Milena no histórico do chat.
     *
     * @param User $user
     * @param string $content
     * @param string $type
     * @param array $context
     * @return UserChat
     */
    protected function saveMilenaMessage(User $user, string $content, string $type, array $context): UserChat
    {
        return UserChat::create([
            'user_id' => $user->id,
            'content' => $content,
            'role' => 'assistant',
            'interaction_type' => $type,
            'context_data' => $context,
            'session_id' => $context['session_id'] ?? null, // Garante que o session_id seja salvo
        ]);
    }

    /**
     * Salva uma mensagem do usuário no histórico do chat.
     *
     * @param User $user
     * @param string $content
     * @param string|null $sessionId
     * @return UserChat
     */
    protected function saveUserMessage(User $user, string $content, ?string $sessionId): UserChat
    {
        return UserChat::create([
            'user_id' => $user->id,
            'content' => $content,
            'role' => 'user',
            'interaction_type' => 'user_response', // Ou outro tipo mais específico se desejar
            'context_data' => [], // Respostas de usuário geralmente não precisam de contexto interno complexo, mas podem ter.
            'session_id' => $sessionId,
        ]);
    }

    protected function handleGeneralUserQuery(User $user, string $userMessageContent, ?string $sessionId): array
    {
        // Aqui você pode integrar com a IA de correção para interpretar perguntas
        // ou fornecer respostas padrão se não entender o que o usuário quer.
        $response = "Hmm, me parece que você está buscando ajuda com sua redação! Você pode enviar sua redação para mim ou me dizer algo como 'Me ajude com a gramática', 'Quero melhorar a introdução'.";
        $this->saveMilenaMessage($user, $response, 'general_help_prompt', ['session_id' => $sessionId, 'flow_step' => 'general_help_offered']);
        return ['message' => $response, 'milena_state' => 'idle'];
    }
}
