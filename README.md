# Escrevia

**Escrevia** é uma plataforma web inteligente para avaliação e feedback de redações, com foco no ENEM. Utiliza Inteligência Artificial para guiar o aluno na melhoria contínua de suas produções textuais, fornecendo análises automáticas, sugestões personalizadas e um agente virtual de aprendizado baseado na Teoria da Autodeterminação (SDT).

![Logo Escrevia](public/images/escrevia.png)

---

## Funcionalidades

-  Correção automática de redações com base nas 5 competências do ENEM
-  Feedback individualizado por competência
-  Agente de IA que interage com o aluno e propõe metas de evolução
-  Histórico de redações com análise de progresso
-  Painel com indicadores de desempenho e evolução
-  Upload ou escrita direta da redação na plataforma
-  Sugestões de intervenção pedagógica baseadas em dados e IA

---

## Tecnologias Utilizadas

- **Laravel 12** (PHP 8.3)
- **Blade** para templates
- **Tailwind CSS** para o design responsivo
- **Livewire** (opcional) para interatividade
- **PostgreSQL** como banco de dados
- **OpenAI / IA própria** para geração de feedback (configurável)
- **Docker** (opcional para ambiente padronizado)

---

## Instalação Local

### Requisitos
- PHP >= 8.3
- Composer
- Node.js + NPM
- Banco de dados (PostgreSQL recomendado)
- Laravel CLI (`laravel`)

### Passos

```bash
git clone https://github.com/seunome/escrevia.git
cd escrevia
cp .env.example .env
composer install
npm install && npm run dev
php artisan key:generate
php artisan migrate
php artisan serve
```
## Público-alvo
- Estudantes do ensino médio (ENEM e vestibulares)
 
## Licença
Este projeto está licenciado sob a [MIT License](#LICENSE).
 
### Contribuindo
Contribuições são bem-vindas! Envie PRs, sugestões ou abra issues para colaborar com a melhoria da plataforma.
 
### Contato
Para dúvidas ou parcerias: contato@escrevia.com

