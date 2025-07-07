document.addEventListener('DOMContentLoaded', function() {
    // Script para o Dropdown do Usuário
    const userMenuButton = document.getElementById('user-menu-button');
    const userMenuDropdown = document.getElementById('user-menu-dropdown');

    if (userMenuButton && userMenuDropdown) {
        userMenuButton.addEventListener('click', function() {
            userMenuDropdown.classList.toggle('hidden');
        });

        // Fechar o dropdown se clicar fora dele
        document.addEventListener('click', function(event) {
            if (!userMenuButton.contains(event.target) && !userMenuDropdown.contains(event.target)) {
                userMenuDropdown.classList.add('hidden');
            }
        });
    }

    // Adicione outros scripts específicos do dashboard aqui no futuro
    // Ex: scripts para gráficos, filtros, etc.
});
