# Clube Desportivo

## Descricao
Aplicacao web para a gestao integral de um clube desportivo de tenis e padel. Permite que atletas pesquisem e reservem campos, giram e consultem as suas reservas mediante autenticacao, e que a equipa do clube (gestor e rececionista) administre campos, atletas, reservas, registe pagamentos simulados, efetue a confirmacao de comparencia (check-in) e extraia relatorios estatisticos.

## Funcionalidades
- Registo e autenticacao de utilizadores com hashing de password
- Pesquisa e reserva de campos por tipo (Padel Coberto, Padel Descoberto, Tenis Terra Batida, Tenis Rapido)
- Suplementos de iluminacao noturna e aluguer de material (raquetes/bolas)
- Gestao de reservas pelo atleta (listar, editar e cancelar ate 24h antes do jogo)
- Calculo automatico do valor total da reserva com suplementos incluidos
- Registo de pagamentos simulados (parcial ou total)
- Backoffice com dois perfis: gestor e rececionista
- Confirmacao de check-in pelo backoffice
- Gestao de atletas (ativar/inativar)
- Relatorios de ocupacao diaria, estado das reservas, receita por tipo de campo e historico de atletas
- Validacao de sobreposicao de horarios no mesmo campo

## Stack Tecnologica
- HTML5 / CSS - estrutura e estilo das paginas
- JavaScript - calculo dinamico de valores
- PHP - backend e ligacao a base de dados com prepared statements
- MySQL - base de dados relacional
- Apache (MAMP) - servidor local

## Instalacao
1. Clonar o repositorio para a pasta htdocs do MAMP: git clone https://github.com/yxsin720/projeto-clube-desportivo.git
2. Iniciar o MAMP (Apache + MySQL)
3. Abrir o phpMyAdmin em http://localhost/phpMyAdmin
4. Criar uma base de dados com o nome clube_desportivo
5. Importar o ficheiro config/database.sql
6. Confirmar as credenciais em config/database.php
7. Aceder no browser a http://localhost/clube-desportivo

## Credenciais de Teste

### Administrador (Gestor)
- Registar uma conta em /register.php
- No phpMyAdmin alterar o campo role para gestor na tabela users
- O gestor e redirecionado automaticamente para o painel de administracao

### Atleta
- Registar uma conta diretamente em /register.php

## Autor
Yassir Shameel Mac-Arthur Latif
Universidade Europeia - Engenharia Informatica
Projeto Desenvolvimento Web - 2025/2026
