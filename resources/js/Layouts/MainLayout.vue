<script setup>
import {ref} from 'vue';
import Chat from '../Pages/Chat.vue'; // Verifique se este caminho está correto para o seu projeto!
import {usePage} from '@inertiajs/vue3';

const page = usePage();
const showingUserDropdown = ref(false);
const toggleUserDropdown = () => {
    showingUserDropdown.value = !showingUserDropdown.value;
};

const showingChatModal = ref(false); // Estado para controlar a visibilidade do modal

const openChatModal = () => {
    showingChatModal.value = true;
};

const closeChatModal = () => {
    showingChatModal.value = false;
};

console.log('showingChatModal:', showingChatModal.value);
</script>

<template>
    <header class="flex items-center justify-between border-b border-[#f0f2f5] px-10 py-3">
        <div class="flex items-center gap-4 text-[#111418]">
            <div class="w-60 h-30">
                <a :href="route('dashboard')">
                    <img :src="'/images/escrevia.png'" alt="Logo Escrevia" class="object-contain w-full h-full">
                </a>
            </div>
        </div>

        <div class="flex flex-1 justify-end gap-8">
            <div class="flex items-center gap-9">
                <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200"
                   :href="route('dashboard')">Início</a>
                <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200"
                   :href="route('history')">Minhas Redações</a>
                <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200"
                   :href="route('submit-essay')">Enviar Redação</a>
                <a class="text-sm font-medium hover:text-escreviaPrimary transition-colors duration-200"
                   :href="route('settings')">Configurações</a>
            </div>

            <button
                class="flex items-center justify-center rounded-lg h-10 bg-[#f0f2f5] text-[#111418] gap-2 text-sm font-bold px-2.5 hover:bg-escreviaBorder transition-colors duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor"
                     viewBox="0 0 256 256">
                    <path
                        d="M221.8,175.94C216.25,166.38,208,139.33,208,104a80,80,0,1,0-160,0c0,35.34-8.26,62.38-13.81,71.94A16,16,0,0,0,48,200H88.81a40,40,0,0,0,78.38,0H208a16,16,0,0,0,13.8-24.06Z"/>
                </svg>
            </button>

            <div v-if="page.props.auth.user" class="relative">
                <button @click="toggleUserDropdown" class="flex items-center gap-2 text-sm font-medium focus:outline-none">
                    <div class="bg-center bg-no-repeat bg-cover rounded-full size-10"
                         :style='`background-image: url("${page.props.auth.user.avatar_url ?? "https://ui-avatars.com/api/?name="+encodeURIComponent(page.props.auth.user.name)+"&color=FFFFFF&background=E94E77"}");`'>
                    </div>
                    <span class="text-escreviaSecondary hidden md:inline">{{ page.props.auth.user.name }}</span>
                </button>

                <div v-show="showingUserDropdown"
                     class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
                    <a :href="route('profile.edit')"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Meu Perfil</a>
                    <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Ajuda</a>
                    <div class="border-t border-gray-100"></div>
                    <form @submit.prevent="route('logout')" method="POST" action="">
                        <button type="submit"
                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-500 hover:text-white">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <main>
        <slot/>
    </main>

    <footer>
        <div class="bg-escreviaSecondary text-escreviaWhite text-center p-4">
            &copy; {{ new Date().getFullYear() }} Escrevia. Todos os direitos reservados.
        </div>
    </footer>

    <button
        @click="openChatModal"
        v-if="!showingChatModal"
        class="fixed bottom-5 right-5
        pb-[10px]
        pr-[10px]
        bg-escreviaPrimary
        text-escreviaWhite
        rounded-full
        w-20 h-20
        flex items-center
        justify-center
        cursor-pointer
        shadow-lg
        hover:bg-pink-600
        transition-colors duration-300"
        title="Abrir Chat"
    >
        <svg fill="#fff" viewBox="0 0 5334 5334" width="60px" height="60px">
        <path d="M2810 4989 c-119 -13 -281 -44 -378 -73 -655 -197 -1164 -710 -1351
        -1366 -199 -698 -8 -1442 504 -1956 316 -317 706 -511 1160 -575 116 -16 383
        -16 505 0 585 78 1090 391 1411 875 473 711 444 1633 -72 2318 -87 116 -275
        301 -396 391 -265 196 -564 320 -898 373 -116 18 -376 25 -485 13z m243 -593
        c43 -18 83 -66 91 -110 9 -50 -23 -121 -64 -144 l-32 -17 6 -69 c3 -38 9 -73
        14 -78 4 -4 36 -13 70 -19 36 -7 84 -25 115 -43 44 -26 76 -36 168 -50 227
        -35 371 -98 485 -211 67 -67 112 -141 162 -267 7 -17 30 -37 62 -53 104 -53
        146 -166 138 -368 -8 -177 -45 -255 -141 -301 -47 -22 -55 -30 -66 -68 -40
        -135 -159 -283 -281 -351 -74 -40 -340 -147 -710 -284 -140 -51 -265 -98 -277
        -103 -16 -7 -27 -5 -42 8 -18 15 -21 30 -23 132 l-3 115 -115 16 c-374 53
        -581 195 -665 457 -15 48 -21 54 -71 78 -107 51 -151 165 -141 369 9 180 41
        248 141 301 38 20 57 36 61 54 3 14 24 63 47 109 97 202 288 319 597 367 92
        14 124 24 168 50 35 21 79 37 123 44 l68 11 7 57 c3 31 8 65 11 74 3 11 -6 23
        -26 35 -102 60 -93 212 15 259 39 17 68 17 108 0z"/>
        <path d="M2760 3614 c-98 -9 -254 -36 -303 -53 -162 -56 -228 -128 -273 -296
        -26 -98 -27 -430 -1 -523 28 -104 57 -159 107 -206 109 -102 264 -141 615
        -152 409 -14 695 40 809 151 84 83 126 238 126 465 0 212 -39 368 -114 457
        -52 61 -194 118 -361 143 -71 11 -522 21 -605 14z m-80 -459 c42 -21 63 -86
        58 -174 -4 -78 -24 -116 -73 -140 -43 -21 -102 2 -126 49 -26 47 -26 171 -1
        220 28 56 85 75 142 45z m740 2 c40 -20 60 -72 60 -157 0 -96 -21 -139 -77
        -159 -33 -12 -43 -12 -68 0 -54 27 -70 61 -70 152 0 48 6 96 14 115 23 54 86
        77 141 49z"/>
        </svg>
    </button>

    <Chat :is-visible="showingChatModal" @close="closeChatModal"/>
</template>
