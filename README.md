# Ambiente Social Docker

Este diretório foi criado dentro de `www` para dar base ao app Social com:

- Apache
- PHP 8.4
- PostgreSQL 17
- pgAdmin

## Estrutura

- `app/` — arquivos da aplicação web em PHP
- `Dockerfile` — imagem customizada com suporte ao PostgreSQL
- `docker-compose.yml` — orquestra os serviços
- `.env` — variáveis de ambiente do banco

## Como subir

```bash
cd /data/data/com.termux/files/usr/var/www/social
docker compose up --build
```

## Acessos

- Aplicação web: http://localhost:8080
- pgAdmin: http://localhost:8081
- PostgreSQL: localhost:5432

## Credenciais padrão

Banco:

- Banco: `social_db`
- Usuário: `social_user`
- Senha: `social_password`

pgAdmin:

- Email: `admin@social.local`
- Senha: `admin123`

## Observação

O backend da aplicação Social ainda não foi criado. Este ambiente serve como base para integrar o frontend e o restante da stack conforme a arquitetura do projeto evoluir.
