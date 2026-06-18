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
- Backoffice com dois perfis distintos: gestor e rececionista
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
1. Clonar o repositorio para a pasta htdocs do MAMP:
   git clone https://github.com/yxsin720/projeto-clube-desportivo.git
2. Iniciar o MAMP (Apache + MySQL)
3. Abrir o phpMyAdmin em http://localhost:8888/phpMyAdmin (ou http://localhost/phpMyAdmin)
4. Criar uma base de dados com o nome clube_desportivo
5. Importar o ficheiro config/database.sql
6. Confirmar as credenciais em config/database.php (host: localhost, user: root, password: root)
7. Aceder no browser a http://localhost/clube-desportivo

## Credenciais de Teste

### Admin (acesso total)
- Email: admin@clube.pt
- Password: admin123
- Permissoes: adicionar campos, gerir atletas, gerir reservas, registar pagamentos, ver estatisticas

### Rececionista (acesso operacional)
- Email: rececionista@clube.pt
- Password: password
- Permissoes: gerir reservas, registar pagamentos, fazer check-in, gerir atletas
- Nao tem acesso a: adicionar campos, estatisticas

### Atleta
- Registar uma conta diretamente em /register.php
- O atleta pode fazer reservas, ver historico e pagamentos

## Perfis de Utilizador
- Gestor: apos login e redirecionado para admin/dashboard.php com acesso total
- Rececionista: apos login e redirecionado para admin/dashboard.php com acesso operacional
- Atleta: apos login e redirecionado para index.php com acesso as suas reservas

## Estrutura de Ficheiros
- index.php - pagina inicial
- login.php - autenticacao
- register.php - registo de atletas
- logout.php - terminar sessao
- about.php - pagina sobre o clube
- campos.php - listagem de campos disponiveis
- reservas.php - gestao de reservas do atleta
- payments.php - historico de pagamentos do atleta
- history.php - historico de reservas do atleta
- admin/dashboard.php - painel de administracao (gestor e rececionista)
- admin/stats.php - relatorios estatisticos (apenas gestor)
- config/database.php - configuracao da ligacao a base de dados
- config/database.sql - estrutura e dados iniciais da base de dados

## Autor
Yassir Shameel Mac-Arthur Latif
Universidade Europeia - Engenharia Informatica
Projeto Desenvolvimento Web - 2025/2026
