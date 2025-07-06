@extends('layouts.escrevia') {{-- Extende o layout principal --}}

{{-- Opcional: Sobrescrever metas de SEO específicas para esta página --}}
@section('title', 'Corrija Sua Redação ENEM com IA | Feedback Rápido e Preciso - Escrevia')
@section('description', 'Prepare-se para o ENEM com a plataforma Escrevia, que oferece correção de redação instantânea e detalhada com IA, ideal para estudantes, professores e plataformas de ensino.')
{{-- ... e assim por diante para og_title, twitter_title, etc. --}}

@section('content') {{-- Conteúdo que será injetado no @yield('content') do layout --}}
@include('escrevia.sections.hero')
@include('escrevia.sections.solution')
@include('escrevia.sections.audience')
@include('escrevia.sections.how-it-works')
@include('escrevia.sections.testimonials')
@include('escrevia.sections.call-to-action')
@include('escrevia.sections.faq')
@endsection

{{-- Opcional: Adicionar scripts específicos desta página, se houver --}}
{{-- @push('scripts')
    <script>
        // Seu script específico para esta página, se houver
    </script>
@endpush --}}

{{-- Opcional: Adicionar estilos específicos desta página, se houver --}}
{{-- @push('styles')
    <style>
        /* Seu CSS específico para esta página, se houver */
    </style>
@endpush --}}
