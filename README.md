# Sistema de Gestão Paroquial

## 🎯 Objetivo Geral

API REST desenvolvida para gerenciamento administrativo de uma comunidade paroquial católica, permitindo o controle de usuários, ministérios, eventos, inscrições e mensagens.

---

# 🛠️ Tecnologias Utilizadas

- PHP
- Slim Framework 4
- MySQL
- MVC
- JWT
- PHP-DI
- PHPUnit

---

# 📊 Módulos do Sistema

## 👥 Usuários
- Cadastro de membros
- Atualização e exclusão
- Controle de permissões:
  - ADM
  - COORDENADOR
  - MEMBRO
  - VISITANTE

## ⛪ Ministérios
- Cadastro de ministérios
- Associação de membros
- Definição de coordenadores
- Controle de reuniões

## 📅 Eventos
- Criação de eventos paroquiais
- Controle de vagas
- Controle de status:
  - ABERTO
  - FECHADO

## 📝 Inscrições
- Participação em eventos
- Controle de presença
- Validação de vagas

## 📢 Mensagens
- Avisos e comunicados
- Controle de autor e data
- Edição e exclusão

---

# 🏗️ Estrutura do Projeto

```bash
src/api/
├── Controller/
├── Dao/
├── Database/
├── Http/
├── Middlewares/
├── Models/
├── Router/
├── Server/
└── Services/

public/
└── index.php

docs/
└── banco.sql
```

---

# 📋 Endpoints REST

## Usuários
```http
GET    /usuarios
POST   /usuarios
PUT    /usuarios/{id}
DELETE /usuarios/{id}
```

## Ministérios
```http
GET    /ministerios
POST   /ministerios
PUT    /ministerios/{id}
DELETE /ministerios/{id}
```

## Eventos
```http
GET    /eventos
POST   /eventos
PUT    /eventos/{id}
DELETE /eventos/{id}
```

## Inscrições
```http
GET    /inscricoes
POST   /inscricoes
PUT    /inscricoes/{id}
DELETE /inscricoes/{id}
```

## Mensagens
```http
GET    /mensagens
POST   /mensagens
PUT    /mensagens/{id}
DELETE /mensagens/{id}
```

---

# 💾 Banco de Dados

## Banco
```sql
Web
```

## Tabelas
- usuarios
- ministerios
- usuarios_ministerios
- eventos
- inscricoes
- mensagens

---

# 🌐 Respostas HTTP

## Sucesso
```json
{
  "success": true,
  "message": "Operação realizada com sucesso"
}
```

## Erro
```json
{
  "success": false,
  "message": "Erro na operação"
}
```

---

# 🚀 Como Executar

## Instalar dependências
```bash
composer install
```

## Iniciar servidor
```bash
php -S localhost:8080 -t public/
php -S localhost:8000 -t public/
```

---

# 👨‍💻 Desenvolvido por

- Thales Biondi
- Italo Garavelo
- Pedro Antoniassi

**Disciplina:** Programação Avançada a Web  
**Ano:** 2026
