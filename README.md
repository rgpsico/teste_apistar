# Aplicativo de Catálogo de Filmes com Autenticação e Favoritos

Este é um projeto PHP para listar filmes, autenticar usuários e permitir que eles favoritem filmes. O backend consome uma API de filmes (Star Wars) e inclui um sistema de autenticação simples com suporte a favoritos.

## Tecnologias Utilizadas

- **PHP 7.4**
- **MySQL**
- **Redis** (opcional, para cache de filmes)
- **Bootstrap 5** (frontend)
- **jQuery**

---

## Requisitos

- PHP >= 7.4
- Composer
- MySQL
- Redis (opcional, para cache)
- Um servidor HTTP (Apache ou Nginx recomendado)

---

## Instalação

### 1. Clone o Repositório

```bash
$ git clone https://github.com/rgpsico/teste_apistar
$ cd teste_apistar
```

### 2. Instale as Dependências

```bash
$ composer install
```

### 3. Configure o Banco de Dados

- Crie um banco de dados MySQL:

```sql
CREATE DATABASE nome_do_banco;
```

- Copie o arquivo `.env.example` para `.env` e edite com suas credenciais do banco:

```bash
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=nome_do_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

### 4. Rode as Migrações

```bash
$ php migrate.php
```

Isso criará as tabelas no banco de dados.

### 5. Configure o Redis (opcional)

Certifique-se de que o Redis esteja instalado e em execução. A configuração padrão utiliza:

- **Host**: 127.0.0.1
- **Porta**: 6379

Se necessário, edite o arquivo `.env` para configurar o Redis.

---

## Como Executar o Projeto

### 1. Iniciar o Servidor PHP

```bash
$ php -S localhost:8000 -t public
```

O servidor será iniciado em `http://localhost:8000`.

---

## Funcionalidades

### 1. Listagem de Filmes

- Exibe uma tabela com todos os filmes obtidos da API.
- Ordena os filmes por data de lançamento.

### 2. Autenticação

- Registro e login de usuários.
- Tokens são armazenados no banco de dados.

### 3. Favoritar Filmes

- Apenas usuários autenticados podem favoritar filmes.
- Os favoritos são armazenados no banco de dados e listados separadamente.

### 4. Validação Personalizada

- Sistema de validação criado do zero, permitindo regras como `required`, `unique`, `min`, `max`, entre outras.
- Utiliza **Requests** para centralizar as validações.

### 5. Cache (opcional)

- Filmes podem ser armazenados em cache utilizando o Redis para melhorar o desempenho.

---

## Comandos Disponíveis

### Criar Controllers, Models, Services e Requests

1. Criar um **Controller** e **Service**:

```bash
$ php criar.php criar:controller NomeController
```

2. Criar um **Controller**, **Service** e **Model**:

```bash
$ php criar.php criar:controller NomeController -m NomeModel
```

3. Criar um **Model**:

```bash
$ php criar.php criar:model NomeModel
```

4. Criar um **Request**:

```bash
$ php criar.php criar:request NomeRequest
```

---

## Estrutura do Projeto

```
├── public/
│   ├── index.php       # Entrada da aplicação
├── src/
│   ├── Controllers/    # Controllers da aplicação
│   ├── Models/         # Models da aplicação
│   ├── Services/       # Regras de negócio
│   ├── Middleware/     # Middlewares
│   ├── Views/          # Templates Blade
│   ├── Requests/       # Validações customizadas
│   ├── Validation/     # Classe Validator
├── config/
│   ├── database.php    # Configurações do banco de dados
│   ├── providers.php   # Providers para inicialização
├── migrations/
│   ├── ...             # Arquivos de migração
├── .env                # Configurações do ambiente
├── composer.json       # Dependências do Composer
```

---

## Rotas

### 1. Autenticação

- **Registrar**: `POST /auth/register`
  - Parâmetros: `{ "name": "...", "email": "...", "password": "..." }`
- **Login**: `POST /auth/login`
  - Parâmetros: `{ "email": "...", "password": "..." }`
- **Logout**: `POST /auth/logout`
- **Usuário Atual**: `POST /auth/user`

### 2. Filmes

- **Listar Filmes**: `GET /movies`
- **Detalhes do Filme**: `GET /movies/{id}`

### 3. Favoritos

- **Adicionar Favorito**: `POST /favorites`
  - Parâmetros: `{ "movie_id": "..." }`
- **Listar Favoritos**: `GET /favorites`

---

## Testes

Realize testes manuais via Postman ou cURL para verificar as funcionalidades das rotas.

---

---

## Autor

**Seu Nome**

- Email: rogernevesn@gmail.com
- GitHub: (https://github.com/rgpsico)
