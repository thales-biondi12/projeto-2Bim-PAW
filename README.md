================================================================================
                    RESUMO DO PROJETO - SISTEMA DE GESTÃO PAROQUIAL
================================================================================

🎯 OBJETIVO GERAL
─────────────────────────────────────────────────────────────────────────────
Desenvolveu-se uma API REST moderna para gerenciar todas as atividades 
administrativas de uma comunidade paroquial católica, facilitando o controle 
de usuários, ministérios, eventos e comunicação entre membros.


🛠️ TECNOLOGIAS UTILIZADAS
─────────────────────────────────────────────────────────────────────────────
• Backend: PHP com Framework Slim 4 (micro-framework para APIs REST)
• Banco de Dados: MySQL
• Arquitetura: MVC (Model-View-Controller)
• Segurança: JWT (JSON Web Tokens) para autenticação
• Container: PHP-DI (Injeção de Dependências)
• Testes: PHPUnit
• Servidor: PHP Built-in Server


📊 MÓDULOS IMPLEMENTADOS
─────────────────────────────────────────────────────────────────────────────

1️⃣ GESTÃO DE USUÁRIOS
   • Cadastro, atualização e exclusão de membros
   • Controle de tipos: ADM, COORDENADOR, MEMBRO, VISITANTE
   • Armazenamento de dados: nome, email, telefone, data de nascimento
   • Endpoint: GET/POST/PUT/DELETE /usuarios


2️⃣ MINISTÉRIOS (Grupos Paroquiais)
   • Criação e gerenciamento de ministérios (Música, Catequese, etc.)
   • Atribuição de coordenadores responsáveis
   • Agendamento de dias de reunião
   • Associação de usuários aos ministérios
   • Endpoint: GET/POST/PUT/DELETE /ministerios


3️⃣ EVENTOS
   • Cadastro de eventos paroquiais (retiros, celebrações, encontros)
   • Controle de datas, locais e limite de vagas
   • Status do evento (ABERTO, FECHADO)
   • Gerenciamento de capacidade
   • Endpoint: GET/POST/PUT/DELETE /eventos


4️⃣ INSCRIÇÕES EM EVENTOS
   • Registro de participação de usuários em eventos
   • Controle de presença (CONFIRMADA, AUSENTE, PENDENTE)
   • Validação de limite de vagas
   • Relação many-to-many entre usuários e eventos
   • Endpoint: GET/POST/PUT/DELETE /inscricoes


5️⃣ SISTEMA DE MENSAGENS
   • Publicação de avisos e comunicados importantes
   • Armazenamento com autor e data de postagem
   • Atualização e exclusão de mensagens
   • Título e conteúdo estruturados
   • Endpoint: GET/POST/PUT/DELETE /mensagens


🏗️ ARQUITETURA DO PROJETO
─────────────────────────────────────────────────────────────────────────────
src/api/
├── Controller/      → Controladores que processam requisições HTTP
├── Dao/            → Camada de acesso a dados (Data Access Object)
├── Database/       → Conexão e configuração MySQL
├── Http/           → Respostas HTTP padronizadas
├── Middlewares/    → Filtros e validações de requisições
├── Models/         → Classes de negócio e entidades
├── Router/         → Definição de rotas da API
├── Server/         → Inicialização e configuração do servidor
└── Services/       → Lógica de negócio reutilizável

public/
└── index.php       → Ponto de entrada da aplicação

docs/
└── banco.sql       → Script SQL com schema e dados iniciais


📋 ENDPOINTS DISPONÍVEIS (RESTful)
─────────────────────────────────────────────────────────────────────────────

USUÁRIOS:
  GET /usuarios                    → Listar todos os usuários
  GET /usuarios/{idUsuario}        → Buscar usuário por ID
  GET /usuarios/count              → Contar total de usuários
  POST /usuarios                   → Criar novo usuário
  PUT /usuarios/{idUsuario}        → Atualizar usuário
  DELETE /usuarios/{idUsuario}     → Deletar usuário

MINISTÉRIOS:
  GET /ministerios                 → Listar todos os ministérios
  GET /ministerios/{idMinisterios} → Buscar ministério por ID
  GET /ministerios/count           → Contar total de ministérios
  POST /ministerios                → Criar novo ministério
  PUT /ministerios/{idMinisterios} → Atualizar ministério
  DELETE /ministerios/{idMinisterios} → Deletar ministério

EVENTOS:
  GET /eventos                     → Listar todos os eventos
  GET /eventos/{idEvento}          → Buscar evento por ID
  POST /eventos                    → Criar novo evento
  PUT /eventos/{idEvento}          → Atualizar evento
  DELETE /eventos/{idEvento}       → Deletar evento

INSCRIÇÕES:
  GET /inscricoes                  → Listar todas as inscrições
  GET /inscricoes/{idInscricoes}   → Buscar inscrição por ID
  POST /inscricoes                 → Criar nova inscrição
  PUT /inscricoes/{idInscricoes}   → Atualizar inscrição
  DELETE /inscricoes/{idInscricoes} → Deletar inscrição

MENSAGENS:
  GET /mensagens                   → Listar todas as mensagens
  GET /mensagens/{idMensagens}     → Buscar mensagem por ID
  POST /mensagens                  → Criar nova mensagem
  PUT /mensagens/{idMensagens}     → Atualizar mensagem
  DELETE /mensagens/{idMensagens}  → Deletar mensagem


💾 BANCO DE DADOS
─────────────────────────────────────────────────────────────────────────────
Nome do Banco: Web

Tabelas Principais:
  • usuarios              (ID, Nome, Email, Senha, Tel, Data Nascimento, Tipo)
  • ministerios           (ID, Nome, Descrição, Dia Reunião, ID Coordenador)
  • usuarios_ministerios  (ID, ID Usuário, ID Ministério, Data Entrada, Função)
  • eventos              (ID, Título, Descrição, Data, Local, Limite Vagas, Status)
  • inscricoes           (ID, ID Usuário, ID Evento, Data Inscrição, Presença)
  • mensagens            (ID, Título, Conteúdo, ID Usuário, Data Postagem)

Relacionamentos:
  • Chaves estrangeiras garantem integridade referencial
  • Dados de exemplo já inclusos para testes
  • Tipos de usuário: ADM, COORDENADOR, MEMBRO, VISITANTE


🌐 FORMATO DE RESPOSTAS HTTP
─────────────────────────────────────────────────────────────────────────────

SUCESSO:
{
  "success": true,
  "message": "Descrição do resultado",
  "data": { ... }
}

ERRO:
{
  "success": false,
  "message": "Descrição do erro",
  "error": { ... }
}

CÓDIGOS HTTP UTILIZADOS:
  • 200 OK              → Requisição executada com sucesso
  • 201 Created         → Registro criado com sucesso
  • 204 No Content      → Exclusão realizada com sucesso
  • 400 Bad Request     → Erro de validação
  • 404 Not Found       → Registro não encontrado
  • 500 Server Error    → Erro interno do servidor


✨ DIFERENCIAIS E DESTAQUES
─────────────────────────────────────────────────────────────────────────────
✓ Arquitetura profissional com separação de responsabilidades (MVC)
✓ Injeção de Dependências (PHP-DI) para melhor manutenibilidade
✓ API RESTful bem estruturada e documentada
✓ Respostas padronizadas em JSON
✓ Pronto para implementação de autenticação JWT
✓ Código comentado e bem organizado
✓ Fácil expansão com novos módulos
✓ Validação de dados estruturada
✓ Tratamento de erros centralizado
✓ Database layer separada para abstração


🚀 COMO EXECUTAR
─────────────────────────────────────────────────────────────────────────────

1. Instalar dependências:
   composer install

2. Configurar banco de dados:
   • Importar o arquivo docs/banco.sql no MySQL
   • Verificar credenciais em public/index.php

3. Iniciar o servidor:
   composer start
   
   OU
   
   php -S localhost:8080 -t public/
   php -S localhost:8000 -t public/

5. Testar endpoints:
   • Usar Postman, Insomnia ou cURL
   • Consultar API.md para exemplos completos de requisições


📚 DOCUMENTAÇÃO
─────────────────────────────────────────────────────────────────────────────
• API.md → Documentação detalhada de todos os endpoints
• composer.json → Dependências do projeto
• docs/banco.sql → Script de criação do banco de dados


👨‍💻 DESENVOLVIDO POR
─────────────────────────────────────────────────────────────────────────────
Nome: Thales Biondi, Italo Garavelo, Pedro Antoniassi
Data: Maio de 2026
Disciplina: Programação Avançada a Web (2º Bimestre)
Licença: MIT

================================================================================
