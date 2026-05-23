# 📡 Documentação da API - Sistema de Gestão Paroquial

Esta API foi desenvolvida para gerenciar usuários, ministérios, eventos, inscrições e mensagens de uma comunidade paroquial.

---

## 🌐 URL Base

```txt
http://localhost:8080
http://localhost:8000

```

---

## 🚀 Instruções Gerais

- **Formato de Dados:** JSON
- **Header Necessário:** `Content-Type: application/json`

---

# 👤 Usuários

### 1. Listar Todos os Usuários

**Endpoint:** `GET /usuarios`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "usuarios": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/usuarios
curl -X GET http://localhost:8000/usuarios
```

---

### 2. Buscar Usuário por ID

**Endpoint:** `GET /usuarios/{idUsuario}`

**Parâmetros de URL:**
- `idUsuario` (int obrigatório)

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/usuarios/1
curl -X GET http://localhost:8000/usuarios/1
```

---

### 3. Criar Usuário

**Endpoint:** `POST /usuarios`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "usuarios": {
    "nomeUsuario": "João Silva",
    "email": "joao@email.com",
    "senha": "123456",
    "tel": "11999998888",
    "tipoUsuario": "ADM",
    "data_nasc": "1990-01-01"
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso"
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/usuarios \
  -H "Content-Type: application/json" \
  -d '{
    "usuarios": {
      "nomeUsuario": "João Silva",
      "email": "joao@email.com",
      "senha": "123456",
      "tel": "11999998888",
      "tipoUsuario": "ADM",
      "data_nasc": "1990-01-01"
    }
  }'
```

---

### 4. Atualizar Usuário

**Endpoint:** `PUT /usuarios/{idUsuario}`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "usuarios": {
    "nomeUsuario": "João Silva Atualizado",
    "email": "novo@email.com",
    "senha": "654321",
    "tel": "11988887777",
    "tipoUsuario": "USER",
    "data_nasc": "1990-01-01"
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/usuarios/1 \
  -H "Content-Type: application/json" \
  -d '{
    "usuarios": {
      "nomeUsuario": "João Silva Atualizado",
      "email": "novo@email.com",
      "senha": "654321",
      "tel": "11988887777",
      "tipoUsuario": "USER",
      "data_nasc": "1990-01-01"
    }
  }'
```

---

### 5. Deletar Usuário

**Endpoint:** `DELETE /usuarios/{idUsuario}`

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/usuarios/1
```

---

### 6. Contar Usuários

**Endpoint:** `GET /usuarios/count`

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/usuarios/count
```

---

# ⛪ Ministérios

### 1. Listar Todos os Ministérios

**Endpoint:** `GET /ministerios`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "ministerios": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/ministerios
```

---

### 2. Buscar Ministério por ID

**Endpoint:** `GET /ministerios/{idMinisterios}`

**Parâmetros de URL:**
- `idMinisterios` (int obrigatório)

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/ministerios/1
```

---

### 3. Criar Ministério

**Endpoint:** `POST /ministerios`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "ministerios": {
    "nome": "Música",
    "descricao": "Coral da Paróquia",
    "diaReuniao": "Sexta-feira",
    "idCoordenador": 1
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso"
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/ministerios \
  -H "Content-Type: application/json" \
  -d '{
    "ministerios": {
      "nome": "Música",
      "descricao": "Coral da Paróquia",
      "diaReuniao": "Sexta-feira",
      "idCoordenador": 1
    }
  }'
```

---

### 4. Atualizar Ministério

**Endpoint:** `PUT /ministerios/{idMinisterios}`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "ministerios": {
    "nome": "Música Atualizado",
    "descricao": "Nova Descrição",
    "diaReuniao": "Sábado",
    "idCoordenador": 2
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/ministerios/1 \
  -H "Content-Type: application/json" \
  -d '{
    "ministerios": {
      "nome": "Música Atualizado",
      "descricao": "Nova Descrição",
      "diaReuniao": "Sábado",
      "idCoordenador": 2
    }
  }'
```

---

### 5. Deletar Ministério

**Endpoint:** `DELETE /ministerios/{idMinisterios}`

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/ministerios/1
```

---

### 6. Contar Ministérios

**Endpoint:** `GET /ministerios/count`

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/ministerios/count
```

---

# 📅 Eventos

### 1. Listar Todos os Eventos

**Endpoint:** `GET /eventos`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "eventos": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/eventos
```

---

### 2. Buscar Evento por ID

**Endpoint:** `GET /eventos/{idEvento}`

**Parâmetros de URL:**
- `idEvento` (int obrigatório)

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/eventos/1
```

---

### 3. Criar Evento

**Endpoint:** `POST /eventos`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "eventos": {
    "titulo": "Retiro Espiritual",
    "descricao": "Retiro de final de semana",
    "dataEvento": "2026-07-01",
    "localEvento": "Sítio da Paz",
    "limiteVagas": 50,
    "statusEvento": "ABERTO"
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso"
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/eventos \
  -H "Content-Type: application/json" \
  -d '{
    "eventos": {
      "titulo": "Retiro Espiritual",
      "descricao": "Retiro de final de semana",
      "dataEvento": "2026-07-01",
      "localEvento": "Sítio da Paz",
      "limiteVagas": 50,
      "statusEvento": "ABERTO"
    }
  }'
```

---

# 📝 Inscrições

### 1. Listar Todas as Inscrições

**Endpoint:** `GET /inscricoes`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "inscricoes": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/inscricoes
```

---

### 2. Buscar Inscrição por ID

**Endpoint:** `GET /inscricoes/{idInscricoes}`

**Parâmetros de URL:**
- `idInscricoes` (int obrigatório)

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/inscricoes/1
```

---

### 3. Criar Inscrição

**Endpoint:** `POST /inscricoes`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "inscricoes": {
    "usuarioId": 1,
    "eventoId": 10,
    "dataInscricao": "2026-05-18",
    "presenca": "CONFIRMADA"
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso"
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/inscricoes \
  -H "Content-Type: application/json" \
  -d '{
    "inscricoes": {
      "usuarioId": 1,
      "eventoId": 10,
      "dataInscricao": "2026-05-18",
      "presenca": "CONFIRMADA"
    }
  }'
```


---

### 4. Atualizar Inscrição

**Endpoint:** `PUT /inscricoes/{idInscricoes}`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "inscricoes": {
    "usuarioId": 1,
    "eventoId": 10,
    "dataInscricao": "2026-05-18",
    "presenca": "CONFIRMADA"
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/inscricoes/1 \
  -H "Content-Type: application/json" \
  -d '{
    "inscricoes": {
      "usuarioId": 1,
      "eventoId": 10,
      "dataInscricao": "2026-05-18",
      "presenca": "CONFIRMADA"
    }
  }'
```

---

### 5. Deletar Inscrição

**Endpoint:** `DELETE /inscricoes/{idInscricoes}`

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/inscricoes/1
```

---

# 💬 Mensagens


### 1. Listar Todas as Mensagens

**Endpoint:** `GET /mensagens`

**Resposta (200 OK):**
```json
{
  "success": true,
  "message": "Busca realizada com sucesso",
  "data": {
    "mensagens": []
  }
}
```

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/mensagens
```

---

### 2. Buscar Mensagem por ID

**Endpoint:** `GET /mensagens/{idMensagens}`

**Parâmetros de URL:**
- `idMensagens` (int obrigatório)

**Exemplo cURL:**
```bash
curl -X GET http://localhost:8080/mensagens/1
```

---

### 3. Criar Mensagem

**Endpoint:** `POST /mensagens`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "mensagens": {
    "titulo": "Aviso Importante",
    "conteudo": "A reunião foi adiada.",
    "usuarioId": 1,
    "dataPostagem": "2026-05-18"
  }
}
```

**Resposta (201 Created):**
```json
{
  "success": true,
  "message": "Cadastro realizado com sucesso"
}
```

**Exemplo cURL:**
```bash
curl -X POST http://localhost:8080/mensagens \
  -H "Content-Type: application/json" \
  -d '{
    "mensagens": {
      "titulo": "Aviso Importante",
      "conteudo": "A reunião foi adiada.",
      "usuarioId": 1,
      "dataPostagem": "2026-05-18"
    }
  }'
```


---

### 4. Atualizar Mensagem

**Endpoint:** `PUT /mensagens/{idMensagens}`

**Cabeçalhos:**
- `Content-Type: application/json`

**Corpo da Requisição:**
```json
{
  "mensagens": {
    "titulo": "Aviso Atualizado",
    "conteudo": "Nova mensagem",
    "usuarioId": 1,
    "dataPostagem": "2026-05-18"
  }
}
```

**Exemplo cURL:**
```bash
curl -X PUT http://localhost:8080/mensagens/1 \
  -H "Content-Type: application/json" \
  -d '{
    "mensagens": {
      "titulo": "Aviso Atualizado",
      "conteudo": "Nova mensagem",
      "usuarioId": 1,
      "dataPostagem": "2026-05-18"
    }
  }'
```

---

### 5. Deletar Mensagem

**Endpoint:** `DELETE /mensagens/{idMensagens}`

**Exemplo cURL:**
```bash
curl -X DELETE http://localhost:8080/mensagens/1
```

---

## 🔄 Códigos HTTP


| Código | Significado |
|--------|--------------|
| 200 | Requisição executada com sucesso |
| 201 | Registro criado com sucesso |
| 204 | Exclusão realizada com sucesso |
| 400 | Erro de validação |
| 404 | Registro não encontrado |
| 500 | Erro interno do servidor |

---

## 📊 Estrutura de Resposta

### Sucesso
```json
{
  "success": true,
  "message": "Descrição do resultado",
  "data": {}
}
```

### Erro
```json
{
  "success": false,
  "message": "Descrição do erro",
  "error": {}
}
```

---

## 🧪 Testando no Postman

1. **Criar Collection**
2. **Definir variável:**
   - `base_url = http://localhost:8080`
3. **Importar endpoints**
4. **Testar operações CRUD**

---

**Última atualização:** 18 de Maio de 2026