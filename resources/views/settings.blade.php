@extends('layouts.app')
@section('title', 'Configurações')
@section('content')
<div class="layout-content-container flex flex-col flex-1">
    <div class="flex flex-wrap justify-between gap-3 p-4"><p
            class="text-[#111418] tracking-light text-[32px] font-bold leading-tight min-w-72">Configurações</p></div>
    <h3 class="text-[#111418] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Perfil</h3>
    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
        <label class="flex flex-col min-w-40 flex-1">
            <p class="text-[#111418] text-base font-medium leading-normal pb-2">Nome</p>
            <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                value=""
            />
        </label>
    </div>
    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
        <label class="flex flex-col min-w-40 flex-1">
            <p class="text-[#111418] text-base font-medium leading-normal pb-2">Email</p>
            <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                value=""
            />
        </label>
    </div>
    <div class="flex max-w-[480px] flex-wrap items-end gap-4 px-4 py-3">
        <label class="flex flex-col min-w-40 flex-1">
            <p class="text-[#111418] text-base font-medium leading-normal pb-2">Senha</p>
            <input
                class="form-input flex w-full min-w-0 flex-1 resize-none overflow-hidden rounded-lg text-[#111418] focus:outline-0 focus:ring-0 border border-[#dbe0e6] bg-white focus:border-[#dbe0e6] h-14 placeholder:text-[#60758a] p-[15px] text-base font-normal leading-normal"
                value=""
            />
        </label>
    </div>
    <h3 class="text-[#111418] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Notificações</h3>
    <div class="flex items-center gap-4 bg-white px-4 min-h-[72px] py-2 justify-between">
        <div class="flex flex-col justify-center">
            <p class="text-[#111418] text-base font-medium leading-normal line-clamp-1">Notificações por email</p>
            <p class="text-[#60758a] text-sm font-normal leading-normal line-clamp-2">Receba notificações por email
                sobre novos feedbacks e atualizações.</p>
        </div>
        <div class="shrink-0">
            <label
                class="relative flex h-[31px] w-[51px] cursor-pointer items-center rounded-full border-none bg-[#f0f2f5] p-0.5 has-[:checked]:justify-end has-[:checked]:bg-[#0c7ff2]"
            >
                <div class="h-full w-[27px] rounded-full bg-white"
                     style="box-shadow: rgba(0, 0, 0, 0.15) 0px 3px 8px, rgba(0, 0, 0, 0.06) 0px 3px 1px;"></div>
                <input type="checkbox" class="invisible absolute"/>
            </label>
        </div>
    </div>
    <div class="flex px-4 py-3 justify-start">
        <button
            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#0c7ff2] text-white text-sm font-bold leading-normal tracking-[0.015em]"
        >
            <span class="truncate">Salvar</span>
        </button>
    </div>
    <h3 class="text-[#111418] text-lg font-bold leading-tight tracking-[-0.015em] px-4 pb-2 pt-4">Conta</h3>
    <div class="flex px-4 py-3 justify-start">
        <button
            class="flex min-w-[84px] max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-lg h-10 px-4 bg-[#f0f2f5] text-[#111418] text-sm font-bold leading-normal tracking-[0.015em]"
        >
            <span class="truncate">Excluir conta</span>
        </button>
    </div>
</div>
@endsection
